<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'session_menu_id' => $faker->numberBetween(1, 50),
        'customer_id' => $faker->numberBetween(1, 100),
        'order_date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
        'total_amount' => $faker->randomFloat(2, 5, 500),
        'order_status' => $faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
        'status'=> 1,
    ];
});
