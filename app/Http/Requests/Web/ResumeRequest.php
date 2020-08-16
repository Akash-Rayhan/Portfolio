<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\Boilerplate\BaseValidation;

class ResumeRequest extends BaseValidation
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
            'title' => 'required|max:255',
            'file.*' => 'required|file|max:10000|mimes:doc,docx,pdf'
        ];
    }
}
