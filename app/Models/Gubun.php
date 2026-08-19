<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;   // ← 이 줄 반드시 필요!

class Gubun extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}