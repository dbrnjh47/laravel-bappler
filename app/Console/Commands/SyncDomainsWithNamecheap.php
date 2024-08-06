<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Models\NamecheapAccount;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Namecheap;

class SyncDomainsWithNamecheap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-domains-with-namecheap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serverIp = gethostbyname(gethostname());

        $namecheapAccounts = NamecheapAccount::all();

        foreach ($namecheapAccounts as $namecheapAccount) {
            $ncDomains = new  Namecheap\Domain\Domains($namecheapAccount->username, $namecheapAccount->apikey, $namecheapAccount->username, $serverIp, 'array');

            $page = 1;
            while(true) {
                $domainList = $ncDomains->getList(null, null, $page, null, null);
                if (empty($domainList) ||
                        !is_array($domainList) || !array_key_exists('ApiResponse', $domainList) ||
                        !is_array($domainList['ApiResponse']) || !array_key_exists('CommandResponse', $domainList['ApiResponse']) ||
                        !is_array($domainList['ApiResponse']['CommandResponse']) || !array_key_exists('DomainGetListResult', $domainList['ApiResponse']['CommandResponse']) ||
                        !is_array($domainList['ApiResponse']['CommandResponse']['DomainGetListResult']) || !array_key_exists('Domain', $domainList['ApiResponse']['CommandResponse']['DomainGetListResult']) ||
                        empty($domainList['ApiResponse']['CommandResponse']['DomainGetListResult']['Domain'])
                    )
                    break;
                $page++;

                foreach ($domainList['ApiResponse']['CommandResponse']['DomainGetListResult']['Domain'] as $d) {

                    /*  $d like this
                     *  array:11 [
                          "_ID" => "67440837"
                          "_Name" => "appliancecareoftampabay.com"
                          "_User" => "rinat10101"
                          "_Created" => "05/02/2023"
                          "_Expires" => "05/02/2024"
                          "_IsExpired" => "false"
                          "_IsLocked" => "false"
                          "_AutoRenew" => "false"
                          "_WhoisGuard" => "ENABLED"
                          "_IsPremium" => "false"
                          "_IsOurDNS" => "true"
                        ]
                     */

                    $domain = Domain::where('namecheap_account', $namecheapAccount->username)->where('namecheap_domain_name', $d['_Name'])->first();

                    if ($domain) {
                        // Update last checked field
                        $domain->namecheap_created = Carbon::createFromFormat('m/d/Y', $d['_Created']);
                        $domain->namecheap_expires = Carbon::createFromFormat('m/d/Y', $d['_Expires']);
                        $domain->namecheap_is_expired = filter_var($d['_IsExpired'], FILTER_VALIDATE_BOOLEAN);
                        $domain->namecheap_is_locked = filter_var($d['_IsLocked'], FILTER_VALIDATE_BOOLEAN);
                        $domain->namecheap_is_autorenew = filter_var($d['_AutoRenew'], FILTER_VALIDATE_BOOLEAN);
                        $domain->save();
                        $this->info("Domain {$d['_Name']} already exists in DB. Updated.");
                    } else {
                        // Create a new domain record
                        Domain::create([
                            'namecheap_account' => $namecheapAccount->username,
                            'namecheap_domain_id' => $d['_ID'],
                            'namecheap_domain_name' => $d['_Name'],
                            'namecheap_created' => Carbon::createFromFormat('m/d/Y', $d['_Created']),
                            'namecheap_expires' => Carbon::createFromFormat('m/d/Y', $d['_Expires']),
                            'namecheap_is_expired' => filter_var($d['_IsExpired'], FILTER_VALIDATE_BOOLEAN),
                            'namecheap_is_locked' => filter_var($d['_IsLocked'], FILTER_VALIDATE_BOOLEAN),
                            'namecheap_is_autorenew' => filter_var($d['_AutoRenew'], FILTER_VALIDATE_BOOLEAN)
                        ]);
                        $this->info("Domain {$d['_Name']} created.");
                    }
                }
            }

        }
    }
}
