<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'name' => 'required|unique:tasks,name,NULL,id,deleted_at,NULL',
            'status_id' => 'required',
            'description' => 'nullable|max:5000',
            'assigned_to_id' => 'nullable|numeric',
            'labels' => 'array'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('validation.custom.taskStoreName.unique'),
        ];
    }
}
