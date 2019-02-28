<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowSearchEnginesRequest extends FormRequest
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
            'code' => 'required|string'
        ];
    }

    /**
     * @param null $keys
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all();
        $data['code'] = $this->route('code');
        return $data;
    }
}
