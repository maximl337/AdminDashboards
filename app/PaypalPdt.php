<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaypalPdt extends Model
{
    protected $table = 'paypal_pdts';
    
    protected $fillable = [
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
            'custom',
            'payer_status',
            'business',
            'address_country',
            'address_city',
            'quantity',
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
            'handling_amount',
            'transaction_subject',
            'payment_gross',
            'shipping',
            'template_id'
    ];
}
