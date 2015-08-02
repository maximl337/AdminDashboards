<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateTemplateRequest extends Request
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
            'name'          => 'required', 
            'price'         => 'required',
            'description'   => 'required',
            'screenshot'    => 'required',
            'preview_url'   => 'required',
            'files_url'     => 'required'
        ];
    }
}
