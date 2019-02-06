<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Database\AccountSubscriber;
use App\RadiusAPI;
use App\CustomFunction;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class PortalController extends Controller
{
  use RadiusAPI;
  use CustomFunction;

  public function connectmikrotik( Request $request )
  {
    if( ! $request->session()->has('session_locale') )
    {
      $locale = app()->getLocale();
      session()->put('session_locale', $locale);
    }

    $getlocale = session()->get('session_locale');
    app()->setLocale( $getlocale );

    $ap = $request->ap;
    $client_mac = $request->client_mac;
    $uip = $request->uip;
    $ssid = $request->ssid;
    $startUrl = $request->starturl;
    $location = $request->loc;
    $shaping = $request->shaping;

    if( $ap == 'mkt' )
    {
      $startUrl = 'http://biznethotspot.qeon.co.id';
    }

    if( isset( $client_mac ) AND ! empty( $client_mac ) )
    {
      $request->session()->put('client_mac', $client_mac);
      $request->session()->put('uip', $uip);
      $request->session()->put('starturl', $startUrl);
    }

    $filter_location = explode('-', $location);
    $merchant = $this->get_merchant( $filter_location[1] );

    return response()->view('portal.connect', [
      'mac' => $client_mac,
      'uip' => $uip,
      'ssid' => $ssid,
      'startUrl' => $startUrl,
      'loc' => [
        'origin' => $location,
        'merchant' => $merchant
      ],
      'ap' => $ap,
      'shaping' => $shaping
    ])
    ->header('Content-Type', 'text/html; charset=utf8')
    ->header('Accepts', 'text/html; charset=utf8')
    ->header('Access-Control-Allow-Headers', 'POST');
  }

  public function connectruckus( Request $request )
  {
    if( ! $request->session()->has('session_locale') )
    {
      $locale = app()->getLocale();
      session()->put('session_locale', $locale);
    }

    $getlocale = session()->get('session_locale');
    app()->setLocale( $getlocale );

    $ap = $request->ap;
    $client_mac = $request->client_mac;
    $uip = $request->uip;
    $ssid = $request->ssid;
    $startUrl = $request->StartURL;
    $location = $request->loc;
    $shaping = $request->shaping;

    if( isset( $client_mac ) AND ! empty( $client_mac ) )
    {
      $request->session()->put('client_mac', $client_mac);
      $request->session()->put('uip', $uip);
      $request->session()->put('starturl', $startUrl);
    }

    $convert_string = hex2bin( $location );
    $filter_location = explode('-', $convert_string);
    $merchant = $this->get_merchant( $filter_location[1] );

    return response()->view('portal.connect', [
      'mac' => $client_mac,
      'uip' => $uip,
      'ssid' => $ssid,
      'startUrl' => $startUrl,
      'loc' => [
        'origin' => $convert_string,
        'merchant' => $merchant
      ],
      'ap' => $ap,
      'shaping' => $shaping
    ])
    ->header('Content-Type', 'text/html; charset=utf8')
    ->header('Accepts', 'text/html; charset=utf8')
    ->header('Access-Control-Allow-Headers', 'GET');
  }

  public function afterlogin( Request $request, AccountSubscriber $subscriber )
  {
    if( $request->session()->get('connect') == 'freehotspot' )
    {
      $fullUrl = $request->fullUrl();

      $fullUrlParts = parse_url($fullUrl);
      $redirectUrl = 'http://biznethotspot.qeon.co.id/a' . (isset($fullUrlParts['query']) ? ('?' . $fullUrlParts['query']) : '');
      $request->session()->forget('connect');
      $request->session()->flush();
      return redirect($redirectUrl);
    }
    else if( $request->session()->get('connect') == 'biznetwifi' )
    {
      if( $request->session()->has('client_mac') AND $request->session()->has('uip') )
      {
        $mac = $request->session()->get('client_mac');
        $username = $request->session()->get('username');
        $displayname = $request->session()->get('displayname');
        $agent = $request->session()->get('agent');

        $checksubs = $subscriber->where('account_id', '=', $username);
        if( $checksubs->count() === 4 )
        {
          $getuser = $checksubs->orderBy('login_date', 'asc')->first();
          $getcurrentmac = $subscriber->select('mac_address')->where([
            ['account_id', $username],
            ['mac_address', $mac]
          ]);

          if( $getcurrentmac->count() == 0 )
          {
            $this->timeout_socket = 2;
            $radprimary = $this->check_connection('202.169.53.9', 3306);
            //$radbackup = $this->check_connection('182.253.238.66', 3306);

            if( $radprimary['status'] == null )
            {
              $this->add_radcheck( '202.169.53.9', $mac, $username );
              $this->delete_radcheck( '202.169.53.9', $getuser->mac_address );
            }
            /*else
            {
              $this->add_radcheck( '182.253.238.66:8080', $mac, $username );
              $this->delete_radcheck( '182.253.238.66:8080', $getuser->mac_address );
            }*/

            $subscriber->account_id = $username;
            $subscriber->mac_address = $mac;
            $subscriber->login_date = date('Y-m-d H:i:s');
            $subscriber->device_agent = $this->userAgent( $agent );
            $subscriber->save();
            $subscriber->where([ ['username', '=', $username], ['mac_address', '=', $getuser->mac_address] ])->delete();
          }
        }
        else
        {
          $getcurrentmac = $subscriber->select('mac_address')->where([
            ['account_id', $username],
            ['mac_address', $mac]
          ]);

          if( $getcurrentmac->count() == 0 )
          {
            $this->timeout_socket = 2;
            $radprimary = $this->check_connection('202.169.53.9', 3306);
            //$radbackup = $this->check_connection('182.253.238.66', 3306);
            if( $radprimary['status'] == null )
            {
              $this->add_radcheck( '202.169.53.9', $mac, $username );
            }
            /*else
            {
              $this->add_radcheck( '182.253.238.66:8080', $mac, $username );
            }*/

            $subscriber->account_id = $username;
            $subscriber->mac_address = $mac;
            $subscriber->login_date = date('Y-m-d H:i:s');
            $subscriber->device_agent = $this->userAgent( $agent );
            $subscriber->save();
          }
        }
        return redirect()->route('hmpgcustomer');
      }
      else
      {
        if( $request->session()->has('connect') )
        {
          if( $request->session()->get('connect') == 'freehotspot' )
          {
            return redirect()->route('connect_mikrotik');
          }
          else
          {
            return redirect()->route('connect_ruckus');
          }
        }
        else
        {
          return redirect()->route('connect_mikrotik');
        }
      }
    }
  }

  public function hotspot( Request $request )
  {
    $request->session()->put('connect', 'freehotspot');
    $ap = $request->ap;
    $client_mac = $request->client_mac;
    $uip = $request->uip;
    $ssid = $request->ssid;
    $starturl = 'http://biznethotspot.qeon.co.id';
    $location = $request->loc;
    $redirect = 'http://biznethotspot.qeon.co.id?ap=' . $ap . '&src=BiznetHotspot&loc=' . $location . '&uip=' . $uip . '&client_mac=' . $client_mac . '&startUrl=' . $starturl . '&ssid=' . $ssid . '&rad=1&shaping=true';
    return redirect( $redirect );
  }

  public function testing( Request $request )
  {
    $agent = $this->userAgent($request->server('HTTP_USER_AGENT'));
    return $agent;
  }
}
