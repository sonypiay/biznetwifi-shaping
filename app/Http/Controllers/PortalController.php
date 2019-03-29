<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Database\AccountSubscriber;
use App\Database\ClientsUsage;
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
      $request->session()->put('ap', $ap);
      $request->session()->put('location_id', $location);
      $request->session()->put('client_mac', $client_mac);
      $request->session()->put('uip', $uip);
      $request->session()->put('starturl', $startUrl);
    }

    //$filter_location = explode('-', $location);
    //$merchant = $this->get_merchant( $filter_location[1] );

    return response()->view('portal.connect', [
      'mac' => $client_mac,
      'uip' => $uip,
      'ssid' => $ssid,
      'startUrl' => $startUrl,
      'loc' => [
        'origin' => $location,
        'merchant' => ''
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
	  $convert_location_id = hex2bin( $location );
      $request->session()->put('ap', $ap);
      $request->session()->put('location_id', $convert_location_id);
      $request->session()->put('client_mac', $client_mac);
      $request->session()->put('uip', $uip);
      $request->session()->put('starturl', $startUrl);
    }
    //$filter_location = explode('-', $convert_string);
    //$merchant = $this->get_merchant( $filter_location[1] );

    return response()->view('portal.connect', [
      'mac' => $client_mac,
      'uip' => $uip,
      'ssid' => $ssid,
      'startUrl' => $startUrl,
      'loc' => [
        'origin' => $location,
        'merchant' => ''
      ],
      'ap' => $ap,
      'shaping' => $shaping
    ])
    ->header('Content-Type', 'text/html; charset=utf8')
    ->header('Accepts', 'text/html; charset=utf8')
    ->header('Access-Control-Allow-Headers', 'GET');
  }

  public function afterlogin( Request $request, AccountSubscriber $subscriber, ClientsUsage $clientusage )
  {
    $connection_type = $request->session()->get('connect') == 'freehotspot' ? 'visitor' : 'subscriber';
    $client_mac = strtoupper( $request->session()->get('client_mac') );

    $clientIfExists = $clientusage->select(
      'client_mac',
      DB::raw('date_format(created_at, "%Y-%m-%d") as start_connected'),
      DB::raw('date_format(updated_at, "%Y-%m-%d") as last_connected')
    )
    ->where('client_mac', '=', $client_mac);
    if( $clientIfExists->count() != 0 )
    {
      $clients = $clientIfExists->first();
      if( $clients->last_connected == date('Y-m-d') )
      {
        $updated = $clientusage->where([
          ['client_mac', '=', $client_mac],
          [DB::raw('date_format(updated_at, "%Y-%m-%d")'), '=', date('Y-m-d')]
        ])->first();
        $updated->client_ip = $request->session()->get('uip');
        $updated->client_mac = $request->session()->get('client_mac');
        $updated->client_os = $this->getOsInfo( $request->server('HTTP_USER_AGENT') );
        $updated->location_id = $request->session()->get('location_id');
        $updated->connection_type = $connection_type;
        $updated->ap = $request->session()->get('ap');
        $updated->updated_at = date('Y-m-d H:i:s');
        $updated->save();
      }
      else
      {
        $clients = new $clientusage;
        $clients->client_ip = $request->session()->get('uip');
        $clients->client_mac = $request->session()->get('client_mac');
        $clients->client_os = $this->getOsInfo( $request->server('HTTP_USER_AGENT') );
        $clients->location_id = $request->session()->get('location_id');
        $clients->connection_type = $connection_type;
        $clients->ap = $request->session()->get('ap');
        $clients->save();
      }
    }
    else
    {
      $clients = new $clientusage;
      $clients->client_ip = $request->session()->get('uip');
      $clients->client_mac = $request->session()->get('client_mac');
      $clients->client_os = $this->getOsInfo( $request->server('HTTP_USER_AGENT') );
      $clients->location_id = $request->session()->get('location_id');
      $clients->connection_type = $connection_type;
      $clients->ap = $request->session()->get('ap');
      $clients->save();
    }

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
        $checkmacaddress = $subscriber->select('mac_address')->where([
          ['account_id', $username],
          ['mac_address', $mac]
        ]);
        $getlastmac = $checksubs->orderBy('login_date', 'asc')->first();

        if( $checksubs->count() == 0 )
        {
          $this->timeout_socket = 2;
          $radprimary = $this->check_connection('182.253.238.66', 3306);
          $radbackup = $this->check_connection('202.169.53.9', 3306);
          if( $radprimary['status'] == null )
          {
            $this->add_radcheck( '182.253.238.66:8080', $mac, $username );
            if( $checkmacaddress->count() == 0 )
            {
              $subscriber->account_id = $username;
              $subscriber->mac_address = $mac;
              $subscriber->login_date = date('Y-m-d H:i:s');
              $subscriber->device_agent = $this->userAgent( $agent );
              $subscriber->save();
            }
          }
          else
          {
            $this->add_radcheck( '202.169.53.9', $mac, $username );
            if( $checkmacaddress->count() == 0 )
            {
              $subscriber->account_id = $username;
              $subscriber->mac_address = $mac;
              $subscriber->login_date = date('Y-m-d H:i:s');
              $subscriber->device_agent = $this->userAgent( $agent );
              $subscriber->save();
            }
          }
        }
        else
        {
          if( $checksubs->count() > 0 AND $checksubs->count() <= 4 )
          {
            $this->timeout_socket = 2;
            $radprimary = $this->check_connection('182.253.238.66', 3306);
            $radbackup = $this->check_connection('202.169.53.9', 3306);
            if( $radprimary['status'] == null )
            {
              $this->add_radcheck( '182.253.238.66:8080', $mac, $username );
              $this->delete_radcheck( '182.253.238.66:8080', $getlastmac->mac_address );
              if( $checkmacaddress->count() == 0 )
              {
                $subscriber->account_id = $username;
                $subscriber->mac_address = $mac;
                $subscriber->login_date = date('Y-m-d H:i:s');
                $subscriber->device_agent = $this->userAgent( $agent );
                $subscriber->save();
              }
              $subscriber->where([
                ['username', '=', $username],
                ['mac_address', '=', $getlastmac->mac_address]
              ])->delete();
            }
            else
            {
              $this->add_radcheck( '202.169.53.9', $mac, $username );
              $this->delete_radcheck( '202.169.53.9', $getlastmac->mac_address );
              if( $checkmacaddress->count() == 0 )
              {
                $subscriber->account_id = $username;
                $subscriber->mac_address = $mac;
                $subscriber->login_date = date('Y-m-d H:i:s');
                $subscriber->device_agent = $this->userAgent( $agent );
                $subscriber->save();
              }
              $subscriber->where([
                ['username', '=', $username],
                ['mac_address', '=', $getlastmac->mac_address]
              ])->delete();
            }
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
    $redirect = 'http://biznethotspot.qeon.co.id?ap=' . $ap . '&src=BiznetHotspot&loc=' . $location . '&uip=' . $uip . '&client_mac=' . $client_mac . '&startUrl=' . $starturl . '&ssid=' . $ssid . '&rad=1';
    return redirect( $redirect );
  }

  public function testing( Request $request )
  {

  }
}
