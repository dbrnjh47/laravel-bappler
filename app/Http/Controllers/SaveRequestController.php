<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;

class SaveRequestController extends Controller
{
    public function storeRequestData(Request $request)
    {
        $serverName = $request->input('server_name');
        $domain = Domain::where('namecheap_domain_name', $serverName)->first();

        if (!$domain)
            return response()->json(['message' => 'Data not saved'], 200);

        // Получаем IP-адрес и UTM-метки из входящего запроса
        $httpUserAgent = $request->input('user_agent','');
        $httpUserLanguage = $request->input('user_language', '');
        $ipAddress = $request->input('ip_address');
        $utmSource = $request->input('utm_source');
        $utmMedium = $request->input('utm_medium');
        $utmCampaign = $request->input('utm_campaign');
        $utmTerm = $request->input('utm_term');
        $utmContent = $request->input('utm_content');

        // Создаем новую запись в базе данных с полученными данными
        $request = new \App\Models\Request();
        $request->domain_id = $domain->id;
        $request->ip_address = $ipAddress;
        $request->http_user_agent = is_null($httpUserAgent) ? '' : $httpUserAgent;
        $request->http_user_language = is_null($httpUserLanguage) ? '' : $httpUserLanguage;
        $request->UTM = [
            'utm_source' => $utmSource,
            'utm_medium' => $utmMedium,
            'utm_campaign' => $utmCampaign,
            'utm_term' => $utmTerm,
            'utm_content' => $utmContent,
        ];
        $request->save();

        return response()->json(['message' => 'Data saved'], 200);
    }
}
