<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:191',
            'middle_name' => "nullable|max:191",
            'last_name' => "required|max:191",
            'email' => "required|unique:users,email|email|max:191",
            'phone_no' => "nullable|unique:users,phone_no|min:11",
            'registration_no' => "required|unique:users,registration_no",
            'gender' => "nullable|max:191",
            'profile_picture_path' => "nullable|max:191",
            'title' => "nullable|max:191",
            'date_of_birth' => "nullable|max:191",
            'nationality' => "nullable|max:191",
            'state_of_origin' => "nullable|max:191",
            'password' => 'required|min:6',
            'school_id' => "nullable|max:191",
            'department' => "nullable|max:191",
            'program' => "nullable|max:191",
            'date_of_entry' => "nullable|max:191",
            'mode_of_entry' => "nullable|max:191",
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
            'first_name' => 'First Name',
            'middle_name' => "Middle Name",
            'last_name' => "Last Name",
            'email' => "Email",
            'phone_no' => "Phone No",
            'registration_no' => "Registration No",
            'gender' => "Gender",
            'profile_picture_path' => "Profile pics",
            'title' => "Title",
            'date_of_birth' => "Date of Birth",
            'nationality' => "Nationality",
            'state_of_origin' => "State of Origin",
            'password' => 'Password',
            'school_id' => "School",
            'department' => "Department",
            'program' => "Program",
            'date_of_entry' => "Date of Entry",
            'mode_of_entry' => "Mode of Entry",
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
}
