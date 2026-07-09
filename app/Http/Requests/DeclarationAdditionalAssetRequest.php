<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DeclarationAdditionalAssetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'asset_type' => 'required|string',
            'registration_number' => 'nullable|string',
            'acquisition_type' => 'nullable|string',
            'acquisition_year' => 'nullable|integer|min:1900|max:' . now()->year,
            'value' => 'required|numeric|min:0',
        ];
    }
}
