<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    /**
     * Name of the table
     * @var string
     */
    protected $table = 'payouts';

    /**
     * Allow Mass assignable 
     * @var array
     */
    protected $fillable = [

        'user_id',
        'amount',
        'sender_batch_id',
        'sender_item_id',
        'payout_batch_id',
        'payout_item_id',
        'batch_status',
        'trasaction_id',
        'transaction_status'
        
    ];

    /**
     * Illuminate\Database\Eloquent\Relations\BelongsTo
     * @return Eloquent Model User Model
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }



}
