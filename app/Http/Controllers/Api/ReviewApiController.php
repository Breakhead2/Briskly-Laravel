<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewApiController extends Controller
{
    public function getLastFiveReview()
    {
        $reviews = Review::orderByDesc("created_at")->limit(5)->get();
        $data = [];

        foreach ($reviews as $review){
            $profile = Profile::find($review->profile_id);
            $item = [
                "user_name" => $profile->name,
                "image" => $profile->image_url,
                "text" => $review->text,
            ];
            $data[] = $item;
        }

        $response = [
            "success" => true,
            "reviews" => $data,
        ];

        header("Content-type: application/json");
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function sendReview(Request $request)
    {
        $user = auth("sanctum")->user();
        $text = $request->input("text");
        $profile = Profile::find($user->profile_id);

        Review::create(["text" => $text, "profile_id" => $profile->id]);
        $reviews = Review::orderByDesc("created_at")->limit(5)->get();

        $response = [
            "success" => true,
            "reviews" => $reviews,
        ];

        header("Content-type: application/json");
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
