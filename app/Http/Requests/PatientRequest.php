<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            '_id' => 'nullable|max:80',
            'identifier' => 'nullable|max:80',
            'family' => 'nullable|max:80',
            'given' => 'nullable|max:80',
            'birthdate' => 'nullable|max:80',
            'gender' => 'nullable|in:female,male,other,unknown',
            'address' => 'nullable|max:80',
            'telecom' => 'nullable|max:80',
        ];
    }
}
