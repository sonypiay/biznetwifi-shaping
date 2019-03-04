<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Database\UsersPanel;
use App\Http\Controllers\Controller;
use App\RadiusAPI;
use App\CustomFunction;
use DateTime;
use DatePeriod;
use DateInterval;

class DashboardController extends Controller
{
  public function index( Request $request )
  {
    if( $request->session()->has('admin_login') )
    {
      return response()->view('administrator.pages.dashboard', [
        'request' => $request,
        'getsession' => $request->session()->all()
      ]);
    }
    else
    {
      return redirect()->route('admin_login');
    }
  }
}
