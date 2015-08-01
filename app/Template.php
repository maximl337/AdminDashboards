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
                'user_id'

                ];



    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
