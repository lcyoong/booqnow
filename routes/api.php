<?php

use Illuminate\Http\Request;
use Repositories\ResourceRepository;
use App\ResourceFilter;

Route::model('resource_type', 'App\ResourceType');
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
    Route::get('/resources/{resource_type}/active', 'Api\ResourceApiController@active');
    Route::get('/customers/active', 'Api\CustomerApiController@active');
    Route::get('/bookings/active', 'Api\BookingApiController@active');
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
