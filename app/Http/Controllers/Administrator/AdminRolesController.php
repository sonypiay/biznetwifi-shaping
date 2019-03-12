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

  public function data_admin_roles( Request $request, AdminRoles $roles )
  {
    $keywords = $request->keywords;
    $rows = isset( $request->rows ) ? $request->rows : 10;

    if( empty( $keywords ) )
    {
      $query = $roles->orderBy('userid')
      ->paginate( $rows );
    }
    else
    {
      $query = $roles->where('username', 'like', '%' . $keywords . '%')
      ->orWhere('fullname', 'like', '%' . $keywords . '%')
      ->paginate( $rows );
    }

    return response()->json( $query, 200 );
  }
}
