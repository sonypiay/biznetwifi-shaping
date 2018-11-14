<?php

namespace App\Http\Controllers\BiznetWifi;

use Illuminate\Http\Request;
use App\LdapConnection as LDAP;
use App\SterliteAPI as Sterlite;
use App\Database\AccountSubscriber;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
  use LDAP;
  use Sterlite;

  public function index( Request $request )
  {
    if( Cookie::get('hasLoginBiznetWifi') )
    {
      return redirect()->route('hmpgcustomer');
    }
    else
    {
      return response()->view('portal.customers.login', [
        'request' => $request
      ])
      ->header('Content-Type', 'text/html, charset=utf8')
      ->header('Accepts', 'text/html, charset=utf8');
    }
  }

  public function authentication( Request $request, AccountSubscriber $subscriber )
  {
    $username = $request->username;
    $password = $request->password;

    if( preg_match( "/^[a-zA-Z+_]*$/", $username ) )
    {
      $this->ldap_username = $username;
      $this->ldap_password = $password;
      $ldap = $this->auth_ldap();

      $res = $ldap;
      if( $res['status'] == 200 )
      {
        $cookieexpired = time() + 60 * 60 * 24 * 30;
        Cookie::queue( Cookie::make('displayname', $res['response']['displayname']), $cookieexpired, '/');
        Cookie::queue( Cookie::make('username',$username, $cookieexpired, '/'));
        Cookie::queue( Cookie::make('ip', $request->server('REMOTE_ADDR'), $cookieexpired, '/'));
        Cookie::queue( Cookie::make('agent', $request->server('HTTP_USER_AGENT'), $cookieexpired, '/'));
        Cookie::queue( Cookie::make('logintime', time(), $cookieexpired, '/'));
        Cookie::queue( Cookie::make('hasLoginBiznetWifi', true, $cookieexpired, '/'));
        Cookie::queue( Cookie::make('connect', 'biznetwifi', time() + 36000) );
      }
    }
    else if( preg_match( '/^[A-Z0-9]*$/', $username ) )
    {
      $auth = $this->sterlite_auth( $username, $password );
      if( $auth['responseObject']['responseCode'] == 0 )
      {
        $getcustomer_sterlite = $this->sterliteGetCustomerData( $auth['responseObject']['accountNumber'] );
        $res = [
          'status' => 200,
          'statusText' => 'Login berhasil'
        ];

        $cookieexpired = time() + 60 * 60 * 24 * 30;
        Cookie::queue( Cookie::make('displayname', $getcustomer_sterlite['responseObject']['customerAccountResponseobj']['firstName'], $cookieexpired, '/'));
        Cookie::queue( Cookie::make('username',$auth['responseObject']['accountNumber'], $cookieexpired, '/'));
        Cookie::queue( Cookie::make('ip', $request->server('REMOTE_ADDR'), $cookieexpired, '/'));
        Cookie::queue( Cookie::make('agent', $request->server('HTTP_USER_AGENT'), $cookieexpired, '/'));
        Cookie::queue( Cookie::make('logintime', time(), $cookieexpired, '/'));
        Cookie::queue( Cookie::make('hasLoginBiznetWifi', true, $cookieexpired, '/'));
        Cookie::queue( Cookie::make('connect', 'biznetwifi', time() + 36000) );
      }
      else
      {
        $res = [
          'status' => 401,
          'statusText' => $auth['responseObject']['responseMessage']
        ];
      }
    }
    else
    {
      $res = [
        'status' => 401,
        'statusText' => 'Username / Password yang anda masukkan salah.',
        'response' => ''
      ];
    }
    return response()->json($res, $res['status']);
  }

  public function logout( Request $request )
  {
    if( Cookie::get('hasLoginBiznetWifi') )
    {
      Cookie::queue( Cookie::forget('username') );
      Cookie::queue( Cookie::forget('displayname') );
      Cookie::queue( Cookie::forget('ip') );
      Cookie::queue( Cookie::forget('connect') );
      Cookie::queue( Cookie::forget('agent') );
      Cookie::queue( Cookie::forget('logintime') );
      Cookie::queue( Cookie::forget('hasLoginBiznetWifi') );

      return redirect()->route('pagelogin_biznetwifi');
    }
    else
    {
      return redirect()->route('hmpgcustomer');
    }
  }
}
