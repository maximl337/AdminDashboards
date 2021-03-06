<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
            'username',
            'name', 
            'email', 
            'password',
            'company_name',
            'phone',
            'address_1',
            'address_2',
            'city',
            'state',
            'zip',
            'country',
            'tax_name',
            'tax_number',
            'business_type',
            'paypal_account',
            
            ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * [templates description]
     * @return [type] [description]
     */
    public function templates()
    {
        return $this->hasMany('App\Template');
    }

    /**
     * [orders description]
     * @return [type] [description]
     */
    // public function orders()
    // {
    //     return $this->hasMany('App\Order');
    // }


    /**
     * [incoming_orders description]
     * @return [type] [description]
     */
    public function orders()
    {
        return $this->hasManyThrough('App\Order', 'App\Template');
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function payouts()
    {
        return $this->hasMany('App\Payout');
    }
}
