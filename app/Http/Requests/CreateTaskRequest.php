<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            'task.identifier' => 'required|string',
            'task.site' => 'required',
            'task.se_name' => 'required',
            'task.se_language' => 'required',
            'task.loc_name_canonical' => 'required',
            'task.key' => 'required'
        ];
    }
}
