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

// Route::model('merchant', 'App\Merchant');
// Route::model('resource_type', 'App\ResourceType');
// Route::model('resource', 'App\Resource');
// Route::model('customer', 'App\Customer');
// Route::model('booking', 'App\Booking');
// Route::model('bill', 'App\Bill');
// Route::model('resource_maintenance', 'App\ResourceMaintenance');

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

Auth::routes();

// Route::get('/home', 'HomeController@index');
function tenantRoutes()
{
  Route::get('', 'DashboardController@frontDesk');
  Route::get('dashboard', 'DashboardController@merchant');

  Route::get('resource_types', 'ResourceTypeController@index');
  Route::get('resource_types/new', 'ResourceTypeController@create');
  Route::post('resource_types/new', 'ResourceTypeController@store');
  Route::get('resource_types/{resource_type}/edit', 'ResourceTypeController@edit');
  Route::post('resource_types/update', 'ResourceTypeController@update');

  // Route::get('resources', 'ResourceController@index');
  // Route::get('resources/new', 'ResourceController@create');
  // Route::post('resources/new', 'ResourceController@store');
  // Route::get('resources/{resource}/edit', 'ResourceController@edit');
  // Route::post('resources/update', 'ResourceController@update');

  Route::get('resources/{resource_type}', 'ResourceController@index');
  Route::get('resources/{resource_type}/new', 'ResourceController@create');
  Route::post('resources/new', 'ResourceController@store');
  Route::get('resources/{resource}/edit', 'ResourceController@edit');
  Route::post('resources/update', 'ResourceController@update');
  Route::get('resources/{resource}/maintenance', 'ResourceMaintenanceController@create');
  Route::post('resources/maintenance', 'ResourceMaintenanceController@store');
  Route::post('resources/{resource}/maintenance/{resource_maintenance}/delete', 'ResourceMaintenanceController@delete');
  Route::get('resources/{resource}/pricing', 'ResourcePricingController@index');
  Route::post('resources/pricing', 'ResourcePricingController@store');
  Route::post('resources/pricing/{resource_pricing}/delete', 'ResourcePricingController@delete');

  Route::get('comments/{type}/{id}/', 'CommentController@get');
  Route::post('comments', 'CommentController@store');

  Route::get('customers', 'CustomerController@index');
  Route::get('customers/new', 'CustomerController@create');
  Route::post('customers/new', 'CustomerController@store');
  Route::get('customers/{customer}/edit', 'CustomerController@edit');
  Route::post('customers/update', 'CustomerController@update');
  Route::get('customers/new_quick', 'CustomerController@pick');

  // Route::get('customers/{customer}/comments', 'CustomerController@comments');
  // Route::post('comments/customer/{id}', 'CustomerController@storeComment');

  Route::get('bookings', 'BookingController@index');
  // Route::get('bookings/{booking}/trail', 'BookingController@auditTrail');
  Route::get('bookings/new/{customer?}', 'BookingController@create');
  Route::post('bookings/new', 'BookingController@store');
  Route::post('bookings/checkin/{booking}', 'BookingController@checkin');
  Route::post('bookings/checkout/{booking}', 'BookingController@checkout');
  // Route::get('bookings/{booking}/view', 'BookingController@view');
  Route::get('bookings/{booking}', 'BookingController@action');
  // Route::get('bookings/{booking}/bills', 'BookingController@bills');

  Route::get('trail/{type}/{id}', 'AuditTrailController@get');
  // Route::get('trail/bookings/{booking_repo}', 'AuditTrailController@trail');
  // Route::get('trail/bills/{bill_repo}', 'AuditTrailController@trail');
  // Route::get('trail/resources/{resource_repo}', 'AuditTrailController@trail');

  Route::get('bookings/{booking}/addons/{resource_type}/new', 'AddonController@create');
  Route::get('bookings/{booking}/addons/{resource_type}/pos', 'AddonController@createPos');
  Route::post('addons/new', 'AddonController@store');
  Route::post('addons/new/list', 'AddonController@storeList');
  Route::post('addons/push/{booking}/{resource}', 'AddonController@push');
  Route::get('addons/pop/{booking}', 'AddonController@pop');

  Route::get('bills', 'BillController@index');
  Route::get('bills/{bill}', 'BillController@view');
  Route::get('bills/{bill}/edit', 'BillController@edit');
  Route::get('bills/{bill}/print', 'BillController@download');
  Route::post('bills/export', 'BillController@export');
  Route::post('bills/update', 'BillController@update');
  Route::post('bills/item/update', 'BillController@updateItem');

  Route::get('receipts', 'ReceiptController@index');
  Route::get('receipts/new/{bill}', 'ReceiptController@create');
  Route::get('receipts/{receipt}/edit', 'ReceiptController@edit');
  Route::post('receipts/new', 'ReceiptController@store');
  Route::post('receipts/update', 'ReceiptController@update');

  Route::get('reports/profitloss', 'ReportController@profitLossFilter');
  Route::post('reports/profitloss', 'ReportController@profitLoss');
}
