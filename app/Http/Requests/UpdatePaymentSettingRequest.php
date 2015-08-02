<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdatePaymentSettingRequest extends Request
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
            'company_name'      => 'required',
            'phone'             => 'required',
            'address_1'         => 'required',
            'city'              => 'required',
            'state'             => 'required',
            'zip'               => 'required',
            'country'           => 'required',
            'tax_name'          => 'required',
            'tax_number'        => 'required',
            'business_type'     => 'required',
            'paypal_account'    => 'required',
        ];
    }
}
