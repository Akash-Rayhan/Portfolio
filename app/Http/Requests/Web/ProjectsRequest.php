<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\Boilerplate\BaseValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectsRequest extends BaseValidation
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
            'repo_link' => 'required|max:255',
            'status' => 'required',Rule::in([CURRENT_PROJECTS,PREVIOUS_PROJECTS])
        ];
    }
}
