<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
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
            'full_name' => 'required|max:191|unique:schools,full_name',
            'short_name' => "nullable|max:191",
            'address_street' => "nullable|max:191",
            'address_mailbox' => "nullable|max:191",
            'state' => "nullable|max:191",
            'geo_zone' => "required|max:191",
            'type' => "required|max:191",
            'official_email' => "nullable|max:191",
            'official_website' => "nullable|max:191",
            'official_phone' => "nullable|min:11",
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
            'full_name' => 'Full Name',
            'short_name' => "Short Name",
            'address_street' => "Address",
            'address_mailbox' => "Mailbox",
            'state' => "State",
            'geo_zone' => "Region",
            'type' => "Type",
            'official_email' => "Official Email1",
            'official_website' => "Official Website",
            'official_phone' => "Official Phone No.",
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

