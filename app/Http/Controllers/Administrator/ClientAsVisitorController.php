<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Database\AdminRoles;
use App\Database\ClientsUsage;
use App\CustomFunction;
use App\RadiusAPI;
use App\Http\Controllers\Controller;

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
  }
}
