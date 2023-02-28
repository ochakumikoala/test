<?php

/** 
 * @var \Illuminate\Database\Eloquent\Factory $factory 
 * 
 */

use App\Models\Product;
use App\Models\Company;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'img_path' => $faker->image,
        'product_name' => $faker->name,
        'price' => $faker->numberBetween(100,500),
        'stock' => $faker->numberBetween(0,999),
        'company_id' => $faker->company,
        'comment' => $faker->realText(30),
    ];
});
