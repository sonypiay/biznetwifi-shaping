<?php

namespace App;

use Illuminate\Http\Request;

trait SterliteAPI
{
  private function encryptPassword( $data, $key = null )
  {
    if( $key == '' || empty( $key ) ) $key = 'EL12ec@REteLe(0M';
  	if(16 !== strlen($key)) $key = hash('MD5', $key, true);

  	$padding = 16 - (strlen($data) % 16);
  	$data .= str_repeat(chr($padding), $padding);
  	return base64_encode(@mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16)));
  }

  private function sterlite_auth( $username, $password )
  {
    $request = new Request;
    $value = [
  		"externalIP" => $request->server('REMOTE_ADDR'),
  		"sourceName" => "Rest",
  		"externalRefId" => "Extt2",
  		"userName" => $username,
  		"password" => $this->encryptPassword( $password )
  	];

    $ch = @curl_init();
    @curl_setopt_array($ch, [
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_URL => 'http://rest.biznetnetworks.com/islrest/rest/CustomerOperationRestService/authenticateUser',
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_HTTPHEADER => [
        'Authorization: Basic YWRtaW46YWRtaW4=',
        'Content-Type: application/json'
      ]
	  ]);

    @curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    @curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    @curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $value ));
    $res = @curl_exec( $ch ); @curl_close( $ch );

    return json_decode( $res, true );
  }

  private function sterliteGetCustomerData( $accountNumber )
  {
    $ch = @curl_init();
    @curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL => 'http://rest.biznetnetworks.com/islrest/rest/CustomerGeneralOPerationRestService/getCustomerHrchyDetails',
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => [
        'Authorization: Basic YWRtaW46YWRtaW4=',
        'Content-Type: application/json'
      ]
    ]);

    @curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    @curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    @curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( ['accountNumber' => $accountNumber ] ));
    $res = @curl_exec( $ch ); @curl_close( $ch );

    return json_decode( $res, true );
  }
}
