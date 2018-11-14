<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomepageController extends Controller
{
  public function connect( Request $request )
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

    return response()->view('portal.connect', [
      'mac' => $client_mac,
      'uip' => $uip,
      'ssid' => $ssid,
      'startUrl' => $startUrl,
      'loc' => $location,
      'ap' => $ap
    ]);
  }
}
