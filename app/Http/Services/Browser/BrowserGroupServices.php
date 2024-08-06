<?php

namespace App\Http\Services\Browser;

use App\Http\Services\Browser\API\AdsPowerApi;
use App\Models\BrowserGroup;

class BrowserGroupServices
{
    public function update()
    {
        $groups = (new AdsPowerApi)->getGroups();

        foreach($groups["data"]["list"] as $group)
        {
            $this->updateOrCreate($group);
        }

        return;
    }

    public function firstByUUID($uuid)
    {
        $group = BrowserGroup::where("uuid", $uuid)->first();
        if($group){return $group;}
        sleep(1);

        return $this->getGroup($uuid);
    }

    public function getGroup($uuid)
    {
        $groups = (new AdsPowerApi)->getGroups();
        $group = null;
        foreach($groups["data"]["list"] as $g)
        {
            if($g["group_id"] == $uuid){
                $group = $g;
            }
        }
        if(!$group){throw new \Exception("group not found {$uuid}");}

        return $this->updateOrCreate($group);
    }

    public function updateOrCreate($group)
    {
        return BrowserGroup::updateOrCreate(
            [
                'uuid' => $group["group_id"],
            ],
            [
                'name' => $group["group_name"],
                'remark' => ($group["remark"] ? $group["remark"] : null),
            ]
        );
    }
}
