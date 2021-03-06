<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                
                'name', 
                'price', 
                'price_multiple',
                'price_extended',
                'version',
                'description',
                'screenshot',
                'preview_url',
                'files_url',
                'user_id',
                'layout',
                'frameworks',
                'preprocessor',
                'browser',
                'columns',
                'exclusive',
                'files_included'

                ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeRejected($query)
    {
        return $query->where('rejected', true);
    }

    public function scopeDisabled($query)
    {
        return $query->where('disabled', true);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function paypalipn()
    {
        return $this->hasMany('App\PaypalIpn');
    }
    
}
