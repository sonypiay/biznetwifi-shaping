<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Database\AccountSubscriber;
use App\RadiusAPI;
use App\CustomFunction;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Http\Controllers\Controller;

class AccountSubscribersController extends Controller
{
  public function index( Request $request )
  {
    if( $request->session()->has('admin_login') )
    {
      return response()->view('administrator.pages.device_connected', [
        'request' => $request,
        'getsession' => $request->session()->all()
      ]);
    }
    else
    {
      return redirect()->route('admin_login');
    }
  }

  public function data_deviceconnected( Request $request, AccountSubscriber $subscriber )
  {
    $device = isset( $request->device ) ? $request->device : 'all';
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

    $res = [
      'status' => 200,
      'statusText' => 'ok',
      'results' => $query,
      'device_total' => [
        'ios' => $ios,
        'android' => $android,
        'pc' => $pc,
        'tv' => $tv
      ]
    ];

    return response()->json( $res, $res['status'] );
  }
}
