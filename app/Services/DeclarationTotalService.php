<?php

namespace App\Services;

use App\Models\Declaration;

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
     * Fetch declaration with precomputed relationship counts and sums.
     */
    public function getDeclarationWithTotals(int $id): Declaration
    {
        $relations = array_keys($this->relationColumns);

        $query = Declaration::where('id', $id)->withCount($relations);

        foreach ($this->relationColumns as $relation => $valueColumn) {
            $snakeRelation = str($relation)->snake();
            $query->withSum("{$relation} as {$snakeRelation}_sum_value", $valueColumn);
        }

        return $query->firstOrFail();
    }

    /**
     * Build the structured overview array from an aggregated Declaration instance.
     */
    public function calculateTotalValues(): array
    {
        $totalAssetsValue = 0.0;
        $totalValuePerRelation = [];

        // 1. Calculate all assets
        foreach ($this->relationColumns as $relation => $column) {
            $snakeRelation = str($relation)->snake()->toString();

            $totalRelationValue = (float) ($this->declarationUnderReview->{"{$snakeRelation}_sum_value"} ?? 0);
            $totalValuePerRelation[$snakeRelation] = [
                'count' => (int) ($this->declarationUnderReview->{"{$snakeRelation}_count"} ?? 0),
                'total_value' => $totalRelationValue,
            ];

            if ($relation !== 'debts') {
                $totalAssetsValue += $totalRelationValue;
            }

        }

        // Fetch debts for the declaration
        $debts = $this->declarationUnderReview->debts()->get();

        $debtsBreakdown = [];
        $totalDebtsCount = 0;
        $totalLiabilitiesValue = 0.0;

        // Iterate and normalize debt_type to 'other' if not recognized
        foreach ($debts as $debt) {
            $rawType = $debt->debt_type;
            $normalizedType = in_array($rawType, self::ALLOWED_DEBT_TYPES, true)
                ? $rawType
                : 'other';

            if (!isset($debtsBreakdown[$normalizedType])) {
                $debtsBreakdown[$normalizedType] = [
                    'count' => 0,
                    'total_value' => 0.0,
                ];
            }

            $debtValue = (float) $debt->value;

            $debtsBreakdown[$normalizedType]['count'] += 1;
            $debtsBreakdown[$normalizedType]['total_value'] += $debtValue;

            $totalDebtsCount += 1;
            $totalLiabilitiesValue += $debtValue;
        }

        $totalValuePerRelation['debts'] = [
            'count' => $totalDebtsCount,
            'total_value' => $totalLiabilitiesValue,
            'by_type' => $debtsBreakdown,
        ];

        return [
            'totals_per_relation' => $totalValuePerRelation,
            'total_assets_value' => $totalAssetsValue,
            'total_liabilities_value' => $totalLiabilitiesValue,
        ];
    }
}
