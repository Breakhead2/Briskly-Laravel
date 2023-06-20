<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    public function getUser(){
        $user = auth('sanctum')->user();
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
