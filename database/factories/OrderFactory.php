<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Order::class, function (Faker $faker) {
    return [
        'order_sn' => \Illuminate\Support\Str::random(12),
        'goods_id' => rand(1, 3),
        'coupon_id' => rand(1, 3),
        'title' => $faker->words(3, true),
        'type' => rand(1,2),
        'goods_price' => $faker->randomFloat(2, 10, 100),
        'buy_amount' => rand(1, 10),
        'coupon_discount_price' => $faker->randomFloat(2, 0, 100),
        'wholesale_discount_price' => $faker->randomFloat(2, 0, 100),
        'total_price' => $faker->randomFloat(2, 10, 100),
        'actual_price' => $faker->randomFloat(2, 10, 100),
        'search_pwd' => $faker->password(6, 10),
        'email' => $faker->email,
        'info' => $faker->words(3, true),
        'pay_id' => rand(1, 20),
        'buy_ip' => $faker->ipv4,
        'trade_no' => \Illuminate\Support\Str::random(12),
        'status' => rand(1, 5),
        'created_at' => $faker->dateTimeBetween('-7 days', 'now', 'PRC'),
        'updated_at' => $faker->dateTimeBetween('-7 days', 'now', 'PRC'),
    ];
});
