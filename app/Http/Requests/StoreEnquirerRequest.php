<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnquirerRequest extends FormRequest
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
            'last_name' => 'required|max:191',
            'email' => "required|unique:users,email|email|max:191",
            'password' => "required|confirmed|min:6",
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
            'last_name' => 'Last Name',
            'password' => 'Password',
        ];
    }
}
