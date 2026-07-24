<?php

namespace App\Services;

use App\Models\Declaration;
use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Builder;

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

            // Total sum
            $query->withSum("{$relation} as {$snakeRelation}_sum_value", $valueColumn);

            // Sum where owner is 'self'
            $query->withSum(["{$relation} as {$snakeRelation}_sum_value_self" => function (Builder $q) use ($valueColumn) {
                $q->where('owner', 'self');
            }], $valueColumn);

            // Sum where owner is 'self' OR 'spouse'
            $query->withSum(["{$relation} as {$snakeRelation}_sum_value_joint" => function (Builder $q) use ($valueColumn) {
                $q->whereIn('owner', ['self', 'spouse']);
            }], $valueColumn);
        }

        return $query->firstOrFail();
    }

    /**
     * Build the structured overview array from an aggregated Declaration instance.
     */
    public function calculateTotalValues(): array
    {
        $totalAssetsValue = 0.0;
        $totalAssetsSelfValue = 0.0;
        $totalAssetsJointValue = 0.0;

        $totalValuePerRelation = [];

        // 1. Process Assets & Non-Debt Relations
        foreach ($this->relationColumns as $relation => $column) {
            $snakeRelation = str($relation)->snake()->toString();

            $totalRelationValue = (float) ($this->declarationUnderReview->{"{$snakeRelation}_sum_value"} ?? 0);
            $selfRelationValue = (float) ($this->declarationUnderReview->{"{$snakeRelation}_sum_value_self"} ?? 0);
            $jointRelationValue = (float) ($this->declarationUnderReview->{"{$snakeRelation}_sum_value_joint"} ?? 0);

            $totalValuePerRelation[$snakeRelation] = [
                'count' => (int) ($this->declarationUnderReview->{"{$snakeRelation}_count"} ?? 0),
                'total_value' => $totalRelationValue,
                'self_value' => $selfRelationValue,
                'joint_value' => $jointRelationValue,
            ];

            if ($relation !== 'debts') {
                $totalAssetsValue += $totalRelationValue;
                $totalAssetsSelfValue += $selfRelationValue;
                $totalAssetsJointValue += $jointRelationValue;
            }
        }

        // 2. Process Debts
        $debts = $this->declarationUnderReview->debts;

        $debtsBreakdown = [];
        $totalDebtsCount = 0;
        $totalLiabilitiesValue = 0.0;
        $totalLiabilitiesSelfValue = 0.0;
        $totalLiabilitiesJointValue = 0.0;

        foreach ($debts as $debt) {
            $rawType = $debt->debt_type;
            $normalizedType = in_array($rawType, self::ALLOWED_DEBT_TYPES, true)
                ? $rawType
                : 'other';

            if (!isset($debtsBreakdown[$normalizedType])) {
                $debtsBreakdown[$normalizedType] = [
                    'count' => 0,
                    'total_value' => 0.0,
                    'self_value' => 0.0,
                    'joint_value' => 0.0,
                ];
            }

            $debtValue = (float) $debt->value;
            $owner = $debt->owner;

            // Increment totals
            $debtsBreakdown[$normalizedType]['count'] += 1;
            $debtsBreakdown[$normalizedType]['total_value'] += $debtValue;
            $totalDebtsCount += 1;
            $totalLiabilitiesValue += $debtValue;

            // Increment 'self' liabilities
            if ($owner === OwnerType::Self) {
                $debtsBreakdown[$normalizedType]['self_value'] += $debtValue;
                $totalLiabilitiesSelfValue += $debtValue;
            }

            // Increment 'self' & 'spouse' (joint) liabilities
            if (in_array($owner, [OwnerType::Self, OwnerType::Spouse], true)) {
                $debtsBreakdown[$normalizedType]['joint_value'] += $debtValue;
                $totalLiabilitiesJointValue += $debtValue;
            }
        }

        $totalValuePerRelation['debts'] = [
            'count' => $totalDebtsCount,
            'total_value' => $totalLiabilitiesValue,
            'self_value' => $totalLiabilitiesSelfValue,
            'joint_value' => $totalLiabilitiesJointValue,
            'by_type' => $debtsBreakdown,
        ];

        // 3. Net Worth Calculations
        $netWorthTotal = $totalAssetsValue - $totalLiabilitiesValue;
        $netWorthSelf = $totalAssetsSelfValue - $totalLiabilitiesSelfValue;
        $netWorthJoint = $totalAssetsJointValue - $totalLiabilitiesJointValue;

        return [
            'totals_per_relation' => $totalValuePerRelation,
            'total_assets_value' => $totalAssetsValue,
            'total_liabilities_value' => $totalLiabilitiesValue,
            'net_worth' => [
                'family' => $netWorthTotal,
                'personal' => $netWorthSelf,
                'joint' => $netWorthJoint,
            ],
            'ownership_breakdown' => [
                'self' => [
                    'assets' => $totalAssetsSelfValue,
                    'liabilities' => $totalLiabilitiesSelfValue,
                ],
                'joint' => [
                    'assets' => $totalAssetsJointValue,
                    'liabilities' => $totalLiabilitiesJointValue,
                ],
                'full' => [
                    'assets' => $totalAssetsValue,
                    'liabilities' => $totalLiabilitiesValue,
                ],
            ],
        ];
    }

    /**
     * Generate pre-formatted asset distribution chart data with percentages.
     */
    public function calculateAssetDistributionChartData(?array $totalsData = null): array
    {
        // Reuse precomputed totals if passed, otherwise compute them
        $totalsData = $totalsData ?? $this->calculateTotalValues();

        $totalAssets = (float) ($totalsData['total_assets_value'] ?? 0);
        $totalsPerRelation = $totalsData['totals_per_relation'] ?? [];

        $chartItems = [];

        foreach ($totalsPerRelation as $relation => $data) {
            // Filter out liabilities/debts for asset pie chart
            if ($relation === 'debts') {
                continue;
            }

            $value = (float) ($data['total_value'] ?? 0);

            // Skip relations with zero total value to keep chart rendering clean
            if ($value <= 0) {
                continue;
            }

            // Compute relative share percentage rounded to 2 decimal places
            $percentage = $totalAssets > 0
                ? round(($value / $totalAssets) * 100, 2)
                : 0.0;

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
}
