<?php

namespace App\Http\Controllers\RuckusApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Session;

class ApiController extends Controller
{
    private $client;
    private $headers;
    private $token;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function run()
    {

    }

    public function setApiSession($session) {
        Session::put('session_token', $session);
    }

    public function getApiSession() {
        if(! Session::has('session_token')) {
            return false;
        }

        return Session::get('session_token');
    }

    public function logon(Request $request)
    {
        $url = env('RUCKUS_API_URL') .'/session';
        $response = $this->client->post($url, [
            'headers' => ['Content-Type' => 'application/json;charset=UTF-8'],
            'json' => array(
                'username' => $request->username,
                'password' => $request->password
            )
        ]);

        if($response->getStatusCode() == 200 && ! empty($response->getBody())) {
            $cookie = $response->getHeader('Set-Cookie')[0];
            $el = explode(';', $cookie);
            $this->token = $el[0];
            $this->setApiSession($this->token);
        }

        return json_encode([
          'success' => true,
          'data' => $this->getApiSession(),
          'message' => 'Logged on successfully.'
        ]);
    }

    public function logoff(Request $request)
    {
        $url = env('RUCKUS_API_URL') .'/session';
        $response = $this->client->delete($url);

        $this->token = "";
        Session::flush();

        return json_encode([
          'success' => true,
          'data' => '',
          'message' => 'Logged off successfully.'
        ]);
    }

    public function accessPoints(Request $request)
    {
        $url = env('RUCKUS_API_URL') .'/aps';
        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Cookie' => $this->getApiSession()
        ];

        if($request->isMethod('get'))
        {
            $options = [
                'headers' => $headers
            ];
        }
        else if($request->isMethod('post'))
        {
            $options = [
                'headers' => $headers,
                'query' => [
                    'zoneId' => $request->zoneId
                ]
            ];
        }

        try {
          $response = $this->client->get($url, $options);
        } catch(GuzzleException $e) {
          return json_encode([
            'success' => false,
            'data' => '',
            'message' => '401 Unauthorized'
          ]);
        }

        return $response->getBody();
    }
}
