<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaypalIpn extends Model
{
    protected $table = 'paypal_ipns';

    protected $fillable = [

        'template_id',
        'licence_type',
        'mc_gross',
        'protection_eligibility',
        'address_status',
        'payer_id',
        'tax',
        'address_street',
        'payment_date',
        'payment_status',
        'charset',
        'address_zip',
        'first_name',
        'mc_fee',
        'address_country_code',
        'address_name',
        'notify_version',
        'payer_status',
        'address_country',
        'address_city',
        'quantity',
        'verify_sign',
        'payer_email',
        'txn_id',
        'payment_type',
        'last_name',
        'address_state',
        'receiver_email',
        'payment_fee',
        'receiver_id',
        'txn_type',
        'item_name',
        'mc_currency',
        'item_number',
        'residence_country',
        'test_ipn',
        'handling_amount',
        'transaction_subject',
        'payment_gross',
        'shipping',

    ];

    public function templates()
    {
        return $this->belongsTo('App\Template');
    }
}
