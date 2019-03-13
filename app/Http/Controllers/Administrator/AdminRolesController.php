<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

  public function index( Request $request, AdminRoles $roles )
  {
    if( $request->session()->has('admin_login') )
    {
      $getroles = $this->getroles( $roles, $request->session()->get('admin_userid') );
      return response()->view('administrator.pages.admin_roles', [
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

  public function create_role( Request $request, AdminRoles $roles )
  {
    $username = $request->username;
    $password = $request->password;
    $fullname = $request->fullname;
    $email = $request->email;
    $privilege = $request->privilege;

    $checkusername = $roles->where('username', $username);
    if( $checkusername->count() === 1 )
    {
      $res = [
        'status' => 409,
        'statusText' => $username . ' already exists.'
      ];
    }
    else
    {
      $insert = new $roles;
      $insert->username = $username;
      $insert->password_ = Hash::make( $password, ['round' => 16] );
      $insert->email = $email;
      $insert->fullname = $fullname;
      $insert->privilege = $privilege;
      $insert->save();

      $res = [
        'status' => 200,
        'statusText' => 'New admin roles added successfully.'
      ];
    }

    return response()->json( $res, $res['status'] );
  }

  public function update_role( Request $request, AdminRoles $roles, $userid )
  {
    $username = $request->username;
    $password = $request->password;
    $fullname = $request->fullname;
    $email = $request->email;
    $privilege = $request->privilege;
    $result = $roles->where('userid', $userid)->first();
    $checkusername = $roles->where('username', $username);

    if( $result->username == $username )
    {
      $result->username = $username;

      if( ! empty( $password ) )
        $result->password_ = Hash::make( $password, ['round' => 16] );

      $result->email = $email;
      $result->fullname = $fullname;
      $result->privilege = $privilege;
      $result->save();

      $res = [
        'status' => 200,
        'statusText' => 'Admin roles updated successfully.'
      ];
    }
    else
    {
      if( $checkusername->count() === 1 )
      {
        $res = [
          'status' => 409,
          'statusText' => $username . ' already exists.'
        ];
      }
      else
      {
        $insert = new $roles;
        $insert->username = $username;
        $insert->password_ = Hash::make( $password, ['round' => 16] );
        $insert->email = $email;
        $insert->fullname = $fullname;
        $insert->privilege = $privilege;
        $insert->save();

        $res = [
          'status' => 200,
          'statusText' => 'New admin roles added successfully.'
        ];
      }
    }

    return response()->json( $res, $res['status'] );
  }

  public function delete_role( Request $request, AdminRoles $roles, $userid )
  {
    $result = $roles->where('userid', $userid);
    if( $result->count() == 1 )
    {
      $getresult = $result->first();
      $res = [
        'status' => 200,
        'statusText' => $getresult->username . ' has deleted permanently.'
      ];
      $result->delete();
    }
    else
    {
      $res = [
        'status' => 200,
        'statusText' => 'No action needed.'
      ];
    }

    return response()->json( $res, $res['status'] );
  }
}
