<?php

namespace App\Http\Controllers\BiznetWifi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function index( Request $request )
  {
    return response()->view('portal.homepage', [
      'request' => $request
    ])
    ->header('Content-Type', 'text/html, charset=utf8')
    ->header('Accepts', 'text/html, charset=utf8');
  }

  public function homepage_customer( Request $request )
  {
    if( Cookie::get('hasLoginBiznetWifi') )
    {
      return response()->view('portal.customers.homepage', [
        'request' => $request,
        'getCookie' => $request->cookie()
      ])
      ->header('Content-Type', 'text/html, charset=utf8')
      ->header('Accepts', 'text/html, charset=utf8');
    }
    else
    {
      return redirect()->route('pagelogin_biznetwifi');
    }
  }
}
