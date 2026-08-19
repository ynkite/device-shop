<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 대량 할당 허용할 필드
    protected $fillable = [
        'gubuns_id',
        'name',
        'price',
        'jaego',
        'pic',
    ];
}
