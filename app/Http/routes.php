<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/category/{category_id}', [
    'uses' => 'ProductController@show_category'
]);

Route::get('/product/{product_id}', [
    'uses' => 'ProductController@show_product',
    'as' => 'product'
]);

Route::get('/product_all/', [
    'uses' => 'ProductController@show_product_all',
    'as' => 'product_all'
]);
Route::get('/pages/search', [
    'uses' => 'ProductController@show_product_searched'
]);

Route::post('/product/{product_id}', [
    'uses' => 'ProductController@show_product',
]);

Route::get('/', 'ProductController@list_all');

Route::post('/product/add_to_cart', [
    'uses' => 'ProductController@add_to_cart',
    'as' => 'product.add_to_cart',
    'middleware' => 'auth'
]);
//Route::post('/product/add_to_cart2', [
//    'uses' => 'ProductController@add_to_cart',
//    'as' => 'product.add_to_cart2',
//    'middleware' => 'auth'
//]);

Route::post('/create-post', [
    'uses' => 'ProductController@postCreatePost',
    'as' => 'comment.create',
    'middleware' => 'auth'
]);

Route::get('/delete-post/{post_id}', [
    'uses' => 'ProductController@getDeletePost',
    'as' => 'comment.delete',
    'middleware' => 'auth'
]);

Route::post('/edit-post',[
    'uses' => 'ProductController@postEditPost',
    'as' => 'comment.edit'
]);

Route::post('/buy_me',[
    'uses' => 'ProductController@add_to_cart',
    'as' => 'product.buy',
    'middleware' => 'auth'
]);

Route::get('/delete-product-order/{order_id}', [
    'uses' => 'ProductController@getDeleteProductOrder',
    'as' => 'delete_product_order',
    'middleware' => 'auth'
]);


Route::get('/buy-product-order/{order_id}', [
    'uses' => 'ProductController@buyOrder',
    'as' => 'buy_product_order',
    'middleware' => 'auth'
]);



Route::auth();

Route::get('/home', 'HomeController@index');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/shopping_cart', [
    'uses' => 'ProductController@listCurrentOrder',
    'as' => 'shopping_cart',
    'middleware' => 'auth'
]);


//Route::get('/admin/add_product', function () {
//    return view('admin.add_product');
//})->name('home');

Route::get('/admin', function () {
    return view('admin.action');
});


Route::get('/admin/add_product', [
    'uses' => 'ProductController@index',
    'as' => 'add_product',
    'middleware' => 'auth'
]);

Route::get('/admin/add_user', [
    'uses' => 'UserController@index',
    'as' => 'add_user',
    'middleware' => 'auth'
]);

Route::post('/admin/save_product', [
    'uses' => 'ProductController@saveProduct',
    'as' => 'product.save',
    'middleware' => 'auth'
]);

Route::get('/admin/add_category', [
    'uses' => 'CategoryController@index',
    'as' => 'add_category',
    'middleware' => 'auth'
]);

Route::post('/admin/save_category', [
    'uses' => 'CategoryController@saveCategory',
    'as' => 'category.save',
    'middleware' => 'auth'
]);

Route::get('/admin/category/delete/{category_id}', [
    'uses' => 'CategoryController@deleteCategory',
    'as' => 'category.delete',
    'middleware' => 'auth'
]);

Route::get('/admin/product/history/{product_id}', [
    'uses' => 'ProductController@showHistory',
    'as' => 'product.history',
    'middleware' => 'auth'
]);
