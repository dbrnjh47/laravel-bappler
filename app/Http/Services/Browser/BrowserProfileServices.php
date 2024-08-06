<?php

namespace App\Http\Services\Browser;

use App\Http\Services\Browser\API\AdsPowerApi;
use App\Http\Services\Proxy\ProxyServices;
use App\Models\BrowserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BrowserProfileServices
{
    public function getByUUID($ads_profile_id)
    {
        return BrowserProfile::where("uuid", $ads_profile_id)->firstOrFail();
    }

    public function update()
    {
        $page = 1;

        while (true) {
            $profiles = (new AdsPowerApi)->getProfiles($page);

            if(!sizeof($profiles["data"]["list"])){break;}

            foreach ($profiles["data"]["list"] as $key => $profil) {
                $browser_group = ($profil["group_id"] ? (new BrowserGroupServices)->firstByUUID($profil["group_id"]) : null);
                $proxy = (new ProxyServices)->firstByIP($profil["ip"]);

                BrowserProfile::updateOrCreate(
                    [
                        'uuid' => $profil["user_id"],
                    ],
                    [
                        'name' => $profil["name"],
                        'user_name' => ($profil["username"] ? $profil["username"] : null),
                        'domain_name' => ($profil["domain_name"] ? $profil["domain_name"] : null),
                        'serial_number' => $profil["serial_number"],

                        'browser_group_id' => ($browser_group ? $browser_group->id : null),
                        'proxy_id' => ($proxy ? $proxy->id : null),

                        'profil_created_at' => Carbon::createFromTimestamp($profil["created_time"]),
                        'last_open_at' => ($profil["last_open_time"] ? Carbon::createFromTimestamp($profil["last_open_time"]) : null),
                    ]
                );
            }

            break;
        }

        return;
    }
}
