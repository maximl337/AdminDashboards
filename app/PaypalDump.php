<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaypalDump extends Model
{
    protected $fillable = [
        'dump',
        'response'
    ];
}
