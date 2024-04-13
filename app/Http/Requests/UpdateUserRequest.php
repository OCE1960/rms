<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'last_name' => 'required|max:191',
            'email' => "required|unique:users,email,{$this->id}|email|max:191",
            'phone_no' => "required|unique:users,phone_no,{$this->id}|min:11",
            'role' => 'required'
        ];
    }
}
