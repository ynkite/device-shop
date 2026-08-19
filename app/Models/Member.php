<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $fillable = [
        'uid',
        'pwd',
        'name',
        'tel',
        'rank',
    ];
}
