<?php

namespace App;

trait LdapConnection {

  var $hostname = 'ldap.biznetnetworks.com';
  var $port = 389;
  var $domain = "biznetnetworks.com";
  var $ldap_username;
  var $ldap_password;

  private function get_ldap_user()
  {
    return $this->ldap_username . '@' . $this->domain;
  }

  public function auth_ldap()
  {
    $res = [];
    $connect = @ldap_connect( $this->hostname, $this->port );

    if( ! $connect )
    {
      $res = [
        'status' => 500,
        'statusText' => 'Error LDAP Connection',
        'response' => false
      ];
    }
    else
    {
      @ldap_set_option( $connect, LDAP_OPT_PROTOCOL_VERSION, 3 );
      @ldap_set_option( $connect, LDAP_OPT_REFERRALS, 0 );
      $binding = @ldap_bind( $connect, $this->get_ldap_user(), $this->ldap_password );
      if( ! $binding )
      {
        $res = [
          'status' => 401,
          'statusText' => 'Username / Password yang anda masukkan salah.',
          'response' => false
        ];
      }
      else
      {
        $basedn = "DC=biznetnetworks, DC=com";
        $search_filter = "samaccountname=" . $this->ldap_username;
        $filter_array = ['displayname','samaccountname'];
        $find = @ldap_search( $connect, $basedn, $search_filter, $filter_array );
        if( ! $find )
        {
          $res = [
            'status' => 500,
            'statusText' => 'An error has occured',
            'response' => false
          ];
        }
        else
        {
          $entries = @ldap_get_entries( $connect, $find );
          $res = [
            'status' => 401,
            'statusText' => 'Username / Password yang anda masukkan salah.',
            'response' => ''
          ];

          unset( $entries['count'] );
          foreach( $entries as $key => $val )
          {
            if( isset( $val['samaccountname'][0] ) )
            {
              if( $val['samaccountname'][0] == $this->ldap_username )
              {
    						$res = [
                  'status' => 200,
                  'statusText' => 'ok',
    							'response' => [
                    'samaccountname' => $val['samaccountname'][0],
      							'displayname' => $val['displayname'][0]
                  ]
    						];
    					}
    				}
          }
        }
      }
    }

    return $res;
  }
}
