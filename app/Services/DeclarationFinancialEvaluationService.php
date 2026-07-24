<?php

declare(strict_types=1);

namespace App\Services;

use App\DataObjects\DeclarationTotalsData;

final class DeclarationFinancialEvaluationService
{
    /**
     * @return array{
     *     strengths: array<int, string>,
     *     weaknesses: array<int, string>
     * }
     */
    public function evaluate(DeclarationTotalsData $totals): array
    {
        $strengths = [];
        $weaknesses = [];

        $debtToAssetRatio = $totals->getDebtToAssetRatio();
        $depositAllocation = $totals->getDepositAllocation();
        $investmentAllocation = $totals->getInvestmentAllocation();

        /*
        |--------------------------------------------------------------------------
        | Strengths
        |--------------------------------------------------------------------------
        */

        if ($totals->netWorth->family > 0) {
            $strengths[] = __(
                'financial-evaluation.positive_net_worth',
                [
                    'amount' => $this->formatCurrency(
                        $totals->netWorth->family
                    ),
                ]
            );
        }

        if ($totals->totalLiabilitiesValue === 0.0) {
            $strengths[] = __(
                'financial-evaluation.no_liabilities'
            );
        }

        if (
            $totals->totalLiabilitiesValue > 0
            && $debtToAssetRatio < 30
        ) {
            $strengths[] = __(
                'financial-evaluation.low_debt_ratio',
                [
                    'ratio' => $this->formatPercentage(
                        $debtToAssetRatio
                    ),
                ]
            );
        }

        if ($totals->deposits->totalValue > 0) {
            $strengths[] = __(
                'financial-evaluation.liquid_reserves',
                [
                    'amount' => $this->formatCurrency(
                        $totals->deposits->totalValue
                    ),
                ]
            );
        }

        if ($investmentAllocation >= 10) {
            $strengths[] = __(
                'financial-evaluation.healthy_investment_allocation',
                [
                    'ratio' => $this->formatPercentage(
                        $investmentAllocation
                    ),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Weaknesses
        |--------------------------------------------------------------------------
        */

        if ($totals->netWorth->family < 0) {
            $weaknesses[] = __(
                'financial-evaluation.negative_net_worth',
                [
                    'amount' => $this->formatCurrency(
                        abs($totals->netWorth->family)
                    ),
                ]
            );
        }

        if ($debtToAssetRatio >= 70) {
            $weaknesses[] = __(
                'financial-evaluation.high_debt_ratio',
                [
                    'ratio' => $this->formatPercentage(
                        $debtToAssetRatio
                    ),
                ]
            );
        } elseif ($debtToAssetRatio >= 50) {
            $weaknesses[] = __(
                'financial-evaluation.elevated_debt_ratio',
                [
                    'ratio' => $this->formatPercentage(
                        $debtToAssetRatio
                    ),
                ]
            );
        }

        if ($totals->deposits->totalValue === 0.0) {
            $weaknesses[] = __(
                'financial-evaluation.no_liquid_reserves'
            );
        } elseif ($depositAllocation < 5) {
            $weaknesses[] = __(
                'financial-evaluation.low_liquidity',
                [
                    'ratio' => $this->formatPercentage(
                        $depositAllocation
                    ),
                ]
            );
        }

        if ($investmentAllocation < 1) {
            $weaknesses[] = __(
                'financial-evaluation.low_investment_exposure',
                [
                    'ratio' => $this->formatPercentage(
                        $investmentAllocation
                    ),
                ]
            );
        }

        $largestAssetCategory = $this->largestAssetCategory($totals);

        if ($largestAssetCategory['percentage'] >= 50) {
            $weaknesses[] = __(
                'financial-evaluation.asset_concentration',
                [
                    'category' => __(
                        'financial-evaluation.asset_categories.'
                        . $largestAssetCategory['key']
                    ),
                    'ratio' => $this->formatPercentage(
                        $largestAssetCategory['percentage']
                    ),
                ]
            );
        }

        $otherDebt = $totals->debts->byType['other']->totalValue ?? 0.0;

        if ($otherDebt > 0) {
            $weaknesses[] = __(
                'financial-evaluation.other_debt',
                [
                    'amount' => $this->formatCurrency($otherDebt),
                ]
            );
        }

        return [
            'strengths' => array_slice($strengths, 0, 5),
            'weaknesses' => array_slice($weaknesses, 0, 5),
        ];
    }

    /**
     * @return array{key: string, value: float, percentage: float}
     */
    private function largestAssetCategory(
        DeclarationTotalsData $totals
    ): array {
        $categories = [
            'real_estates' => $totals->realEstates->totalValue,
            'vehicles' => $totals->vehicles->totalValue,
            'businesses' => $totals->businesses->totalValue,
            'investments' => $totals->investments->totalValue,
            'deposits' => $totals->deposits->totalValue,
            'additional_assets' => $totals->additionalAssets->totalValue,
        ];

        $largestKey = array_key_first($categories);
        $largestValue = $categories[$largestKey];

        foreach ($categories as $key => $value) {
            if ($value > $largestValue) {
                $largestKey = $key;
                $largestValue = $value;
            }
        }

        return [
            'key' => $largestKey,
            'value' => $largestValue,
            'percentage' => $totals->totalAssetsValue > 0
                ? ($largestValue / $totals->totalAssetsValue) * 100
                : 0.0,
        ];
    }

    private function formatCurrency(float $value): string
    {
        return number_format($value, 2, ',', '.') . ' €';
    }

    private function formatPercentage(float $value): string
    {
        return number_format($value, 1, ',', '.') . '%';
    }
}
