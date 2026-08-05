<?php

namespace App\Services;

use App\DataObjects\DeclarationDebtPositionSummaryData;
use App\DataObjects\DeclarationPositionSummaryData;
use App\DataObjects\DeclarationTotalsData;
use App\DataObjects\NetWorthData;
use App\Models\Declaration;
use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DeclarationTotalService
{
    private Declaration $declarationUnderReview;

    // Define standard debt types recognized by the backend (sync with front-end)
    protected const ALLOWED_DEBT_TYPES = [
        'mortgage',
        'home_loan',
        'vehicle_loan',
        'business_loan',
        'student_loan',
        'credit_card',
        'tax_debt',
    ];

    /**
     * Map of camelCase relation names to their database value column.
     * Note: 'investments' is dynamically evaluated via DB::raw('quantity * value').
     */
    protected array $relationColumns = [
        'realEstates' => 'current_value',
        'vehicles' => 'value',
        'businesses' => 'value',
        'investments' => 'value',
        'deposits' => 'value',
        'additionalAssets' => 'value',
        'debts' => 'value',
    ];

    public function __construct(int | Declaration $idOrDeclaration)
    {
        if ($idOrDeclaration instanceof Declaration) {
            $this->declarationUnderReview = $idOrDeclaration;
        } else {
            $this->declarationUnderReview = $this->getDeclarationWithTotals($idOrDeclaration);
        }
    }

    public function declarationUnderReview(): Declaration
    {
        return $this->declarationUnderReview;
    }

    /**
     * Fetch declaration with precomputed relationship counts and sums (total, self, self_and_spouse).
     */
    public function getDeclarationWithTotals(int $id): Declaration
    {
        $relations = array_keys($this->relationColumns);

        $query = Declaration::where('id', $id)->withCount($relations);

        foreach ($this->relationColumns as $relation => $valueColumn) {
            $snakeRelation = str($relation)->snake();

            // Use calculated raw column expression for investments, standard column for others
            $targetColumn = ($relation === 'investments')
                ? DB::raw('quantity * value')
                : $valueColumn;

            // Total sum
            $query->withSum("{$relation} as {$snakeRelation}_sum_value", $targetColumn);

            // Sum where owner is 'self'
            $query->withSum(["{$relation} as {$snakeRelation}_sum_value_self" => function (Builder $q) use ($targetColumn) {
                $q->where('owner', 'self');
            }], $targetColumn);

            // Sum where owner is 'self' OR 'spouse'
            $query->withSum(["{$relation} as {$snakeRelation}_sum_value_joint" => function (Builder $q) use ($targetColumn) {
                $q->whereIn('owner', ['self', 'spouse']);
            }], $targetColumn);
        }

        return $query->firstOrFail();
    }

    public function calculateTotalValues(): DeclarationTotalsData
    {
        $totalAssetsValue = 0.0;
        $totalAssetsSelfValue = 0.0;
        $totalAssetsJointValue = 0.0;

        $positions = [];

        // 1. Process Assets & Non-Debt Relations
        foreach ($this->relationColumns as $relation => $column) {
            if ($relation === 'debts') {
                continue;
            }

            $snakeRelation = str($relation)->snake()->toString();
            $camelRelation = str($relation)->camel()->toString();

            $totalRelationValue = (float) ($this->declarationUnderReview->{"{$snakeRelation}_sum_value"} ?? 0);
            $selfRelationValue = (float) ($this->declarationUnderReview->{"{$snakeRelation}_sum_value_self"} ?? 0);
            $jointRelationValue = (float) ($this->declarationUnderReview->{"{$snakeRelation}_sum_value_joint"} ?? 0);

            $positions[$camelRelation] = new DeclarationPositionSummaryData(
                count: (int) ($this->declarationUnderReview->{"{$snakeRelation}_count"} ?? 0),
                totalValue: $totalRelationValue,
                selfValue: $selfRelationValue,
                jointValue: $jointRelationValue,
            );

            $totalAssetsValue += $totalRelationValue;
            $totalAssetsSelfValue += $selfRelationValue;
            $totalAssetsJointValue += $jointRelationValue;
        }

        // Fallback instantiation in case any relation key was missing from $this->relationColumns
        $getPosition = fn(string $key) => $positions[$key] ?? new DeclarationPositionSummaryData();

        // 2. Process Debts
        $debtsSummary = $this->calculateDebtSummary();

        // 3. Return strictly typed DTO
        return new DeclarationTotalsData(
            realEstates: $getPosition('realEstates'),
            vehicles: $getPosition('vehicles'),
            businesses: $getPosition('businesses'),
            investments: $getPosition('investments'),
            deposits: $getPosition('deposits'),
            additionalAssets: $getPosition('additionalAssets'),
            debts: $debtsSummary,
            totalAssetsValue: $totalAssetsValue,
            totalLiabilitiesValue: $debtsSummary->totalValue,
            netWorth: new NetWorthData(
                family: $this->getNetWorth($totalAssetsValue, $debtsSummary->totalValue),
                personal: $this->getNetWorth($totalAssetsSelfValue, $debtsSummary->selfValue),
                joint: $this->getNetWorth($totalAssetsJointValue, $debtsSummary->jointValue),
            ),
        );
    }

    public function calculateAssetDistributionChartData(?DeclarationTotalsData $totalsData = null): array
    {
        $totalsData ??= $this->calculateTotalValues();

        $totalAssets = $totalsData->totalAssetsValue;

        $assetPositions = [
            'real_estates'     => $totalsData->realEstates,
            'vehicles'         => $totalsData->vehicles,
            'businesses'       => $totalsData->businesses,
            'investments'      => $totalsData->investments,
            'deposits'         => $totalsData->deposits,
            'additional_assets'=> $totalsData->additionalAssets,
        ];

        $chartItems = [];
        foreach ($assetPositions as $relation => $position) {
            $value = $position->totalValue;

            if ($value <= 0) {
                continue;
            }

            $percentage = $totalAssets > 0 ? round(($value / $totalAssets) * 100, 2) : 0.0;

            $chartItems[] = [
                'relation' => $relation,
                'total_value' => $value,
                'percentage' => $percentage,
            ];
        }

        return [
            'total_assets_value' => $totalAssets,
            'series' => $chartItems,
        ];
    }

    private function getNetWorth(float $assetsValue, float $liabilitiesValue): float
    {
        return $assetsValue - $liabilitiesValue;
    }

    private function calculateDebtSummary(): DeclarationDebtPositionSummaryData
    {
        $debts = $this->declarationUnderReview->debts;

        $rawDebtsBreakdown = [];
        $totalDebtsCount = 0;
        $totalLiabilitiesValue = 0.0;
        $totalLiabilitiesSelfValue = 0.0;
        $totalLiabilitiesJointValue = 0.0;

        foreach ($debts as $debt) {
            $rawType = $debt->debt_type;
            $normalizedType = in_array($rawType, self::ALLOWED_DEBT_TYPES, true)
                ? $rawType
                : 'other';

            if (!isset($rawDebtsBreakdown[$normalizedType])) {
                $rawDebtsBreakdown[$normalizedType] = [
                    'count' => 0,
                    'total_value' => 0.0,
                    'self_value' => 0.0,
                    'joint_value' => 0.0,
                ];
            }

            $debtValue = (float) $debt->value;
            $owner = $debt->owner;

            $rawDebtsBreakdown[$normalizedType]['count'] += 1;
            $rawDebtsBreakdown[$normalizedType]['total_value'] += $debtValue;
            $totalDebtsCount += 1;
            $totalLiabilitiesValue += $debtValue;

            if ($owner === OwnerType::Self) {
                $rawDebtsBreakdown[$normalizedType]['self_value'] += $debtValue;
                $totalLiabilitiesSelfValue += $debtValue;
            }

            if (in_array($owner, [OwnerType::Self, OwnerType::Spouse], true)) {
                $rawDebtsBreakdown[$normalizedType]['joint_value'] += $debtValue;
                $totalLiabilitiesJointValue += $debtValue;
            }
        }

        $debtsBreakdown = [];
        foreach ($rawDebtsBreakdown as $type => $data) {
            $debtsBreakdown[$type] = new DeclarationPositionSummaryData(
                count: $data['count'],
                totalValue: $data['total_value'],
                selfValue: $data['self_value'],
                jointValue: $data['joint_value'],
            );
        }

        return new DeclarationDebtPositionSummaryData(
            count: $totalDebtsCount,
            totalValue: $totalLiabilitiesValue,
            selfValue: $totalLiabilitiesSelfValue,
            jointValue: $totalLiabilitiesJointValue,
            byType: $debtsBreakdown,
        );
    }
}
