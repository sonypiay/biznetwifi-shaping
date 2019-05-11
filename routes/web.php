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
  Route::get('/subscribers', 'Administrator\AccountSubscribersController@index')->name('admin_accountsubscriber');
  Route::get('/log_admin', 'Administrator\AdminLogActivityController@index')->name('admin_log_activity_pages');
  Route::get('/log_data_admin', 'Administrator\AdminLogActivityController@data_log_activity');
  Route::get('/roles', 'Administrator\AdminRolesController@index')->name('admin_roles_page');
  Route::get('/data_admin_roles', 'Administrator\AdminRolesController@data_admin_roles');
  Route::get('/list_account_subscribers', 'Administrator\AccountSubscribersController@data_accountsubscribers');
  Route::group(['prefix' => 'clients'], function() {
    Route::group(['prefix' => 'summary'], function() {
      Route::get('/subscribers', 'Administrator\DashboardController@summaryClientAsSubscribers');
      Route::get('/current_visitors', 'Administrator\DashboardController@summaryDeviceClientCurrentVisitor');
      Route::get('/visitors_by_date', 'Administrator\DashboardController@summaryDeviceClientAsVisitorByDate');
      Route::get('/bandwidth/{mac}', 'Administrator\AccountSubscribersController@bw_client_usage');
    });
    Route::get('/as_visitor', 'Administrator\ClientAsVisitorController@index')->name('admin_client_visitor_page');
    Route::get('/as_subscriber', 'Administrator\ClientsAsSubscriberController@index')->name('admin_client_subscriber_page');
    Route::get('/client_visitor', 'Administrator\ClientAsVisitorController@data_clientAsVisitor');
    Route::get('/client_subscriber', 'Administrator\ClientsAsSubscriberController@data_clientAsSubscriber');
  });
  Route::group(['prefix' => 'bandwidth'], function() {
    Route::get('/', 'Administrator\BandwidthUsageController@index')->name('bandwidth_dashboard_page');
    Route::get('/total_usage', 'Administrator\BandwidthUsageController@totalBandwidthUsage');
    Route::get('/ap/{type}', 'Administrator\BandwidthUsageController@getTrafficAp');
  });
  Route::group(['prefix' => 'create'], function() {
    Route::post('admin_roles', 'Administrator\AdminRolesController@create_role');
  });
  Route::group(['prefix' => 'update'], function() {
    Route::put('admin_roles/{userid}', 'Administrator\AdminRolesController@update_role');
    Route::put('subscriber/block/{account}', 'Administrator\AccountSubscribersController@blockSubscriber');
  });
  Route::group(['prefix' => 'delete'], function() {
    Route::delete('devices/{account_id}/{method}/{mac?}', 'Administrator\AccountSubscribersController@deleteDevice');
    Route::delete('admin_roles/{userid}', 'Administrator\AdminRolesController@delete_role');
  });
});
