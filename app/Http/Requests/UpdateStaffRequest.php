<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
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
            'email' => "required|unique:users,email,{$this->id}|email|max:191",
            'phone_no' => "nullable|unique:users,phone_no,{$this->id}|min:11",
            'gender' => "nullable|max:191",
            'profile_picture_path' => "nullable|max:191",
            'title' => "nullable|max:191",
            'date_of_birth' => "nullable|max:191",
            'nationality' => "nullable|max:191",
            'state_of_origin' => "nullable|max:191",
            'school_id' => "nullable|max:191",
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
            'middle_name' => "Middle NAme",
            'last_name' => "Last Name",
            'email' => "Email",
            'phone_no' => "Phone No",
            'gender' => "Gender",
            'profile_picture_path' => "Profile pics",
            'title' => "Title",
            'date_of_birth' => "Date of Birth",
            'nationality' => "Nationality",
            'state_of_origin' => "State of Origin",
            'school_id' => "School",
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
