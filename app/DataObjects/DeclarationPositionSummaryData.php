<?php
declare(strict_types=1);

namespace App\DataObjects;

use Illuminate\Contracts\Support\Arrayable;

readonly class DeclarationPositionSummaryData implements Arrayable
{
    public function __construct(
        public int $count = 0,
        public float $totalValue = 0.0,
        public float $selfValue = 0.0,
        public float $jointValue = 0.0,
    ) {}

    public function toArray(): array
    {
        return [
            'count' => $this->count,
            'total_value' => $this->totalValue,
            'self_value' => $this->selfValue,
            'joint_value' => $this->jointValue,
        ];
    }
}
