<?php

namespace App\Http\Controllers\BiznetWifi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function index( Request $request )
  {
    if( ! $request->session()->has('session_locale') )
    {
      $locale = app()->getLocale();
      session()->put('session_locale', $locale);
    }

    $getlocale = session()->get('session_locale');
    app()->setLocale( $getlocale );

    dd( session()->all() );

    return response()->view('portal.homepage', [
      'request' => $request,
      'session' => $request->session()->all()
    ])
    ->header('Content-Type', 'text/html, charset=utf8')
    ->header('Accepts', 'text/html, charset=utf8');
  }

  public function homepage_customer( Request $request )
  {
    if( ! $request->session()->has('session_locale') )
    {
      $locale = app()->getLocale();
      session()->put('session_locale', $locale);
    }

    $getlocale = session()->get('session_locale');
    app()->setLocale( $getlocale );

    if( $request->session()->get('biznetwifi_login') )
    {
      return response()->view('portal.customers.homepage', [
        'request' => $request,
        'session' => $request->session()->all()
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
