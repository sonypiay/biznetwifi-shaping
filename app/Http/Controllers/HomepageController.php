<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomepageController extends Controller
{
  public function homepage( Request $request )
  {
    if( ! $request->session()->has('session_locale') )
    {
      $locale = app()->getLocale();
      session()->put('session_locale', $locale);
    }

    $getlocale = session()->get('session_locale');
    app()->setLocale( $getlocale );

    return response()->view('portal.homepage', [
      'request' => $request,
      'locale' => $getlocale
    ]);
  }

  public function change_locale( Request $request, $lang )
  {
    session()->put('session_locale', $lang);
    $res = [
      'status' => 200,
      'statusText' => 'success',
      'lang' => $lang
    ];
    return response()->json( $res, $res['status'] );
  }
}
