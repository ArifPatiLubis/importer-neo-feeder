<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class NeoFeeder {
    private $urlFeeder;
    private $username;
    private $password;
    private $act;

    function __construct($act)
    {
        ini_set('max_execution_time', 1200);

        $this->act = $act;
    }

    private function getToken()
    {
        $response = Http::post('', [
            'act' => 'GetToken',
            'username' => '',
            'password' => ''
        ]);
        
        return $response->json();
    }

    public function getData()
    {
        $getToken = $this->getToken();

        if($getToken['error_code'] == 0) {
            $token = $getToken['data']['token'];
            $this->act['token'] = $token;

            $response = Http::post('', $this->act);
            $jsonDecode = json_decode($response, true);
            return $jsonDecode;
        } else {
            return $getToken;
        }
    }
}
