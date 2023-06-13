<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function getUser(){
        $user = auth('sanctum')->user();

        if ($user) {
            $response = [
                "success" => true,
                "user" => $user,
                "profile" => Profile::find($user->profile_id),
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Вы не авторизаванны",
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
