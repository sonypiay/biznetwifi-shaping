<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\CustomFunction;
use App\Database\AdminRoles;
use App\Database\AdminLogActivity;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
  use CustomFunction;

  public function index( Request $request, AdminRoles $users )
  {
    if( $request->session()->has('admin_login') )
    {
      return redirect()->route('admin_dashboard');
    }
    else
    {
      $data = [
        'request' => $request->all(),
        'session' => $request->session()->all()
      ];
      return response()->view('administrator.login', $data);
    }
  }

  public function dologin( Request $request, AdminRoles $users, AdminLogActivity $log )
  {
    $username = $request->username;
    $password = $request->password;
    $query = $users->where( 'username', $username );
    if( $query->count() === 1 )
    {
      $result = $query->first();
      if( Hash::check( $password, $result->password_ ) )
      {
        $data = [
          'statusText' => 'Login success',
          'status' => 200
        ];
        $request->session()->put('admin_userid', $result->userid);
        $request->session()->put('admin_logintime', date('Y-m-d H:i:s'));
        $request->session()->put('admin_login', true);

        $logs = new $log;
        $logs->log_username = $username;
        $logs->log_ip = $request->server('REMOTE_ADDR');
        $logs->log_os = $this->getOsInfo( $request->server('HTTP_USER_AGENT') );
        $logs->log_browser = $this->getBrowserInfo( $request->server('HTTP_USER_AGENT') );
        $logs->log_description = $result->fullname . ' has logged in';
        $logs->log_type = 'Log On';
        $logs->save();
      }
      else
      {
        $data = [
          'statusText' => 'Access denied. Please enter your correct password.',
          'status' => 403
        ];

        $logs = new $log;
        $logs->log_username = $username;
        $logs->log_ip = $request->server('REMOTE_ADDR');
        $logs->log_os = $this->getOsInfo( $request->server('HTTP_USER_AGENT') );
        $logs->log_browser = $this->getBrowserInfo( $request->server('HTTP_USER_AGENT') );
        $logs->log_description = $result->fullname . ' has failed to log on';
        $logs->log_type = 'Log on failed';
        $logs->save();
      }
    }
    else
    {
      $data = [
        'statusText' => 'Username did not match',
        'status' => 403
      ];

      $logs = new $log;
      $logs->log_username = $username;
      $logs->log_ip = $request->server('REMOTE_ADDR');
      $logs->log_os = $this->getOsInfo( $request->server('HTTP_USER_AGENT') );
      $logs->log_browser = $this->getBrowserInfo( $request->server('HTTP_USER_AGENT') );
      $logs->log_description = $username . ' has no match';
      $logs->log_type = 'Log on failed';
      $logs->save();
    }
    return response()->json($data, $data['status']);
  }

  public function dologout( Request $request, AdminRoles $users, AdminLogActivity $log )
  {
    if( $request->session()->has('admin_login') )
    {
      $result = $users->where('userid', $request->session()->get('admin_userid'))->first();

      $logs = new $log;
      $logs->log_username = $result->username;
      $logs->log_ip = $request->server('REMOTE_ADDR');
      $logs->log_os = $this->getOsInfo( $request->server('HTTP_USER_AGENT') );
      $logs->log_browser = $this->getBrowserInfo( $request->server('HTTP_USER_AGENT') );
      $logs->log_description = $result->fullname . ' has logged off';
      $logs->log_type = 'Log Off';
      $logs->save();

      $request->session()->forget(['admin_login'],['admin_logintime'],['admin_userid']);
      $request->session()->flush();

      return redirect()->route('admin_login');
    }
    else
    {
      return redirect()->route('admin_login');
    }
  }
}
