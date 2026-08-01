<?php

namespace App\Http\Requests;

use App\Types\ExportDocumentType;
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
            'document_type' => ['required', 'string', Rule::in(ExportDocumentType::values())],
            'include_personal' => ['required', 'boolean'],
            'include_spouse' => ['required', 'boolean'],
            'include_children' => ['required', 'boolean'],
        ];
    }

    public function getDocumentType(): ExportDocumentType
    {
        return ExportDocumentType::from($this->document_type);
    }
}
