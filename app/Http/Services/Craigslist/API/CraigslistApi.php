<?php

namespace App\Http\Services\Craigslist\API;

use Log;
use GuzzleHttp\Client;

class CraigslistApi
{
    const ENDPOINT_PUBLIC = "/api/craigslist";

    public $ads_profile_id;

    public function __construct($ads_profile_id)
    {
        $this->ads_profile_id = $ads_profile_id;
    }

    public function create($record)
    {
        return $this->request("post", "/create", $record);
    }

    public function getPosts()
    {
        return $this->request("get", "/posts");
    }

    public function post($post_uuid)
    {
        return $this->request("post", "/post", ["post_id" => $post_uuid]);
    }

    //

    private function request($method, $url, $parameters = null)
    {
        try
        {
            ini_set('max_execution_time', 3000);
            $headers = [
                'Content-Type' => 'application/json',
            ];

            $data = [
                "ads_profile_id" => $this->ads_profile_id
            ];

            if($parameters) {
                $data = array_merge($data, $parameters);
            }

            $client = new Client();
            $response = $client->request($method, env("C_APP_API_URL").self::ENDPOINT_PUBLIC.$url,
                [
                    'headers' => $headers,
                    'query' => $data
                ]
            );

            $responseJSON = json_decode($response->getBody(), true);
            // Log::debug($responseJSON);
            return $responseJSON;
        }
        catch(\Exception $e){
            dd($e->getMessage());
            Log::debug($e->getMessage());
            return null;
        }
    }
}
