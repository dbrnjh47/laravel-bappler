<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ExportWorkizReportsToGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-workiz-reports-to-google-sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export jobs and payments reports to google sheet document';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = [
            'command' => 'update_workiz_reports',
            'organization_url' => '',
            'ads_profile_id' => env('WINDOWS_SERVER_ADS_PROFILE_ID'),
        ];

        $response = Http::timeout(120)->post(
            'http://' . env('WINDOWS_SERVER_IP_ADDRESS', '127.0.0.1:55748') . '/update_workiz_reports',
            $data
        );
        echo "Status = " . $response->status() . ", Body = " . $response->body();
    }
}
