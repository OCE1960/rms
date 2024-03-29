<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMoveFileRequest extends FormRequest
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
            'comment' => 'required|max:191',
            'send_to' => 'required|max:191|exists:users,id',
            'transcriptRequestId' => 'nullable|max:191|exists:transcript_requests,id',
            'verifyResultRequestId' => 'nullable|max:191|exists:verify_result_requests,id',
            'taskItemId' => 'required|max:191|exists:task_assignments,id',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
    */
    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
    */
    public function attributes()
    {
        return [
            'comment' => 'Comment',
            'send_to' => 'Staff',
        ];
    }
}
