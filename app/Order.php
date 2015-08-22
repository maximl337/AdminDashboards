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
                'txn_id',
                'download_request_count',
                'status',
                'payment_gross',
                'tax'

                ];



    // public function user()
    // {
    //     return $this->belongsTo('App\User');
    // }

    public function template()
    {
        return $this->belongsTo('App\Template');
    }

    public function user()
    {
        return $this->hasManyThrough('App\User', 'App\Template');
    }
}
