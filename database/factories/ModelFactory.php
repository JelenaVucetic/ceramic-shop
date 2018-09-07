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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function () {
    return [
        'name' => 'Category' . str_random(5)

    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    $users =  cvf_convert_object_to_array(DB::table('user')->select('id')->get());
    $categories = cvf_convert_object_to_array(DB::table('category')->select('id')->get());

    return [

        'category_id' => $categories[mt_rand(0,count($categories)-1)]['id'],
        'name' => 'Product_name' . str_random(4),
        'description' => $faker->paragraphs($nb = 3, $asText = true),
    ];

});

$factory->define(App\ProductImage::class, function (Faker\Generator $faker) {
    $products = cvf_convert_object_to_array(DB::table('product')->select('id')->get());
    return [
        'product_id' => $products[mt_rand(0,count($products)-1)]['id'],
        'image' => $faker->imageUrl(300, 250, 'technics')
    ];
});

$factory->define(App\Price::class, function (Faker\Generator $faker) {
    $products = cvf_convert_object_to_array(DB::table('product')->select('id')->get());
    return [
        'product_id' => $products[mt_rand(0,count($products)-1)]['id'],
        'price' => mt_rand(100,30000)/100,
    ];
});

$factory->define(App\Tax::class, function (Faker\Generator $faker) {
    $products = cvf_convert_object_to_array(DB::table('product')->select('id')->get());
    return [
        'product_id' => $products[mt_rand(0,count($products)-1)]['id'],
        'tax' => mt_rand(100,30000)/100,
    ];
});

$factory->define(App\Order::class, function (Faker\Generator $faker) {

    $users = cvf_convert_object_to_array(DB::table('user')->select('id')->get());
    #$products = cvf_convert_object_to_array(DB::table('product')->select('id')->get());

    return [

        'user_id' => $users[mt_rand(0,count($users)-1)]['id'],
        'payment_status' => array_rand(['not submitted', 'payment processing', 'payment successful', 'payment unsuccessful']),
        'price' => mt_rand(100,30000)/100
    ];
});

$factory->define(App\OrderProduct::class, function (Faker\Generator $faker) {

    $users = cvf_convert_object_to_array(DB::table('user')->select('id')->get());
    $products = cvf_convert_object_to_array(DB::table('product')->select('id')->get());
    $orders = cvf_convert_object_to_array(DB::table('order')->select('id')->get());

    return [

        'order_id' => $products[mt_rand(0,count($orders)-1)]['id'],
        'product_id' => $products[mt_rand(0,count($products)-1)]['id'],
        'price' => mt_rand(100,30000)/100,
        'quantity' => mt_rand(1, 15)
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    $users =  cvf_convert_object_to_array(DB::table('user')->select('id')->get());
    $products = cvf_convert_object_to_array(DB::table('product')->select('id')->get());

    return [

        'user_id' => $users[mt_rand(0,count($users)-1)]['id'],
        'product_id' => $products[mt_rand(0,count($products)-1)]['id'],
        'description' => $faker->paragraphs($nb = 3, $asText = true),
    ];

});

function cvf_convert_object_to_array($data) {

    if (is_object($data)) {
        $data = get_object_vars($data);
    }

    if (is_array($data)) {
        return array_map(__FUNCTION__, $data);
    }
    else {
        return $data;
    }
}


