<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TaskStatus;

class UpdateTaskStatusRequest extends FormRequest
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
        //dd($this);
        return [
            'name' => 'required|unique:task_statuses,name,' . $this->task_status->id . ',id,deleted_at,NULL'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('validation.custom.taskStatusUpdateName.unique'),
        ];
    }
}
