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
        'amount'
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
