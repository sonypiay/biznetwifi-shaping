<?php

namespace App;

trait RadiusAPI {
  var $timeout_socket = 3;
  var $attribute = 'Cleartext-Password';
  var $op = ':=';
  public function check_connection( $ip, $port )
  {
    $socket = @fsockopen( $ip, $port, $errno, $errstr, $this->timeout_socket );
    if( $socket )
    {
      $res = [
        'status' => null,
        'statusText' => $errstr
      ];
    }
    else
    {
      $res = [
        'status' => $errno,
        'statusText' => $errstr
      ];
    }
    return $res;
  }

  public function add_radcheck( $ip, $mac, $displayname )
  {
    $value = [
      'username' => $mac,
      'password' => 'biznet99',
      'attribute' => $this->attribute,
      'op' => $this->op,
      'displayname' => $displayname
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL => 'http://' .  $ip . '/api/raduser/adduser',
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accepts: application/json'
      ]
    ]);

    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $value ));

    $res = curl_exec( $ch );
    curl_close( $ch );

    return $res;
  }

  public function delete_radcheck( $ip, $username )
  {
    $value = ['username' => $username];

    $ch = curl_init();
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL => 'http://' .  $ip . '/api/raduser/delete/' . $username,
      CURLOPT_CUSTOMREQUEST => "DELETE",
      CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accepts: application/json'
      ]
    ]);

    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

    $res = curl_exec( $ch );
    curl_close( $ch );

    return $res;
  }

  public function bandwidthClientUsage( $ip, $mac, $request )
  {
    $ch = curl_init();
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL => 'http://' .  $ip . '/api/bandwidth/usage/' . $mac . '?filterdate=' . $request->filterdate . '&rows=' . $request->selectedrows,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accepts: application/json'
      ]
    ]);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

    $res = curl_exec( $ch );
    curl_close( $ch );

    return json_decode( $res, true );
  }

  public function summaryBandwidthUsage( $ip, $request )
  {
    $ch = curl_init();
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL => 'http://' .  $ip . '/api/bandwidth/total_usage?filterdate=' . $request->filterdate . '&startDate=' . $request->startDate . '&endDate=' . $request->endDate,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accepts: application/json'
      ]
    ]);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

    $res = curl_exec( $ch );
    curl_close( $ch );

    return json_decode( $res, true );
  }
}
