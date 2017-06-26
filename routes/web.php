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

Route::get('home', 'DashboardController@frontDesk');

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

// Route::get('merchants/{merchant}/users', 'MerchantUserController@index');
// Route::get('merchants/{merchant}/users/new', 'MerchantUserController@create');
// Route::post('merchants/{merchant}/users/new', 'MerchantUserController@store');

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

  Route::group(['middleware' => ['role:super_admin'], 'prefix' => '/resource_types'], function () {
    Route::get('/', 'ResourceTypeController@index');
    Route::get('/new', 'ResourceTypeController@create');
    Route::post('/new', 'ResourceTypeController@store');
    Route::get('/{resource_type}/edit', 'ResourceTypeController@edit');
    Route::post('/update', 'ResourceTypeController@update');
  });

  Route::group(['middleware' => ['permitted:resource'], 'prefix' => '/resources'], function () {
    Route::get('/{resource_type}', 'ResourceController@index');
    Route::get('/{resource_type}/new', 'ResourceController@create');
    Route::get('/{resource}/edit', 'ResourceController@edit');
    Route::get('/{resource}/maintenance', 'ResourceMaintenanceController@create');
    Route::post('/new', 'ResourceController@store');
    Route::post('/update', 'ResourceController@update');
    Route::post('/maintenance', 'ResourceMaintenanceController@store');
    Route::post('/{resource}/maintenance/{resource_maintenance}/delete', 'ResourceMaintenanceController@delete');

    Route::get('/{resource}/pricing', 'ResourcePricingController@index');
    Route::post('/pricing', 'ResourcePricingController@store');
    Route::post('/pricing/{resource_pricing}/delete', 'ResourcePricingController@delete');

    Route::get('/pricing/{resource_pricing}/tier', 'ResourcePricingTierController@index');
    Route::post('/pricing/tier', 'ResourcePricingTierController@store');
    Route::post('/pricing/tier/{resource_pricing_tier}/delete', 'ResourcePricingTierController@delete');
  });


  Route::group(['middleware' => ['permitted:customer'], 'prefix' => '/customers'], function () {
    Route::get('/', 'CustomerController@index');
    Route::get('/new', 'CustomerController@create');
    Route::post('/new', 'CustomerController@store');
    Route::get('/{customer}/edit', 'CustomerController@edit');
    Route::post('/update', 'CustomerController@update');
    Route::get('/new_quick', 'CustomerController@pick');
  });

  // Route::get('customers/{customer}/comments', 'CustomerController@comments');
  // Route::post('comments/customer/{id}', 'CustomerController@storeComment');


  Route::group(['middleware' => ['permitted:booking'], 'prefix' => '/bookings'], function () {
    Route::get('/', 'BookingController@index');
    Route::get('/new/{customer?}', 'BookingController@create');
    Route::get('/{booking}', 'BookingController@action');
    Route::get('/{booking}/edit', 'BookingController@edit');
    Route::get('/{booking}/addons', 'BookingController@addons');
    Route::post('/new', 'BookingController@store');
    Route::post('/update', 'BookingController@update');
    Route::post('/checkin/{booking}', 'BookingController@checkin');
    Route::post('/checkout/{booking}', 'BookingController@checkout');
  });

  Route::get('trail/{type}/{id}', 'AuditTrailController@get');
  Route::get('comments/{type}/{id}/', 'CommentController@get');
  Route::post('comments', 'CommentController@store');

  // Route::get('trail/bookings/{booking_repo}', 'AuditTrailController@trail');
  // Route::get('trail/bills/{bill_repo}', 'AuditTrailController@trail');
  // Route::get('trail/resources/{resource_repo}', 'AuditTrailController@trail');

  Route::get('bookings/{booking}/addons/{resource_type}/new', 'AddonController@create');
  Route::get('bookings/{booking}/addons/{resource_type}/pos', 'AddonController@createPos');
  Route::get('addons/{resource_type}/new/booking/{booking}/{pos?}', 'AddonController@createForBooking');
  Route::get('addons/{resource_type}/new/bill/{bill}/{pos?}', 'AddonController@createForBill');
  Route::get('addons/pop/{booking}', 'AddonController@pop');
  Route::post('addons/new', 'AddonController@store');
  Route::post('addons/new/list', 'AddonController@storeList');
  Route::post('addons/push/{booking}/{resource}', 'AddonController@push');
  Route::post('addons/update', 'AddonController@update');

  Route::group(['middleware' => ['permitted:bill'], 'prefix' => '/bills'], function () {
    Route::get('/', 'BillController@index');
    Route::get('/new', 'BillController@create');
    Route::get('/{bill}', 'BillController@view');
    Route::get('/{bill}/edit', 'BillController@edit');
    Route::get('/{bill}/print', 'BillController@download');
    Route::get('/{bill}/addons/{resource_type}/new', 'AddonController@addToBill');
    Route::post('/new/walkin', 'BillController@storeWalkIn');
    Route::post('/new', 'BillController@store');
    Route::post('/export', 'BillController@export');
    Route::post('/update', 'BillController@update');
    Route::post('/item/update', 'BillController@updateItem');
    Route::post('/item', 'BillController@storeItem');
  });

  Route::group(['middleware' => ['permitted:payment'], 'prefix' => '/receipts'], function () {
    Route::get('/', 'ReceiptController@index');
    Route::get('/new/{bill}', 'ReceiptController@create');
    Route::get('/{receipt}/edit', 'ReceiptController@edit');
    Route::post('/new', 'ReceiptController@store');
    Route::post('/update', 'ReceiptController@update');
  });

  Route::group(['middleware' => ['permitted:accounting'], 'prefix' => '/expenses_category'], function () {
    Route::get('/', 'ExpenseCategoryController@index');
    Route::get('/new', 'ExpenseCategoryController@create');
    Route::get('/{expense_cat}/edit', 'ExpenseCategoryController@edit');
    Route::get('/{expense_cat}', 'ExpenseCategoryController@view');
    Route::post('/new', 'ExpenseCategoryController@store');
    Route::post('/update', 'ExpenseCategoryController@update');
  });

  Route::group(['middleware' => ['permitted:accounting'], 'prefix' => '/expenses'], function () {
    Route::get('/', 'ExpenseController@index');
    Route::get('/new', 'ExpenseController@create');
    Route::get('/{expense}/edit', 'ExpenseController@edit');
    Route::get('/{expense}', 'ExpenseController@view');
    Route::post('/new', 'ExpenseController@store');
    Route::post('/update', 'ExpenseController@update');
  });

  Route::group(['middleware' => ['permitted:resource'], 'prefix' => '/agents'], function () {
    Route::get('/', 'AgentController@index');
    Route::get('/new', 'AgentController@create');
    Route::get('/{agent}/edit', 'AgentController@edit');
    Route::post('/new', 'AgentController@store');
    Route::post('/update', 'AgentController@update');
  });


  Route::group(['middleware' => ['permitted:report'], 'prefix' => '/reports'], function () {
    Route::get('/profitloss', 'ReportController@profitLoss');
    Route::get('/occupancy_by_room', 'ReportController@occupancyByRoom');
    Route::get('/occupancy_by_day', 'ReportController@occupancyByDay');
    Route::get('/occupancy_by_national', 'ReportController@occupancyByNational');
    Route::get('/monthly_stat', 'ReportController@monthlyStat');
    Route::get('/daily_tour', 'ReportController@dailyTour');
    Route::get('/daily_transfer', 'ReportController@dailyTransfer');
    Route::get('/monthly_deposit', 'ReportController@monthlyDeposit');
    Route::get('/monthly_deposit_future', 'ReportController@monthlyDepositByFuture');
    Route::get('/export_bills', 'ReportController@exportBills');
    Route::get('/export_receipts', 'ReportController@exportReceipts');
    Route::get('/download/{report}', 'ReportController@download');
    Route::post('/request', 'ReportController@request');
    // Route::post('/profitloss', 'ReportController@profitLoss');
  });

  Route::group(['middleware' => ['permitted:manage_user'], 'prefix' => '/users'], function () {
    Route::get('/', 'Access\UserController@index');
    Route::get('/new', 'Access\UserController@create');
    Route::get('/{user}/edit', 'Access\UserController@edit');
    Route::post('/new', 'Access\UserController@store');
    Route::post('/update', 'Access\UserController@update');
  });

  Route::group(['middleware' => ['permitted:manage_role'], 'prefix' => '/roles'], function () {
    Route::get('/', 'Access\RoleController@index');
    Route::get('/new', 'Access\RoleController@create');
    Route::get('/{role}/edit', 'Access\RoleController@edit');
    Route::get('/{role_id}/permission', 'Access\RoleController@permission');
    Route::post('/new', 'Access\RoleController@store');
    Route::post('/update', 'Access\RoleController@update');
    Route::post('/{role}/permissions/add/{permission}', 'Access\RoleController@addPermission');
    Route::post('/{role}/permissions', 'Access\RoleController@syncPermission');
  });

  Route::group(['middleware' => ['permitted:manage_permission'], 'prefix' => '/permissions'], function () {
    Route::get('/', 'Access\PermissionController@index');
    Route::get('/new', 'Access\PermissionController@create');
    Route::get('/{role}/edit', 'Access\PermissionController@edit');
    Route::post('/new', 'Access\PermissionController@store');
    Route::post('/update', 'Access\PermissionController@update');
  });

}
