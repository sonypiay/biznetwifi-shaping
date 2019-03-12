<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Database\AccountSubscriber;
use App\Database\AdminRoles;
use App\CustomFunction;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Http\Controllers\Controller;

class AdminRolesController extends Controller
{
  use CustomFunction;

  public function index( Request $request )
  {
    if( $request->session()->has('admin_login') )
    {
      return response()->view('administrator.pages.admin_roles', [
        'request' => $request,
        'getsession' => $request->session()->all()
      ]);
    }
    else
    {
      return redirect()->route('admin_login');
    }
  }

  public function data_admin_role( Request $request, AdminRoles $roles )
  {
    $keywords = $request->keywords;
    
  }
}
