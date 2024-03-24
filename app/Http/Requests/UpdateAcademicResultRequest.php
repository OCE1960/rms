<?php

namespace App\Http\Requests;

use App\Models\AcademicResult;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademicResultRequest extends FormRequest
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
            'score' => 'required|max:100',
            'course_id' => 'required|max:100',
            'grade' => 'required|max:100',
            'semester_id' => 'required|max:100',
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

            'score' => 'Score',
            'course_id' => 'Course',
            'grade' => 'Grade',
            'semester_id' => 'Semester',
        ];
    }

    public function course_exist(){
        return AcademicResult::where('user_id', $this->user_id)
            ->where('course_id', $this->course_id)
            ->where('semester_id', $this->semester_id)->get();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($this->course_exist()) != 0) {
                $validator->errors()->add('semester_name', 'Course Record exist for this semester');
            }
        });
    }
}
