<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnquirerRequest extends FormRequest
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
            'first_name' => 'required|max:191',
            'middle_name' => 'nullable|max:191',
            'organization_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => "nullable|unique:users,email,{$this->id}|email|max:191",
            'phone_no' => "required|unique:users,phone_no,{$this->id}|min:11",
            'gender' => 'required|max:191',

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
            'email.unique' => 'The Email already Taken',
            'phone_no.unique' => 'The Phone Number is already Taken'
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
            'email'     => 'Email',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'phone_no' => 'Phone No.',
            'address' => 'Address',
            'organization_name' => 'Organization Name',
        ];
    }
}
