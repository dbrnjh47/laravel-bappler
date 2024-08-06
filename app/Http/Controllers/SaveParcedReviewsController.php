<?php

namespace App\Http\Controllers;

use App\Models\GoogleMyBusinessPoint;
use App\Models\GoogleMyBusinessReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaveParcedReviewsController extends Controller
{
    public function saveParcedReviewsData(Request $request)
    {
        $data = $request->all(); // Получить все данные POST запроса

        $adsProfileId = $data['ads_profile_id']; // Получить значение ads_profile_id
        $reviews = $data['reviews']; // Получить массив отзывов

        $googleMyBusinessAccount = GoogleMyBusinessPoint::where('adspower_profile_id', $adsProfileId)->first();

        // Delete all reviews
        DB::table('google_my_business_reviews')->where('google_my_business_point_id', $googleMyBusinessAccount->id)->delete();

        foreach ($reviews as $review) {
            // Save reviews
            $newReview = new GoogleMyBusinessReview();
            $newReview->google_my_business_point_id = $googleMyBusinessAccount->id;
            $newReview->name = strval($review['review_name']);
            $newReview->date_published = "";
            $newReview->stars = floatval($review['review_stars']);
            $newReview->text = strval($review['review_text']);
            $newReview->save();
        }

        return response()->json(['message' => 'Data saved!']);
    }
}
