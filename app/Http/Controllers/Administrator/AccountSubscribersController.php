<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Database\AccountSubscriber;
use App\Database\AdminLogActivity;
use App\Database\AdminRoles;
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

  public function deleteDevice( Request $request, AdminRoles $users, AccountSubscriber $subscriber, AdminLogActivity $log, $account_id, $mac )
  {
    $query = $subscriber->where([
      ['account_id', '=', $account_id],
      ['mac_address', '=', $mac]
    ]);
    if( $query->count() !== 0 )
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

      $this->timeout_socket = 3;
      $radprimary = $this->check_connection('182.253.238.66', 3306);
      $radbackup = $this->check_connection('202.169.53.9', 3306);

      if( $radprimary['status'] == null )
      {
        $this->delete_radcheck( '182.253.238.66:8080', $mac );
        $query->delete();
        $res = [
          'status' => 200,
          'statusText' => $mac . ' deleted.'
        ];
      }
      else if( $radbackup['status'] == null )
      {
        $this->delete_radcheck( '202.169.53.9', $mac );
        $query->delete();
        $res = [
          'status' => 200,
          'statusText' => $mac . ' deleted.'
        ];
      }
      else
      {
        $res = [
          'status' => 500,
          'statusText' => $radbackup['statusText']
        ];
      }
    }
    else
    {
      $res = [
        'status' => 200,
        'statusText' => 'Whoops, ' . $mac . ' not found'
      ];
    }

    return response()->json( $res, $res['status'] );
  }

  public function bw_client_usage( Request $request, $mac )
  {
    $data_bandwidth = $this->bandwidthClientUsage( '182.253.238.66:8080', $mac, $request );
    return response()->json( $data_bandwidth );
  }
}
