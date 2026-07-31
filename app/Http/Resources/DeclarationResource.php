<?php

namespace App\Http\Resources;

use App\Models\Declaration;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;


/**
 * @property Declaration $resource
 */
class DeclarationResource extends JsonResource
{
    public function toArray(Request $request): array|JsonSerializable|Arrayable
    {
        return parent::toArray($request) + [
            'has_spouse' => $this->resource->hasSpouse(),
            'has_minor_children' => $this->resource->minorChildrenCount() > 0,
            ];
    }
}
