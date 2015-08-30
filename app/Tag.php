<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    public function templates()
    {
        return $this->belongsToMany('App\Template');
    }
}
