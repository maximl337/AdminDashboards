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
            'name'              => 'required', 
            'price'             => 'required|numeric',
            'price_multiple'    => 'numeric',
            'price_extended'    => 'numeric',
            'description'       => 'required',
            'screenshot'        => 'required|image',
            'preview_url'       => 'required',
            'files'             => 'required|mimes:zip|max:150000',
            'layout'            => 'required',
            'frameworks'        => 'required',
            'browser'           => 'required',
            'columns'           => 'required',
            'files_included'    => 'required'
        ];
    }
}
