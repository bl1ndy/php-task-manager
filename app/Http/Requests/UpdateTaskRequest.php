<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
        $task = $this->route('task');

        return [
            'name' => 'required|unique:tasks,name,' . $task->id . ',id,deleted_at,NULL',
            'status_id' => 'required',
            'description' => 'nullable|max:5000',
            'assigned_to_id' => 'nullable|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('validation.custom.taskUpdateName.unique'),
        ];
    }
}