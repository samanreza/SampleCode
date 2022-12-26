<?php

namespace App\Http\Requests;

use App\Rules\BulkTaskRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DefineTaskForUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user' => [
                'bail',
                'required',
                'integer',
                'exists:users,id'
            ],
            'task' => [
                'bail',
                'required',
                'array',
                new BulkTaskRules
            ],
        ];
    }
}
