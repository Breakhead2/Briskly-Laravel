<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileApiController extends Controller
{
    public function getProfile()
    {
        $user = auth('sanctum')->user();

        if ($user){
            $response = [
                "success" => true,
                "profile" => Profile::find($user->profile_id),
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Вы не авторизованы",
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function sendPoints(Request $request)
    {
        $user = auth('sanctum')->user();
        if ($user) {
            $profile = Profile::find($user->profile->id);
            $profile->points = $request->input('points');
            $profile->save();

            $response = [
                "success" => true,
                "profile" => $profile,
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Вы не авторизованы",
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
