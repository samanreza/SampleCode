<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;
class TaskRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            Task::COLUMN_TITLE => 'bail|required|string|min:3|max:30',
            Task::COLUMN_DESCRIPTION => 'bail|required|string|min:2|max:100'
        ];
    }
}
