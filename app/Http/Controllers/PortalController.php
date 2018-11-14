<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Database\AccountSubscriber;
use App\RadiusAPI;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class PortalController extends Controller
{
  use RadiusAPI;

  public function connectmikrotik( Request $request )
  {
    $ap = $request->ap;
    $client_mac = $request->client_mac;
    $uip = $request->uip;
    $ssid = $request->ssid;
    $startUrl = $request->starturl;
    $location = $request->loc;

    if( $ap == 'mkt' )
    {
      $startUrl = 'biznethotspot.qeon.co.id';
    }

    if( isset( $client_mac ) AND ! empty( $client_mac ) )
    {
      $request->session()->put('client_mac', $client_mac);
      $request->session()->put('uip', $uip);
      $request->session()->put('starturl', $startUrl);
    }

    return response()->view('portal.connect', [
      'mac' => $client_mac,
      'uip' => $uip,
      'ssid' => $ssid,
      'startUrl' => $startUrl,
      'loc' => $location,
      'ap' => $ap
    ])
    ->header('Content-Type', 'text/html; charset=utf8')
    ->header('Accepts', 'text/html; charset=utf8')
    ->header('Access-Control-Allow-Headers', 'POST');
  }

  public function connectruckus( Request $request ) {
    $ap = $request->ap;
    $client_mac = $request->client_mac;
    $uip = $request->uip;
    $ssid = $request->ssid;
    $startUrl = $request->StartURL;
    $location = $request->loc;

    if( $ap == 'mkt' )
    {
      $startUrl = 'biznethotspot.qeon.co.id';
    }

    if( isset( $client_mac ) AND ! empty( $client_mac ) )
    {
      $request->session()->put('client_mac', $client_mac);
      $request->session()->put('uip', $uip);
      $request->session()->put('starturl', $startUrl);
    }
    return response()->view('portal.connect', [
      'mac' => $client_mac,
      'uip' => $uip,
      'ssid' => $ssid,
      'startUrl' => $startUrl,
      'loc' => $location,
      'ap' => $ap
    ])
    ->header('Content-Type', 'text/html; charset=utf8')
    ->header('Accepts', 'text/html; charset=utf8')
    ->header('Access-Control-Allow-Headers', 'GET');
  }

  public function afterlogin( Request $request, AccountSubscriber $subscriber )
  {
    if( $request->cookie('connect') == 'freehotspot' )
    {
      Cookie::queue( Cookie::forget('connect') );
	  $fullUrl = $request->fullUrl();
	  $fullUrlParts = parse_url($fullUrl);
	  $redirectUrl = 'http://qabiznethotspot.qeon.co.id/a' . (isset($fullUrlParts['query']) ? ('?' . $fullUrlParts['query']) : '');
	  return redirect($redirectUrl);
    }
    else if( $request->cookie('connect') == 'biznetwifi' )
    {
      if( $request->session()->has('client_mac') AND $request->session()->has('uip') )
      {
        $mac = $request->session()->get('client_mac');
        $username = $request->cookie('username');
        $displayname = $request->cookie('displayname');
        $agent = $request->cookie('agent');

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
            // curl radius
            $this->timeout_socket = 2;
            $radbackup = $this->check_connection('182.253.238.66', 3306);
            if( $radbackup['status'] == null )
            {
              $this->add_radcheck( '182.253.238.66:8080', $mac, $username );
              $this->delete_radcheck( '182.253.238.66:8080', $getuser->mac_address );
            }

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
            $radbackup = $this->check_connection('182.253.238.66', 3306);
            if( $radbackup['status'] == null )
            {
              $this->add_radcheck( '182.253.238.66:8080', $mac, $username );
            }

            $subscriber->account_id = $username;
            $subscriber->mac_address = $mac;
            $subscriber->login_date = date('Y-m-d H:i:s');
            $subscriber->device_agent = $this->userAgent( $agent );
            $subscriber->save();
          }
        }
        Cookie::queue( Cookie::forget('connect') );
        return redirect()->route('hmpgcustomer');
      }
      else
      {
        if( Cookie::get('connect') )
        {
          if( Cookie::get('connect') == 'freehotspot' )
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
    Cookie::queue( Cookie::make('connect', 'freehotspot', time() + 36000) );
    $ap = $request->ap;
    $client_mac = $request->client_mac;
    $uip = $request->uip;
    $ssid = $request->ssid;
    $starturl = 'http://qabiznethotspot.qeon.co.id';
    $location = $request->loc;
    $redirect = 'http://qabiznethotspot.qeon.co.id?ap=' . $ap . '&src=BiznetHotspot&loc=' . $location . '&uip=' . $uip . '&client_mac=' . $client_mac . '&startUrl=' . $starturl . '&ssid=' . $ssid . '&rad=1';
    return redirect( $redirect );
  }

  public function testradius( Request $request )
  {
    return $this->userAgent( $request->server('HTTP_USER_AGENT') );
  }

  private function userAgent( $agent )
  {
    $iPod = strpos( $agent, "iPod" );
  	$iPhone = strpos( $agent, "iPhone" );
  	$iPad = strpos( $agent, "iPad" );
  	$android = strpos( $agent, "Android" );
  	$smartTV = strpos( $agent, "TV" );
  	if( $iPad || $iPhone || $iPod )
  	{
  		return 'iOS';
  	}
  	else if( $android )
  	{
  		return 'ANDROID';
  	}
  	else if( $smartTV )
  	{
  		return 'SMART TV';
  	}
  	else
  	{
  		return 'PC/LAPTOP';
  	}
  }
}
