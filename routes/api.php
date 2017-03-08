<?php

use Illuminate\Http\Request;
use Repositories\ResourceRepository;
use App\ResourceFilter;

// Route::model('resource_type', 'App\ResourceType');
// Route::model('booking', 'App\Booking');
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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Route::get('/v1/resources/active', 'ResourceController@active');

// Route::group(['prefix' => '/v1', 'middleware' => 'auth:api'], function () {
//     Route::get('/resources/active', function(Request $request) {
//       return $request->user();
//     });
// });

Route::group(['prefix' => '/v1'], function () {

  Route::get('/resources/{resource_type}/maintenance', 'Api\ResourceApiController@maintenance');
  Route::get('/resources/{resource}/pricing', 'Api\ResourceApiController@pricing');
  Route::get('/resources/{resource_type}/active/{mode?}', 'Api\ResourceApiController@active');
  Route::get('/resources/{resource}/{start}/{end}', 'Api\ResourceApiController@selected');
  // Route::get('/customers/active', 'Api\CustomerApiController@active');
  Route::get('/bookings', 'Api\BookingApiController@get');
  Route::get('/bookings/active', 'Api\BookingApiController@active');

  Route::group(['prefix' => '/bills'], function () {
    Route::get('/{id}', 'Api\BillApiController@show');
    Route::get('/', 'Api\BillApiController@get');
  });

  Route::group(['prefix' => '/customers'], function () {
    Route::get('/active', 'Api\CustomerApiController@active');
    Route::get('/{id}/comments', 'Api\CustomerApiController@comments');
    Route::get('/{id}', 'Api\CustomerApiController@show');
  });

  Route::group(['prefix' => '/comments'], function () {
    Route::get('/{type}/{id}', 'Api\CommentApiController@get');
  });

});


// Route::get('/v1/resources/active', function (Request $request) {
//   $repo_rs = new ResourceRepository;
//
//   $filters = new ResourceFilter(['status' => 'active']);
//
//   $list = $repo_rs->get($filters);
//
//   $return = [];
//
//   foreach ($list as $item)
//   {
//     $return[] = ['id' => $item->rs_id, 'title' => $item->rs_name];
//   }
//
//   return $return;
// })->middleware('auth:api');
