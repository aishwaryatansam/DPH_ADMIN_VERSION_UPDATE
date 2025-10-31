<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'session_menu_id' =>,
        'customer_id' =>,
        'order_date' =>,
        'total_amount' =>,
        'order_status' =>,
        'status'=> 1,
    ];
});
