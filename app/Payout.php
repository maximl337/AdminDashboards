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
        'unique_id',
        'masspay_txn_id',
        'status',
        'mc_fee',
        'mc_gross',
        'reason_code'

    ];

    /**
     * Illuminate\Database\Eloquent\Relations\BelongsTo
     * 
     * @return Eloquent Model User Model
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get completed or processed payouts
     * Status: completed, failed, returned, reversed, unclaimed, pending, blocked
     *
     * @param  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProcessed($query)
    {
        return $query->whereNotNull('status');

    }



}
