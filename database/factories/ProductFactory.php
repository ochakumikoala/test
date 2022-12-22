<?php

/** 
 * @var \Illuminate\Database\Eloquent\Factory $factory 
 * 
 */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'imgPath' => $faker->image,
        'productName' => $faker->word,
        'price' => $faker->buildingNumber,
        'stock' => $faker->buildingNumber,
        'companyName' => $faker->company,
        'comment' => $faker->text
    ];
});
