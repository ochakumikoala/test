<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table='products';
    protected $fillable =
    [
        'imgPath',
        'productName',
        'companyName',
        'comment',
        'price',
        'stock'
    ];

}