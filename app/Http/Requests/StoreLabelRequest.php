<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabelRequest extends FormRequest
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
            'name' => 'required|unique:labels,name,NULL,id,deleted_at,NULL',
            'description' => 'nullable|max:5000'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('validation.custom.labelStoreName.unique'),
        ];
    }
}
