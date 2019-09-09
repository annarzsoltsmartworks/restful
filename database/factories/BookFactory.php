<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->text(20),
	    'author' => $faker->name(),
	    'release_year' => $faker -> numberBetween(1900, 2019),
	    'description' => $faker -> text(100)
    ];
});
