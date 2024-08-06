<?php

namespace App\Http\Services\Browser\API;

use Log;
use GuzzleHttp\Client;

class AdsPowerApi
{
    public function getGroups()
    {
        return $this->request("get", "/api/v1/group/list", [
            "page_size" => 2000 // max 2000
        ]);
    }

    public function getProfiles($page = 1)
    {
        return $this->request("get", "/api/v1/user/list", [
            "page" => $page,
            "page_size" => 100 // max 100
        ]);
    }

    private function request($method, $url, $parameters = null)
    {
        try
        {
            $headers = [
                'Content-Type' => 'application/json',
            ];

            $client = new Client();
            $response = $client->request($method, env('POWER_API_URL').$url,
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
