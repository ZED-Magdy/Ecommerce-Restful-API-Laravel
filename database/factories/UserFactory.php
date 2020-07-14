<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use App\User;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\ProductTranslation;
use App\Models\Rate;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        "stock" => 100,
        "user_id" => 1,
        "category_id" => rand(1, 5),
        "price" => rand(10.0, 99.0)
    ];
});
$factory->define(ProductTranslation::class, function (Faker $faker) {
    return [
        "product_id" => rand(1, 100),
        "name" => $faker->name(),
        "lang" => "en",
        "description" => $faker->paragraph(),
    ];
});
$factory->define(Category::class, function (Faker $faker) {
    return [
        "parent_id" => null,
    ];
});
$factory->define(CategoryTranslation::class, function (Faker $faker) {
    return [
        "category_id" => rand(1, 5),
        "name" => $faker->firstName(),
        "lang" => "en",
    ];
});
$factory->define(Rate::class, function (Faker $faker) {
    return [
        "stars"      => rand(1.0, 5.0),
        "user_id" => 1,
        "rateable_type" => "App\Models\Product",
        "rateable_id" => 13
    ];
});
