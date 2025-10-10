<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DeclarationRealEstateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location' => ['required', 'string'],
            'real_estate_type' => ['required', 'string'],
            'area' => ['required', 'numeric', 'min:1'],
            'acquisition_type' => ['required', 'string'],
            'acquisition_year' => ['required', 'numeric', 'min:1800', 'max:'.Carbon::now()->year],
            'acquisition_value' => ['required', 'numeric'],
            'current_value' => ['required', 'numeric'],
            'rights_encumbrances' => ['required'],
        ];
    }
}
