<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property string $name
 * @property string $full_name
 * @property ?string $national_id
 * @property ?string $home_address
 * @property ?string $born_at
 */
class DeclarationUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()?->id === $this->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:4',
            'full_name' => 'required|string|min:3',
            'national_id' => ['string', 'min:6', 'nullable'],
            'born_at' => ['nullable', 'date', 'before_or_equal:' . Carbon::now()->subYears(18)->toDateString()],
            'home_address' => ['string', 'nullable'],
        ];
    }
}
