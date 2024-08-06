<?php

namespace App\Console\Commands;

use App\Models\GoogleMyBusinessPoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ParseGoogleMyBusinessReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-google-my-business-reviews {google_my_business_account_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse all reviews from Google My Business Acoount Reviews page';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $gmba = GoogleMyBusinessPoint::find($this->argument('google_my_business_account_id'));

        $data = [
            'command' => 'parse_reviews',
            'organization_url' => $gmba->organization_google_maps_url,
            'ads_profile_id' => $gmba->adspower_profile_id,
        ];

        //$response = Http::post('http://127.0.0.1:55748', $data);
        $response = Http::timeout(120)->post('http://127.0.0.1:55748/parse_reviews', $data);
        echo "Status = " . $response->status() . ", Body = " . $response->body();
    }
}
