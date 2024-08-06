<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Models\Request;
use Illuminate\Console\Command;

class GetInfoFromIpQualityScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-info-from-ip-quality-score';

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
        $api_key = env('IPQUALITYSCORE_API_KEY', '');

        if (empty($api_key))
        {
            $this->error('Api key empty');
        }

        //Получим первые 10 записей, у которых не заполнены данные с ipqualityscore
        //Дополнительно ограничим запрос Fraud Score только по домену proappliancerepair.com
        $proappliance_domain = Domain::where('namecheap_domain_name', 'proappliancerepair.com')->first();

        $requests = Request::where('domain_id', $proappliance_domain->id)->where('is_fill_ipqualityscore', 0)->orderByDesc('created_at')->limit(10)->get();
        if ($requests->isNotEmpty()) {
            foreach ($requests as $request) {
                // Вывод найденной записи для демонстрации
                $this->info('ID: ' . $request->id);
                //$this->info('is_fill_ipqualityscore: ' . $request->is_fill_ipqualityscore);




                // Set the strictness for this query. (0 (least strict) - 3 (most strict))
                $strictness = 1;
                // You may want to allow public access points like coffee shops, schools, corporations, etc...
                $allow_public_access_points = 'true';
                // Reduce scoring penalties for mixed quality IP addresses shared by good and bad users.
                $lighter_penalties = 'false';

                // Create parameters array.
                $parameters = array(
                    'user_agent' => $request->http_user_agent,
                    'user_language' => $request->http_user_language,
                    'strictness' => $strictness,
                    'allow_public_access_points' => $allow_public_access_points,
                    'lighter_penalties' => $lighter_penalties
                );

                // Format Parameters
                $formatted_parameters = http_build_query($parameters);

                // Create API URL
                $url = sprintf(
                    'https://www.ipqualityscore.com/api/json/ip/%s/%s?%s',
                    $api_key,
                    $request->ip_address,
                    $formatted_parameters
                );

                // Fetch The Result
                $timeout = 5;

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

                $json = curl_exec($curl);
                curl_close($curl);

                // Decode the result into an array.
                $result = json_decode($json, true);

                if (isset($result['success']) && $result['success'] === true) {
                    $this->info('Record:');
                    $this->info('Fraud Score: ' . $request['fraud_score']);

                    $request->country = array_key_exists('country_code', $result) ? $result['country_code'] : '';
                    $request->region = array_key_exists('region', $result) ? $result['region'] : '';
                    $request->city = array_key_exists('city', $result) ? $result['city'] : '';
                    $request->hostname = array_key_exists('host', $result) ? $result['host'] : '';
                    $request->ISP = array_key_exists('ISP', $result) ? $result['ISP'] : '';
                    $request->ASN = array_key_exists('ASN', $result) ? $result['ASN'] : '';
                    $request->organization = array_key_exists('organization', $result) ? $result['organization'] : '';
                    $request->timezone = array_key_exists('timezone', $result) ? $result['timezone'] : '';
                    $request->latitude = array_key_exists('latitude', $result) ? $result['latitude'] : 0;
                    $request->longitude = array_key_exists('longitude', $result) ? $result['longitude'] : 0;
                    $request->fraud_score = array_key_exists('fraud_score', $result) ? $result['fraud_score'] : 0;
                    $request->is_crawler = array_key_exists('is_crawler', $result) ? $result['is_crawler'] : false;
                    $request->is_proxy = array_key_exists('proxy', $result) ? $result['proxy'] : false;
                    $request->is_vpn = array_key_exists('vpn', $result) ? $result['vpn'] : false;
                    $request->is_tor = array_key_exists('tor', $result) ? $result['tor'] : false;
                    $request->is_fill_ipqualityscore = true;
                    $request->save();

                    /* API Response:
                     * Array
                        (
                            [success] => 1
                            [message] => Success
                            [fraud_score] => 0
                            [country_code] => US
                            [region] => Texas
                            [city] => Houston
                            [ISP] => Comcast Cable
                            [ASN] => 7922
                            [operating_system] => iOS 17.2
                            [browser] => Mobile Safari 17.2
                            [organization] => Comcast Cable
                            [is_crawler] =>
                            [timezone] => America/Chicago
                            [mobile] => 1
                            [host] => c-73-76-209-110.hsd1.tx.comcast.net
                            [proxy] =>
                            [vpn] =>
                            [tor] =>
                            [active_vpn] =>
                            [active_tor] =>
                            [device_brand] => Apple
                            [device_model] => iPhone
                            [recent_abuse] =>
                            [bot_status] =>
                            [connection_type] => Premium required.
                            [abuse_velocity] => Premium required.
                            [zip_code] => N/A
                            [latitude] => 29.64
                            [longitude] => -95.22
                            [request_id] => KnaXBPyTGM
                        )

                     */
                } else {
                    $this->warn('Result decode error');
                    dump($result);
                }
            }
        } else {
            $this->info('No requests found');
        }
    }
}
