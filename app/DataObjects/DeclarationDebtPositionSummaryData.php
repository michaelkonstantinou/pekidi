<?php
declare(strict_types=1);

namespace App\DataObjects;

use Illuminate\Contracts\Support\Arrayable;

readonly class DeclarationDebtPositionSummaryData implements Arrayable
{
    /**
     * @param array<string, DeclarationPositionSummaryData> $byType
     */
    public function __construct(
        public int $count = 0,
        public float $totalValue = 0.0,
        public float $selfValue = 0.0,
        public float $jointValue = 0.0,
        public array $byType = [],
    ) {}

    public function toArray(): array
    {
        $formattedByType = array_map(
            fn(DeclarationPositionSummaryData $summary) => $summary->toArray(),
            $this->byType
        );

        return [
            'count' => $this->count,
            'total_value' => $this->totalValue,
            'self_value' => $this->selfValue,
            'joint_value' => $this->jointValue,
            'by_type' => $formattedByType,
        ];
    }
}
