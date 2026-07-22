<?php

namespace App\Services;

use App\Models\Declaration;

class DeclarationTotalService
{
    private Declaration $declarationUnderReview;

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
        $totalLiabilitiesValue = 0.0;
        $totalValuePerRelation = [];

        foreach ($this->relationColumns as $relation => $column) {
            $snakeRelation = str($relation)->snake()->toString();

            $totalRelationValue = (float) ($this->declarationUnderReview->{"{$snakeRelation}_sum_value"} ?? 0);
            $totalValuePerRelation[$snakeRelation] = [
                'count' => (int) ($this->declarationUnderReview->{"{$snakeRelation}_count"} ?? 0),
                'total_value' => $totalRelationValue,
            ];

            if ($relation !== 'debts') {
                $totalAssetsValue += $totalRelationValue;
            } else {
                $totalLiabilitiesValue += $totalRelationValue;
            }

        }

        return [
            'totals_per_relation' => $totalValuePerRelation,
            'total_assets_value' => $totalAssetsValue,
            'total_liabilities_value' => $totalLiabilitiesValue,
        ];
    }
}
