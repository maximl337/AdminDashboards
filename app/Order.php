<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                
                'licence_type',
                'template_id',
                'user_id',
                'payment_successful',
                'txn_id'

                ];



    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function template()
    {
        return $this->belongsTo('App\Template');
    }
}
