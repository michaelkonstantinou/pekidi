<?php

namespace App\Http\Resources;

use App\Services\DeclarationTotalService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeclarationOverviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $service = new DeclarationTotalService($this->resource);
        $allTotals = $service->calculateTotalValues();
        $allTotals['asset_distribution'] = $service->calculateAssetDistributionChartData($allTotals);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'overview' => $allTotals,

        ];
    }
}
