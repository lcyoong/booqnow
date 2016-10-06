<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::model('merchant', 'App\Merchant');
Route::model('resource_type', 'App\ResourceType');

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', 'DashboardController@user');

Route::get('signup', 'Auth\RegisterController@signup');

Route::post('signup', 'Auth\RegisterController@register');

Route::get('logout', 'Auth\LoginController@logout');

Route::get('login', 'Auth\LoginController@showLoginForm');

Route::post('login', 'Auth\LoginController@login');

Route::get('users', 'UserController@all');

Route::get('merchants', 'MerchantController@index');
Route::get('merchants/new', 'MerchantController@create');
Route::post('merchants/new', 'MerchantController@store');
Route::get('merchants/{merchant}/edit', 'MerchantController@edit');
Route::post('merchants/update', 'MerchantController@update');

Route::get('merchants/{merchant}/users', 'MerchantUserController@index');
Route::get('merchants/{merchant}/users/new', 'MerchantUserController@create');
Route::post('merchants/{merchant}/users/new', 'MerchantUserController@store');

if (config('myapp.multi_tenant')) {

  Route::group(['prefix' => '{merchant}'], function () {

    tenantRoutes();
  });
} else {

  tenantRoutes();
}

function tenantRoutes()
{
  Route::get('', 'DashboardController@merchant');
  Route::get('resource_types', 'ResourceTypeController@index');
  Route::get('resource_types/new', 'ResourceTypeController@create');
  Route::post('resource_types/new', 'ResourceTypeController@store');
  Route::get('resource_types/{resource_type}/edit', 'ResourceTypeController@edit');
  Route::post('resource_types/update', 'ResourceTypeController@update');

}
