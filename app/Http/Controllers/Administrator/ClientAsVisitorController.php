<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Database\AdminRoles;
use App\Database\ClientsUsage;
use App\CustomFunction;
use App\RadiusAPI;
use App\Http\Controllers\Controller;
use DateTime;
use DateInterval;
use DatePeriod;

class ClientAsVisitorController extends Controller
{
  use CustomFunction;
  use RadiusAPI;

  public function index( Request $request, AdminRoles $roles )
  {
    if( $request->session()->has('admin_login') )
    {
      $getroles = $this->getroles( new AdminRoles, $request->session()->get('admin_userid') );
      return response()->view('administrator.pages.client_as_visitor', [
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

  public function data_clientAsVisitor( Request $request, ClientsUsage $clients )
  {
    $keywords = $request->keywords;
    $rows = isset( $request->rows ) ? $request->rows : 10;
    $filterdate = isset( $request->filterdate ) ? $request->filterdate : 'today';
    $startDate = isset( $request->startDate ) ? $request->startDate : date('Y-m-d');
    $endDate = isset( $request->endDate ) ? $request->endDate : date('Y-m-d');

    $beginDate = new DateTime( $startDate );
    $endDate = new DateTime( $endDate );

    if( isset( $request->filterdate ) )
    {
      if( $filterdate === 'today' )
      {
        $beginDate = $beginDate->format('Y-m-d');
      }
      else if( $filterdate === '7days' )
      {
        $endDate = $endDate->modify('7 days ago');
      }
      else if( $filterdate === '' )
    }
    else
    {
      $res = [
        'status' => 200,
        'statusText' => 'customdate'
      ];
    }

    return response()->json( $res );
  }
}
