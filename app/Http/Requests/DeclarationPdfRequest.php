<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $document_type
 * @property boolean $include_personal
 * @property boolean $include_spouse
 * @property boolean $include_children
 */
class DeclarationPdfRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'document_type' => ['sometimes', 'string', Rule::in(['official', 'official_redacted', 'friendly'])],
            'include_personal' => ['sometimes', 'boolean'],
            'include_spouse' => ['sometimes', 'boolean'],
            'include_children' => ['sometimes', 'boolean'],
        ];
    }
}
