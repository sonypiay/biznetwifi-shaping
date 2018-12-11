<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomepageController@homepage')->name('homepage');
Route::get('/connect/ruckus', 'PortalController@connectruckus')->name('connect_ruckus');
Route::post('/connect/mikrotik', 'PortalController@connectmikrotik')->name('connect_mikrotik');
Route::get('/freehotspot', 'PortalController@hotspot');
Route::get('/afterlogin', 'PortalController@afterlogin');
Route::get('/test', 'PortalController@testradius');
Route::get('/testlocation', 'PortalController@test_location');

Route::group(['prefix' => 'biznetwifi'], function() {
  Route::get('/login', 'BiznetWifi\LoginController@index')->name('pagelogin_biznetwifi');
  Route::get('/logout', 'BiznetWifi\LoginController@logout')->name('logoutpage');
  Route::post('/auth', 'BiznetWifi\LoginController@authentication');
  Route::get('/afterlogin', 'PortalController@afterlogin')->name('bzw_afterlogin');

  // homepage customer
  Route::get('/customers', 'BiznetWifi\DashboardController@homepage_customer')->name('hmpgcustomer');
  // homepage customer
  Route::get('/devicesubscriber/{customerid}', 'BiznetWifi\AccountSubscriberController@datadevice');
  Route::delete('/deletedevice/{username}/{mac}', 'BiznetWifi\AccountSubscriberController@destroy');
});

Route::group(['prefix' => 'admin'], function() {
  Route::get('/', function() { return redirect('admin_login'); });
  Route::get('/login', 'Administrator\LoginController@index')->name('admin_login');
});
