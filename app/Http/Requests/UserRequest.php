<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            \App\Models\User::COLUMN_USERNAME => 'bail|required|string|min:3|max:30',
            \App\Models\User::COLUMN_PASSWORD => 'bail|required|string|min:3|max:20',
            \App\Models\User::COLUMN_ROLE     => 'nullable'
        ];
    }
}
