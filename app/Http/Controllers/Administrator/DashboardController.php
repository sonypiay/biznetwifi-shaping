<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Database\AdminRoles;
use App\Database\AccountSubscriber;
use App\Database\ClientsUsage;
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

  public function summaryClientAsSubscribers( Request $request, AccountSubscriber $subscriber)
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

  public function summaryDeviceClientAsVisitor( Request $request, ClientsUsage $clients )
  {
    $filterdate = isset( $request->filterdate ) ? $request->filterdate : 'today';

    $totalDeviceConnected = $clients->select(
      'client_os',
      DB::raw('count(*) as total_device')
    )->where('connection_type', '=', 'visitor')->groupBy('client_os')
    ->orderBy(DB::raw('count(*)'), 'desc');

    $res = [
      'results' => [
        'total_device' => $totalDeviceConnected->count(),
        'data_device' => $totalDeviceConnected->get()
      ]
    ];
    return response()->json( $res );
  }

  public function summaryDeviceClientAsVisitorByDate( Request $request, ClientsUsage $clients )
  {
    $filterdate = isset( $request->filterdate ) ? $request->filterdate : 'today';

    if( $filterdate == 'today' )
    {
      $currentTime = new DateTime( '00:00' );
      $updatedTime = date('H:i');

      $query = $clients->select(
        'client_os',
        DB::raw('count(*) as total_device')
      )->where([
        ['connection_type', '=', 'visitor'],
        [DB::raw('date_format(updated_at, "%H-%i")'), '>=', $currentTime->format('H:i')],
        [DB::raw('date_format(updated_at, "%H-%i")'), '<=', $updatedTime]
      ])->groupBy('client_os')
      ->orderBy(DB::raw('count(*)'), 'desc')->get();

      $dataset = [
        'date' => date('F d, Y'),
        'results' => $query
      ];
    }
    else if( $filterdate == 'this_month' OR $filterdate == 'last_month' )
    {
      if( $filterdate == 'this_month' )
      {
        $currentMonth = new DateTime( 'first day of this month' );
        $endMonth = new DateTime( 'last day of this month' );
      }
      else if( $filterdate == 'last_month' )
      {
        $currentMonth = new DateTime( 'first day of last month' );
        $endMonth = new DateTime( 'last day of this month' );
      }

      $interval = new DateInterval('P1D');
      $period = new DatePeriod( $currentMonth, $interval, $endMonth );

      $rangeDate = [];
      foreach( $period as $date )
      {
        $rangeDate[] = [
          'dateValue' => $date->format('Y-m-d'),
          'formatDate' => $date->format('F d, Y')
        ];
      }

      $dataset = [
        'records' => [],
        'date' => '',
        'os' => [
          'ios' => [ 'total' => 0, 'label' => 'iOS' ],
          'android' => [ 'total' => 0, 'label' => 'Android' ],
          'windows' => [ 'total' => 0, 'label' => 'Windows' ],
          'linux' => [ 'total' => 0, 'label' => 'Linux' ],
          'macos' => [ 'total' => 0, 'label' => 'Mac OS' ],
          'other' => [ 'total' => 0, 'label' => 'Other' ]
        ]
      ];
      
      foreach( $rangeDate as $key => $value )
      {
        $ios = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'iOS'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();
        $android = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'Android'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();
        $windows = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'Windows'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();
        $linux = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'Linux'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();
        $macos = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'Mac OS'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();
        $other = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'Other'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();

        $dataset['records'][] = [
          'date' => $value['dateValue'],
          'os' => [
            'ios' => [ 'total' => $ios, 'label' => 'iOS' ],
            'android' => [ 'total' => $android, 'label' => 'Android' ],
            'windows' => [ 'total' => $windows, 'label' => 'Windows' ],
            'linux' => [ 'total' => $linux, 'label' => 'Linux' ],
            'macos' => [ 'total' => $macos, 'label' => 'Mac OS' ],
            'other' => [ 'total' => $other, 'label' => 'Other' ]
          ]
        ];
      }
    }
    else if( $filterdate == '3month' )
    {
      $currentMonth = new DateTime( $filtermonth );
      $endMonth = new DateTime( 'this month' );
      $interval = new DateInterval('P1M');
      $period = new DatePeriod( $currentMonth, $interval, $endMonth );
    }
    else
    {
      if( $filterdate == '7days' )
      {
        $previousDate = new DateTime('7 days ago');
      }
      else if( $filterdate == '28days' )
      {
        $previousDate = new DateTime('28 days ago');
      }
      else
      {
        $previousDate = new DateTime('30 days ago');
      }

      $currentDate = new DateTime('today');
      $interval = new DateInterval('P1D');
      $period = new DatePeriod( $previousDate, $interval, $currentDate );
      $rangeDate = [];
      foreach( $period as $date )
      {
        $rangeDate[] = [
          'dateValue' => $date->format('Y-m-d'),
          'formatDate' => $date->format('F d, Y')
        ];
      }

      $dataset = [
        'records' => [],
        'date' => '',
        'os' => [
          'ios' => [ 'total' => 0, 'label' => 'iOS' ],
          'android' => [ 'total' => 0, 'label' => 'Android' ],
          'windows' => [ 'total' => 0, 'label' => 'Windows' ],
          'linux' => [ 'total' => 0, 'label' => 'Linux' ],
          'macos' => [ 'total' => 0, 'label' => 'Mac OS' ],
          'other' => [ 'total' => 0, 'label' => 'Other' ]
        ]
      ];
      foreach( $rangeDate as $key => $value )
      {
        $ios = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'iOS'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();
        $android = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'Android'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();
        $windows = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'Windows'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();
        $linux = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'Linux'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();
        $macos = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'Mac OS'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();
        $other = $clients->where([
          ['connection_type', '=', 'visitor'],
          ['client_os', '=', 'Other'],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', $value['dateValue']]
        ])->count();

        $dataset['records'][] = [
          'date' => $value['dateValue'],
          'os' => [
            'ios' => [ 'total' => $ios, 'label' => 'iOS' ],
            'android' => [ 'total' => $android, 'label' => 'Android' ],
            'windows' => [ 'total' => $windows, 'label' => 'Windows' ],
            'linux' => [ 'total' => $linux, 'label' => 'Linux' ],
            'macos' => [ 'total' => $macos, 'label' => 'Mac OS' ],
            'other' => [ 'total' => $other, 'label' => 'Other' ]
          ]
        ];
      }
    }

    return response()->json( $dataset );
  }
}
