<?php

namespace App\Http\Controllers\BiznetWifi;

use Illuminate\Http\Request;
use App\LdapConnection as LDAP;
use App\SterliteAPI as Sterlite;
use App\Database\AccountSubscriber;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use DB;

class LoginController extends Controller
{
  use LDAP;
  use Sterlite;

  public function index( Request $request )
  {
    if( $request->session()->has('biznetwifi_login') )
    {
      return redirect()->route('hmpgcustomer');
    }
    else
    {
      return response()->view('portal.customers.login', [
        'request' => $request,
        'session' => $request->session()->all()
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
      $this->ldap_username = strtolower( $username );
      $this->ldap_password = $password;
      $ldap = $this->auth_ldap();

      $statusLdap = $ldap;
      if( $statusLdap['status'] == 200 )
      {
        $getaccount = $subscriber->select('account_id', 'is_blocked')
        ->where('account_id', $username);

        if( $getaccount->count() != 0 )
        {
          $fetchaccount = $getaccount->first();
          if( $fetchaccount->is_blocked == 'Y' )
          {
            $res = [
              'status' => 401,
              'statusText' => 'Sorry, your account has blocked for some reason.'
            ];
          }
          else
          {
            $res = $ldap;
            $request->session()->put('displayname', $res['response']['displayname']);
            $request->session()->put('username', $this->ldap_username);
            $request->session()->put('ip', $request->server('REMOTE_ADDR'));
            $request->session()->put('agent', $request->server('HTTP_USER_AGENT'));
            $request->session()->put('logintime', time());
            $request->session()->put('biznetwifi_login', true);
            $request->session()->put('connect', 'biznetwifi');
            $request->session()->put('login_type', 'customer');
          }
        }
        else
        {
          $res = $ldap;
          $request->session()->put('displayname', $res['response']['displayname']);
          $request->session()->put('username', $this->ldap_username);
          $request->session()->put('ip', $request->server('REMOTE_ADDR'));
          $request->session()->put('agent', $request->server('HTTP_USER_AGENT'));
          $request->session()->put('logintime', time());
          $request->session()->put('biznetwifi_login', true);
          $request->session()->put('connect', 'biznetwifi');
          $request->session()->put('login_type', 'customer');
        }
      }
      else
      {
        $res = $ldap;
      }
    }
    else if( preg_match( '/^[A-Z0-9]*$/', $username ) )
    {
      $auth = $this->sterlite_auth( $username, $password );
      if( $auth['responseObject']['responseCode'] == 0 )
      {
        $getaccount = $subscriber->select('account_id', 'is_blocked')
        ->where('account_id', $username);

        if( $getaccount->count() != 0 )
        {
          $fetchaccount = $getaccount->first();
          if( $fetchaccount->is_blocked === 'N' )
          {
            $getcustomer_sterlite = $this->sterliteGetCustomerData( $auth['responseObject']['accountNumber'] );
            $res = [
              'status' => 200,
              'statusText' => 'Login berhasil'
            ];

            $request->session()->put('displayname', $getcustomer_sterlite['responseObject']['customerAccountResponseobj']['firstName']);
            $request->session()->put('username', $auth['responseObject']['accountNumber']);
            $request->session()->put('ip', $request->server('REMOTE_ADDR'));
            $request->session()->put('agent', $request->server('HTTP_USER_AGENT'));
            $request->session()->put('logintime', time());
            $request->session()->put('biznetwifi_login', true);
            $request->session()->put('connect', 'biznetwifi');
            $request->session()->put('login_type', 'customer');
          }
          else
          {
            $res = [
              'status' => 401,
              'statusText' => 'Sorry, your account has blocked for some reason.'
            ];
          }
        }
        else
        {
          $getcustomer_sterlite = $this->sterliteGetCustomerData( $auth['responseObject']['accountNumber'] );
          $res = [
            'status' => 200,
            'statusText' => 'Login berhasil'
          ];

          $request->session()->put('displayname', $getcustomer_sterlite['responseObject']['customerAccountResponseobj']['firstName']);
          $request->session()->put('username', $username);
          $request->session()->put('ip', $request->server('REMOTE_ADDR'));
          $request->session()->put('agent', $request->server('HTTP_USER_AGENT'));
          $request->session()->put('logintime', time());
          $request->session()->put('biznetwifi_login', true);
          $request->session()->put('connect', 'biznetwifi');
          $request->session()->put('login_type', 'customer');
        }
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

  public function authenticationMember(Request $request)
  {
    $username = $request->username;
    $password = md5($request->password);

    $member = DB::connection('sqlsrv')
                  ->table('Wifi_Member_Login')
                  ->join('Wifi_Member_Detail', 'Wifi_Member_Detail.ID', '=', 'Wifi_Member_Login.DETAIL_ID')
                  ->select('Wifi_Member_Login.USERNAME','Wifi_Member_Login.PASSWORD','Wifi_Member_Login.ACTIVE','Wifi_Member_Detail.FULL_NAME','Wifi_Member_Detail.EMAIL','Wifi_Member_Detail.PHONE')
                  ->where('Wifi_Member_Login.USERNAME', $username)
                  ->where('Wifi_Member_Login.PASSWORD', $password)
                  ->where('Wifi_Member_Login.ACTIVE', '1')
                  ->first();

    if($member) {

      if($member->ACTIVE != '1') {
        $res = [
          'status' => 401,
          'statusText' => 'Sorry, your account has blocked for some reason.'
        ];
      }
      else {
        $res = [
          'status' => 200,
          'statusText' => 'Login berhasil'
        ];

        $request->session()->put('displayname', $member->FULL_NAME);
        $request->session()->put('username', $member->USERNAME);
        $request->session()->put('ip', $request->server('REMOTE_ADDR'));
        $request->session()->put('agent', $request->server('HTTP_USER_AGENT'));
        $request->session()->put('logintime', time());
        $request->session()->put('biznetwifi_login', true);
        $request->session()->put('connect', 'biznetwifi');
        $request->session()->put('login_type', 'member');
      }

    }
    else {
      $res = [
        'status' => 401,
        'statusText' => 'Username / Password yang anda masukkan salah.'
      ];
    }


    return response()->json($res, $res['status']);
  }

  public function logout( Request $request )
  {
    if( $request->session()->has('biznetwifi_login') )
    {
      $request->session()->forget('biznetwifi_login');
      $request->session()->forget('displayname');
      $request->session()->forget('username');
      $request->session()->forget('ip');
      $request->session()->forget('connect');
      $request->session()->forget('logintime');
      $request->session()->forget('agent');
      $request->session()->flush();

      return redirect()->route('pagelogin_biznetwifi');
    }
    else
    {
      return redirect()->route('hmpgcustomer');
    }
  }

  public function registration(Request $request)
  {
    return response()->view('portal.customers.registration', [
      'request' => $request,
      'session' => $request->session()->all()
    ])
    ->header('Content-Type', 'text/html, charset=utf8')
    ->header('Accepts', 'text/html, charset=utf8');
  }

  public function storeRegistration(Request $request)
  {
    $member = json_decode($request->member);

    $id = DB::connection('sqlsrv')
                ->table('Wifi_Member_Detail')
                ->insertGetId([
                  'FULL_NAME' => $member->full_name,
                  'EMAIL' => $member->email,
                  'PHONE' => $member->phone,
                ]);
    
    $insert = DB::connection('sqlsrv')
        ->table('Wifi_Member_Login')
        ->insert([
          'USERNAME' => $member->username,
          'PASSWORD' => md5($member->password),
          'DETAIL_ID' => $id
        ]);

    if($insert) {
      $res = [
        'status' => 200,
        'statusText' => 'Login berhasil'
      ];

      $request->session()->put('displayname', $member->full_name);
      $request->session()->put('username', $member->username);
      $request->session()->put('ip', $request->server('REMOTE_ADDR'));
      $request->session()->put('agent', $request->server('HTTP_USER_AGENT'));
      $request->session()->put('logintime', time());
      $request->session()->put('biznetwifi_login', true);
      $request->session()->put('connect', 'biznetwifi');
      $request->session()->put('login_type', 'member');
    }
    else {
      $res = [
        'status' => 401,
        'statusText' => 'Error occured.'
      ];
    }
    
    return response()->json($res, $res['status']);
  }
}
