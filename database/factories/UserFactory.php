<?php

use App\Article;
use App\Comment;
use App\Tag;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {

    return [
        'username' => str_replace('.', '', $faker->unique()->userName),
        'email' => $faker->unique()->safeEmail,
        'password' => 'secret',
        'bio' => $faker->sentence,
        'image' => 'https://cdn.worldvectorlogo.com/logos/laravel.svg',
    ];
});

$factory->define(Article::class, function (Faker $faker) {

    static $reduce = 999;

    return [
        'title' => $faker->sentence,
        'description' => $faker->sentence(10),
        'body' => $faker->paragraphs($faker->numberBetween(1, 3), true),
        'created_at' => Carbon::now()->subSeconds($reduce--),
    ];
});

$factory->define(Comment::class, function (Faker $faker) {

    static $users;
    static $reduce = 999;

    $users = $users ?: User::all();

    return [
        'body' => $faker->paragraph($faker->numberBetween(1, 5)),
        'user_id' => $users->random()->id,
        'created_at' => Carbon::now()->subSeconds($reduce--),
    ];
});

$factory->define(Tag::class, function (Faker $faker) {

    return [
        'name' => $faker->unique()->word,
    ];
});
