<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTranscriptRequest extends FormRequest
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
            'send_by' => 'required|max:191',
            'destination_country' => 'required|max:191',
            'receiving_institution' => 'required|max:191',
            'program' => "required|max:191",
            'receiving_institution_corresponding_email' => "required|email|max:191",
            'title_of_request' => 'required|max:191',
            'reason_for_request' => "required|max:191",
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
            'send_by' => 'Send by',
            'destination_country' => 'Destination Country',
            'receiving_institution' => 'Receiving Institution',
            'program' => "Program",
            'receiving_institution_corresponding_email' => 'Corresponding Email',
        ];
    }
}
