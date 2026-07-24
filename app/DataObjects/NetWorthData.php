<?php

namespace App\DataObjects;

use Illuminate\Contracts\Support\Arrayable;

readonly class NetWorthData implements Arrayable
{
    public function __construct(
        public float $family,
        public float $personal,
        public float $joint,
    ) {}

    public function toArray(): array
    {
        return [
            'family' => $this->family,
            'personal' => $this->personal,
            'joint' => $this->joint,
        ];
    }
}
