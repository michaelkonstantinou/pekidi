<?php

namespace App\Http\Requests;

use App\Types\RelationshipType;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeclarationFamilyMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|min:3',
            'national_id' => ['string', 'min:6', 'required'],
            'born_at' => ['required', 'date'],
            'profession' => 'required|string|min:3',
            'relationship' => ['required', Rule::enum(RelationshipType::class)]
        ];
    }
}
