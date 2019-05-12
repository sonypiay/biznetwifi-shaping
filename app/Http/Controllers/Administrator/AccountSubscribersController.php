<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Database\AccountSubscriber;
use App\Database\AdminLogActivity;
use App\Database\AdminRoles;
use App\Database\BlockedAccount;
use App\CustomFunction;
use App\RadiusAPI;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Http\Controllers\Controller;

class AccountSubscribersController extends Controller
{
  use CustomFunction;
  use RadiusAPI;

  public function index( Request $request )
  {
    if( $request->session()->has('admin_login') )
    {
      $getroles = $this->getroles( new AdminRoles, $request->session()->get('admin_userid') );
      return response()->view('administrator.pages.account_subscribers', [
        'request' => $request,
        'getsession' => $request->session()->all(),
        'roles' => $getroles
      ]);
    }
    else
    {
      return redirect()->route('admin_login');
    }
  }

  public function data_accountsubscribers( Request $request, AccountSubscriber $subscriber )
  {
    $device = isset( $request->device ) ? $request->device : 'all';
    $device = $device == 'Unknown' ? '' : $device;
    $keywords = $request->keywords;
    $searchby = isset( $request->searchby ) ? $request->searchby : 'account_id';
    $rows = $request->rows;

    if( empty( $keywords ) )
    {
      if( $device === 'all' )
      {
        $query = $subscriber->orderBy('login_date', 'desc')
        ->paginate( $rows );
      }
      else
      {
        $query = $subscriber->where( 'device_agent', '=', $device )
        ->orderBy('login_date', 'desc')
        ->paginate( $rows );
      }
    }
    else
    {
      if( $device === 'all' )
      {
        $query = $subscriber->where($searchby, 'like', '%' . $keywords . '%')
        ->orderBy('login_date', 'desc')
        ->paginate( $rows );
      }
      else
      {
        $query = $subscriber->where([
          ['device_agent', '=', $device],
          [$searchby, 'like', '%' . $keywords . '%']
        ])
        ->orderBy('login_date', 'desc')
        ->paginate( $rows );
      }
    }

    $ios = $subscriber->where('device_agent', '=', 'iOS')->count();
    $android = $subscriber->where('device_agent', '=', 'ANDROID')->count();
    $pc = $subscriber->where('device_agent', '=', 'PC/LAPTOP')->count();
    $tv = $subscriber->where('device_agent', '=', 'SMART TV')->count();
    $unknown = $subscriber->where('device_agent', '=', '')->count();

    $res = [
      'status' => 200,
      'statusText' => 'ok',
      'results' => $query,
      'device_total' => [
        'ios' => $ios,
        'android' => $android,
        'pc' => $pc,
        'tv' => $tv,
        'unknown' => $unknown
      ]
    ];

    return response()->json( $res, $res['status'] );
  }

  public function deleteDevice( Request $request, AdminRoles $users, AccountSubscriber $subscriber, AdminLogActivity $log, $seqid, $method )
  {
    $getsubscriber = $subscriber->where('seqid', $seqid)->first();
    $account_id = $getsubscriber->account_id;

    if( $method === 'single' )
    {
      $result = $users->where('userid', $request->session()->get('admin_userid'))->first();
      $logs = new $log;
      $logs->log_username = $result->username;
      $logs->log_ip = $request->server('REMOTE_ADDR');
      $logs->log_os = $this->getOsInfo( $request->server('HTTP_USER_AGENT') );
      $logs->log_browser = $this->getBrowserInfo( $request->server('HTTP_USER_AGENT') );
      $logs->log_description = $result->fullname . ' has delete devices.';
      $logs->log_type = 'Delete';
      $logs->save();

      $res = [
        'status' => 200,
        'statusText' => 'Device ' . $getsubscriber->mac_address . ' deleted.'
      ];

      $this->delete_radcheck( '182.253.238.66:8080', $getsubscriber->mac_address );
      $subscriber->where('seqid', $seqid)->delete();
    }
    else
    {
      $getdevice = $subscriber->where('account_id', $account_id);
      $res = [
        'status' => 200,
        'statusText' => 'OK'
      ];

      if( $getdevice->count() != 0 )
      {
        foreach( $getdevice->get() as $device )
        {
          $this->delete_radcheck( '182.253.238.66:8080', $device->mac_address );
        }
        $getdevice->delete();

        $res = [
          'status' => 200,
          'statusText' => 'Device ' . $account_id . ' successfully deleted.'
        ];
      }
      else
      {
        $res = [
          'status' => 200,
          'statusText' => 'Whoops, ' . $account_id . ' not found.'
        ];
      }
    }
    return response()->json( $res, $res['status'] );
  }

  public function bw_client_usage( Request $request, $mac )
  {
    $data_bandwidth = $this->bandwidthClientUsage( '182.253.238.66:8080', $mac, $request );
    return response()->json( $data_bandwidth );
  }

  public function blockSubscriber( Request $request, AccountSubscriber $subscriber, AdminRoles $users, AdminLogActivity $logs, $account_id )
  {
    $logs = new $logs;
    $result = $users->where('userid', $request->session()->get('admin_userid'))->first();
    $logs->log_username = $result->username;
    $logs->log_ip = $request->server('REMOTE_ADDR');
    $logs->log_os = $this->getOsInfo( $request->server('HTTP_USER_AGENT') );
    $logs->log_browser = $this->getBrowserInfo( $request->server('HTTP_USER_AGENT') );
    $logs->log_description = $result->fullname . ' blocked account id ' . $account_id . '.';
    $logs->log_type = 'Update';
    $logs->save();

    $getaccount = $subscriber->where('account_id', $account_id);
    $statusaccount = $subscriber->select('account_id', 'is_blocked')
    ->where('account_id', $account_id)->first();

    if( $statusaccount->is_blocked === 'N' )
    {
      foreach( $getaccount->get() as $device )
      {
        $this->delete_radcheck( '182.253.238.66:8080', $device->mac_address );
      }
      $getaccount->update(['is_blocked' => 'Y']);

      $res = [
        'status' => 200,
        'statusText' => 'Account ID ' . $account_id . ' blocked.'
      ];
    }
    else
    {
      foreach( $getaccount->get() as $device )
      {
        $this->add_radcheck( '182.253.238.66:8080', $device->mac_address, $account_id );
      }

      $getaccount->update(['is_blocked' => 'N']);
      $res = [
        'status' => 200,
        'statusText' => 'Blocking has opened for ' . $account_id
      ];
    }

    return response()->json( $res, $res['status'] );
  }
}
