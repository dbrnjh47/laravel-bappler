<?php

namespace App\Http\Services\Proxy\API;

use Log;
use GuzzleHttp\Client;

class ProxyCheapApi
{
    const ENDPOINT_PUBLIC = "https://api.proxy-cheap.com";

    public $api_key, $secret_key;

    public function __construct($api_key, $secret_key)
    {
        $this->api_key = $api_key;
        $this->secret_key = $secret_key;
    }

    public function getBalance()
    {
        return $this->request("get", "/account/balance");
    }

    public function getProxies()
    {
        return $this->request("get", "/proxies");
    }

    private function request($method, $url, $parameters = null)
    {
        try
        {
            $headers = [
                'Content-Type' => 'application/json',
                'X-Api-Key' => $this->api_key,
                'X-Api-Secret' => $this->secret_key,
            ];

            $client = new Client();
            $response = $client->request($method, self::ENDPOINT_PUBLIC.$url,
                ($method == "get" ?
                    [
                        'headers' => $headers,
                        'query' => $parameters
                    ] :
                    [
                        'headers' => $headers,
                        'body' => json_encode($parameters)
                    ]
                )
            );

            $responseJSON = json_decode($response->getBody(), true);
            // Log::debug($responseJSON);
            return $responseJSON;
        }
        catch(\Exception $e){
            Log::debug($e->getMessage());
            return null;
        }
    }
}
