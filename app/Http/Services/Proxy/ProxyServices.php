<?php

namespace App\Http\Services\Proxy;

use App\Models\Proxy;
use App\Models\ProxyConnection;
use App\Http\Services\Proxy\API\ProxyCheapApi;
use App\Http\Services\Proxy\ProxyProviderServices;
use Carbon\Carbon;

class ProxyServices
{
    public function count()
    {
        return Proxy::count();
    }

    public function updateAll()
    {
        $providers = (new ProxyProviderServices)->get();

        foreach ($providers as $provider) {
            $this->update($provider);
        }

        return;
    }

    public function update($provider, $is_update_proxy = 1)
    {
        $this->updateBalance($provider);

        if ($is_update_proxy) {
            switch ($provider->name) {
                case 'proxy_cheap':
                    $proxies = (new ProxyCheapApi($provider->api_key, $provider->secret_key))->getProxies();

                    if ($proxies) {
                        $proxies = $proxies["proxies"];
                        foreach ($proxies as $proxy) {
                            $proxyModal = $this->updatedOrCreateProxy(
                                [
                                    'uuid' => $proxy['id'],
                                    'proxy_provider_id' => $provider->id
                                ],
                                [
                                    'status' => ($proxy["status"] === "ACTIVE" ? 1 : 0),
                                    'network_type' => $proxy["networkType"],

                                    'username' => $proxy["authentication"]["username"],
                                    'password' => $proxy["authentication"]["password"],

                                    'proxy_type' => $proxy["proxyType"],

                                    'expires_at' => Carbon::parse($proxy["expiresAt"]),
                                    'provider_created_at' => Carbon::parse($proxy["createdAt"]),
                                ]
                            );

                            $this->updatedOrCreateProxyConnection(
                                [
                                    'proxy_id' => $proxyModal->id,
                                ],
                                [
                                    'public_ip' => $proxy["connection"]["publicIp"],
                                    'connect_ip' => $proxy["connection"]["connectIp"],
                                    'ip_version' => $proxy["connection"]["ipVersion"],
                                    'http_port' => $proxy["connection"]["httpPort"],
                                    'https_port' => $proxy["connection"]["httpsPort"],
                                    'socks_5_port' => $proxy["connection"]["socks5Port"],
                                ]
                            );
                        }
                    }

                    break;
            }
        }
    }

    public function updatedOrCreateProxy($where_data, $data)
    {
        return Proxy::updateOrCreate(
            $where_data,
            $data
        );
    }

    public function updateBalance($provider)
    {
        switch ($provider->name) {
            case 'proxy_cheap':
                $balance = (new ProxyCheapApi($provider->api_key, $provider->secret_key))->getBalance();
                $provider->balance = (isset($balance["balance"]) ? $balance["balance"] : 0);

                break;
        }
        $provider->save();
        return;
    }

    public function updatedOrCreateProxyConnection($where_data, $data)
    {
        return ProxyConnection::updateOrCreate(
            $where_data,
            $data
        );
    }

    public function firstByIP($ip)
    {
        return Proxy::whereHas('connection', function ($q) use ($ip) {
            $q->where('public_ip', $ip)->orWhere('connect_ip', $ip);
        })->first();
    }
}
