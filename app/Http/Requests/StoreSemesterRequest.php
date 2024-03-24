<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Semester;

class StoreSemesterRequest extends FormRequest
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
            'semester_session' => 'required|max:100',
            'semester_name' => 'required|max:100',
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

            'semester_session' => 'Session',
            'semester_name' => 'Semester Name',
        ];
    }

    public function semester_exist(){
        return Semester::where('semester_name', $this->semester_name)->where('school_id', $this->school_id)
            ->where('semester_session', $this->semester_session)->get();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($this->semester_exist()) != 0) {
                $validator->errors()->add('semester_name', 'Semester record already exist');
            }
        });
    }
}
