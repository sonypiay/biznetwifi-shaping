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
Route::post('/change_locale/{locale}', 'HomepageController@change_locale')->name('change_locale');
Route::get('/connect/ruckus', 'PortalController@connectruckus')->name('connect_ruckus');
Route::post('/connect/mikrotik', 'PortalController@connectmikrotik')->name('connect_mikrotik');
Route::get('/freehotspot', 'PortalController@hotspot');
Route::get('/afterlogin', 'PortalController@afterlogin');
Route::get('/testing', 'PortalController@testing');

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
  Route::get('/', function() { return redirect()->route('admin_login'); });
  Route::get('/login', 'Administrator\LoginController@index')->name('admin_login');
  Route::group(['prefix' => 'auth'], function() {
    Route::post('/login', 'Administrator\LoginController@dologin');
    Route::get('/logout', 'Administrator\LoginController@dologout')->name('admin_signout');
  });

  Route::get('/dashboard', 'Administrator\DashboardController@index')->name('admin_dashboard');
  Route::get('/devices', 'Administrator\AccountSubscribersController@index')->name('admin_deviceconnected');
  Route::get('/log_admin', 'Administrator\AdminLogActivityController@index')->name('admin_log_activity_pages');
  Route::get('/log_data_admin', 'Administrator\AdminLogActivityController@data_log_activity');
  Route::get('/list_device_connected', 'Administrator\AccountSubscribersController@data_deviceconnected');
  Route::group(['prefix' => 'delete'], function() {
    Route::delete('devices/{account_id}/{mac}', 'Administrator\AccountSubscribersController@deleteDevice');
  });
});
