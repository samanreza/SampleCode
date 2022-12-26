<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterTask extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {

        return [
            'start_date' => [
                'bail',
                'nullable',
                'date',
                'date_format:Y-m-d H:i:s',
                'before_or_equal:now'
            ],
            'end_date' => [
                'bail',
                'nullable',
                'date',
                'date_format:Y-m-d H:i:s',
                'after_or_equal:start_date'
            ],
            'description' => [
                'bail',
                'nullable',
                'string',
                'min:2',
                'max:100'
            ]
        ];
    }
}
