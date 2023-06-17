<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserLesson;
use App\Models\UserTest;
use Illuminate\Http\Request;

class ProfileApiController extends Controller
{
    public function getProfile()
    {
        $user = auth('sanctum')->user();
//        $user = User::find(16);

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
            $profile = Profile::find($user->profile_id);
            switch ($request->input('type')) {
                case "test":
                    $test = UserTest::where([
                        ["user_id", $user->id],
                        ["test_id" => $request->input('id')]
                        ])->first();
                    if (is_null($test)){
                        UserTest::create(["user_id" => $user->id, "test_id" => $request->input('id')]);
                        $profile = Profile::find($user->profile_id);
                        $profile->points += intval($request->input('points'));
                        $profile->save();
                    }
                    break;
                case "lesson":
                    $lesson = UserLesson::where([
                        ["user_id", $user->id],
                        ["lesson_id" => $request->input('id')]
                    ])->first();
                    if (is_null($lesson)){
                        UserLesson::create(["user_id" => $user->id, "lesson_id" => $request->input('id')]);
                        $profile = Profile::find($user->profile_id);
                        $profile->points += intval($request->input('points'));
                        $profile->save();
                    }
                    break;
            }

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
