<?php

declare(strict_types=1);

namespace App\DataObjects;

use Illuminate\Contracts\Support\Arrayable;

readonly class DeclarationTotalsData implements Arrayable
{
    public function __construct(
        public DeclarationPositionSummaryData $realEstates,
        public DeclarationPositionSummaryData $vehicles,
        public DeclarationPositionSummaryData $businesses,
        public DeclarationPositionSummaryData $investments,
        public DeclarationPositionSummaryData $deposits,
        public DeclarationPositionSummaryData $additionalAssets,
        public DeclarationDebtPositionSummaryData $debts,
        public float $totalAssetsValue,
        public float $totalLiabilitiesValue,
        public NetWorthData $netWorth,
    ) {}

    /**
     * Convert the DTO to an array (maintaining snake_case keys for API responses).
     */
    public function toArray(): array
    {
        return [
            'totals_per_relation' => [
                'real_estates'     => $this->realEstates->toArray(),
                'vehicles'         => $this->vehicles->toArray(),
                'businesses'       => $this->businesses->toArray(),
                'investments'      => $this->investments->toArray(),
                'deposits'         => $this->deposits->toArray(),
                'additional_assets'=> $this->additionalAssets->toArray(),
                'debts'            => $this->debts->toArray(),
            ],
            'total_assets_value'     => $this->totalAssetsValue,
            'total_liabilities_value' => $this->totalLiabilitiesValue,
            'net_worth'               => $this->netWorth->toArray(),
        ];
    }
}
