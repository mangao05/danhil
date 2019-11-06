<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    
    'customer' => 'API\CustomerController',
    'addtocart' => 'API\AddToCartController',
    'checkout' => 'API\OrderController',
    'role'=> 'API\RoleController',
    'position' =>'API\PositionController',
    'user' => 'API\UserController',
    'collection' => 'API\CollectionController',
    'package' => 'API\PackageController'
]);

Route::apiResource('product', 'API\ProductController', ['except' => ['show']]);
Route::get('product/{id}', 'API\ProductController@show');
Route::post('checkCart','API\AddToCartController@displayCheckCart');
Route::post('customerDetails','API\AddToCartController@cartDetailsCustomer');
Route::post('reorder','API\OrderController@reorder');
Route::post('orderList','API\OrderController@orderList');

Route::post('deleteProduct','API\ProductController@deleteProduct');

Route::get('lowstock','API\ProductController@lowStock');
Route::get('customer/details/{id}','API\CustomerController@updateCustomer');
Route::post('grandtotal','API\AddToCartController@grandTotal');
Route::post('currentUser','API\UserController@user_details');

Route::post('orderPreview/print','API\OrderController@viewOrderDetails');
Route::post('deleteItem','API\OrderController@deleteItem');

Route::post('collectionFilter','API\CollectionController@collection');
Route::get('recent','API\ProductController@recent');
Route::post('karton','API\AddToCartController@totalKarton');

