<?php

namespace App;

trait CustomFunction {

  public function  userAgent( $agent )
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

  private function api_merchant()
  {
    $api = 'http://api-legacy.biznetnetworks.com/pages/default.asp?menu=wifi&submenu1=wifilocation';
    $ch = @curl_init();
    @curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL => $api
    ]);
    $res = @curl_exec( $ch );
    @curl_close();

    return $res;
  }

  private function filter_merchant()
  {
    return $this->api_merchant();
  }

  public function get_merchant( $id )
  {
    $api = $this->filter_merchant();
    if( $api === '' || empty( $api ) || $api === null )
    {
      $res = [
        'status' => 500,
        'statusText' => 'Something when wrong'
      ];
    }
    else
    {
      $convert_encode = mb_convert_encoding( $api, 'utf-8', 'utf-8' );
      $data_merchant = json_decode( $convert_encode, true );
      $getcolumn_merchant = array_column( $data_merchant, 'merchant_id' );
      $finddata = array_search( $id, $getcolumn_merchant );
      if( isset( $data_merchant[$finddata] ) )
      {
        $res = [
          'data' => $data_merchant[$finddata]
        ];
      }
      else
      {
        $res = [
          'status' => 200,
          'statusText' => 'Something when wrong'
        ];
      }
    }
    return $res;
  }

  public function getOsInfo()
  {
  	$os = array(
  		'Windows' => 'Windows',
  		'Android' => 'Android',
  		'Linux' => 'Linux',
  		'Mac OS' => '(Mac_PowerPC)|(Macintosh)',
  		'iOS' => '(iPhone)|(iPad)|(iPod)'
  	);

  	foreach( $os as $os_info => $pattern )
  	{
  		$match = preg_match("/" . $pattern. "/i", $_SERVER['HTTP_USER_AGENT']);
  		if( $match )
  			return $os_info;
  	}
  	return 'Other';
  }

  public function getBrowserInfo()
  {
  	$os = array(
  		'Firefox' => 'Firefox',
  		'Chrome' => 'Chrome',
  		'Opera' => 'Opera',
  		'Internet Explorer' => 'Internet Explorer',
  		'Edge' => 'Edge',
  		'Safari' => 'Safari'
  	);

  	foreach( $os as $os_info => $pattern )
  	{
  		$match = preg_match("/" . $pattern. "/i", $_SERVER['HTTP_USER_AGENT']);
  		if( $match )
  			return $os_info;
  	}
  	return 'Other';
  }
}
