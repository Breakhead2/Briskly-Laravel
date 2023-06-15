<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function getUser(){
//        $user = auth('sanctum')->user();
        $user = User::find(16);
        $response = [];

        if ($user) {
            $response = [
                "success" => true,
                "user" => $user,
                "profile" => Profile::find($user->profile_id),
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
