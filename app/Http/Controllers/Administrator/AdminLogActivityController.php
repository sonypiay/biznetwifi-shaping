<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Database\AccountSubscriber;
use App\Database\AdminLogActivity;
use App\Database\UsersPanel;
use App\CustomFunction;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Http\Controllers\Controller;

class AdminLogActivityController extends Controller
{
  use CustomFunction;

  public function index( Request $request, UsersPanel $users )
  {
    if( $request->session()->has('admin_login') )
    {
      return response()->view('administrator.pages.admin_log', [
        'request' => $request,
        'getsession' => $request->session()->all()
      ]);
    }
    else
    {
      return redirect()->route('admin_login');
    }
  }

  public function data_log_activity( Request $request, AdminLogActivity $logs )
  {
    $keywords = $request->keywords;
    $filterdevice = isset( $request->device ) ? $request->device : 'all';
    $rows = isset( $request->rows ) ? $request->rows : 10;

    if( empty( $keywords ) )
    {
      if( $filterdevice == 'all' )
      {
        $query = $logs->orderBy('log_id', 'desc')
        ->paginate( $rows );
      }
      else
      {
        $query = $logs->where('log_os', '=', $filterdevice)
        ->orderBy('log_id', 'desc')
        ->paginate( $rows );
      }
    }
    else
    {
      if( $filterdevice == 'all' )
      {
        $query = $logs->where('log_ip', 'like', '%' . $keywords . '%')
        ->orWhere('log_username', 'like', '%' . $keywords . '%')
        ->orderBy('log_id', 'desc')
        ->paginate( $rows );
      }
      else
      {
        $query = $logs->where([
          ['log_os', '=', $filterdevice],
          ['log_ip', 'like', '%' . $keywords . '%']
        ])
        ->orWhere([
          ['log_os', '=', $filterdevice],
          ['log_username', 'like', '%' . $keywords . '%']
        ])
        ->orderBy('log_id', 'desc')
        ->paginate( $rows );
      }
    }

    return response()->json( $query, 200 );
  }
}
