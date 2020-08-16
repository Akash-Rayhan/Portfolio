<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\Boilerplate\BaseValidation;

class EducationRequest extends BaseValidation
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
            'degree' => 'required|max:255',
            'session' => 'required|numeric',
            'institution' => 'required|max:255'
        ];
    }
}
