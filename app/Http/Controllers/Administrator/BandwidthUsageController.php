<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Database\AdminRoles;
use App\RadiusAPI;
use App\CustomFunction;
use DateTime;
use DatePeriod;
use DateInterval;

class BandwidthUsageController extends Controller
{
  use CustomFunction;
  use RadiusAPI;

  public function index( Request $request )
  {
    if( $request->session()->has('admin_login') )
    {
      $getroles = $this->getroles( new AdminRoles, $request->session()->get('admin_userid') );
      return response()->view('administrator.pages.bandwidth_usage', [
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
  public function totalBandwidthUsage( Request $request )
  {
    $api = $this->summaryBandwidthUsage( '182.253.238.66:8080', $request );
    return response()->json( $api );
  }

  public function getTrafficAp( Request $request, $ap )
  {
    $startdate = $request->startdate;
    $enddate = $request->enddate;

    $api = $this->trafficAccessPoint( $startdate, $enddate, $ap );
    return response()->json( $api );
  }
}
