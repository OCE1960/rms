<?php

namespace App\Http\Requests;

use App\Models\Grade;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGradesRequest extends FormRequest
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
            'code' => "required|max:191",
            'label' => "required|max:191",
            'point' => 'required|max:191',
            'lower_band_score' => 'required|numeric|min:0',
            'higher_band_score' => 'required|numeric|gt:lower_band_score',
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
            'code.unique' => 'The Code already Taken',
            'label.unique' => 'The Descriptionl already Taken',
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
            'code'     => 'Code',
            'label' => 'Label',
            'point' => 'Point',
            'lower_band_score' => 'Lower Band Score',
            'higher_band_score' => 'Higher Band Score',
        ];
    }

    public function grade_exist(){
        return Grade::where('school_id', $this->school_id)
            ->where('id', '<>', $this->id)
            ->where('code', $this->code)->get();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($this->grade_exist()) != 0) {
                $validator->errors()->add('grade_exist', 'Grade with Code already Exist');
            }
        });
    }
}
