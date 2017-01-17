<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\App\Models\Posts::class, function (Faker\Generator $faker) {
    return [
        'slug' => $faker->name,
        'title' => $faker->name,
        'content' => $faker->text,
        'published_at' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now') ,
    ];
});

$factory->state(\App\Models\Posts::class,'adminuser',function(Faker\Generator $faker){
    return  [
        'name'=>'adminuser'
    ];
});