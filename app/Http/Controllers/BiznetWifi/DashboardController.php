<?php

namespace App\Http\Controllers\BiznetWifi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function homepage_myaccount( Request $request )
  {
    if( ! $request->session()->has('session_locale') )
    {
      $locale = app()->getLocale();
      session()->put('session_locale', $locale);
    }

    $getlocale = session()->get('session_locale');
    app()->setLocale( $getlocale );

    if( $request->session()->get('login_type') == 'member' )
    {
      $blade = 'portal.members.homepage';
      $route = 'pagelogin_member';
    }
    else
    {
      $blade = 'portal.customers.homepage';
      $route = 'pagelogin_customer';
    }

    if( $request->session()->get('biznetwifi_login') )
    {
      return response()->view($blade, [
        'request' => $request,
        'session' => $request->session()->all()
      ])
      ->header('Content-Type', 'text/html, charset=utf8')
      ->header('Accepts', 'text/html, charset=utf8');
    }
    else
    {
      return redirect()->route($route);
    }
  }
}
