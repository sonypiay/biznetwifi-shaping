<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Database\AdminRoles;
use App\Database\AccountSubscriber;
use App\Http\Controllers\Controller;
use App\RadiusAPI;
use App\CustomFunction;
use DateTime;
use DatePeriod;
use DateInterval;

class DashboardController extends Controller
{
  use CustomFunction;

  public function index( Request $request )
  {
    if( $request->session()->has('admin_login') )
    {
      $getroles = $this->getroles( new AdminRoles, $request->session()->get('admin_userid') );
      return response()->view('administrator.pages.dashboard', [
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

  public function device_connected( Request $request, AccountSubscriber $subscriber)
  {
    $ios = $subscriber->where('device_agent', '=', 'iOS')->count();
    $android = $subscriber->where('device_agent', '=', 'ANDROID')->count();
    $pc = $subscriber->where('device_agent', '=', 'PC/LAPTOP')->count();
    $tv = $subscriber->where('device_agent', '=', 'SMART TV')->count();
    $unknown = $subscriber->where('device_agent', '=', '')->count();
    $alldevice = $ios + $android + $pc + $tv + $unknown;
    $res = [
      'status' => 200,
      'results' => [
        'total' => $alldevice,
        'device' => [
          'ios' => $ios,
          'android' => $android,
          'pc' => $pc,
          'tv' => $tv,
          'unknown' => $unknown
        ]
      ]
    ];

    return response()->json( $res );
  }
}
