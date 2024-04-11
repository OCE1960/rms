<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResultVerificationRequestRequest extends FormRequest
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
            'student_first_name' => 'required|max:191',
            'student_last_name' => 'required|max:191',
            'student_middle_name' => 'nullable|max:191',
            'registration_no' => 'required|max:191',
            'school_id' => 'required|max:191',
            'title_of_request' => 'required|max:191',
            'reason_for_request' => 'required|max:191',
            'file_path' => "nullable|max:2000000|mimes:pdf",
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
            'student_first_name' => 'Student First Name',
            'student_last_name' => 'Student Last NAme',
            'student_middle_name' => 'Student Middle Name',
            'registration_no' => 'Registration No.',
            'file_path' => "Consent Letter",
            'school_id' => 'School',
            'title_of_request' => 'Title',
            'reason_for_request' => 'Reason For Request',

        ];
    }
}
