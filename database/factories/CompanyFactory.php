<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Company;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'companyName' => $faker->company
    ];
});
