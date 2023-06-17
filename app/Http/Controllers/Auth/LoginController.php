<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            "email" => "required|email|max:255|",
            "password" => ["required", "min:8"],
        ],
            $messages = [
                "email.required" => "Необходимо указать электронную почту",
                "password.required" => "Необходимо указать пароль",
                "email" => "Укажите корректно электронный почтовый адрес",
                "password.min" => "Минимальная длина пароля 8 символов",
            ],
        );
    }

    public function auth(Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return [
                "success" => false,
                "errors" => $validator->errors()->all(),
            ];
        }

        $user = User::where('email', $request->input('email'))->first();

        if (is_null($user)) {
            $response["success"] = false;
            $response["errors"] = ["Пользователь с данным email не найден"];
        } else {
            if (Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken($request->email)->plainTextToken;
                $response["success"] = true;
                $response["data"] = [
                    "profile" => Profile::find($user->profile_id),
                    "token" => $token,
                ];
            } else {
                $response["success"] = false;
                $response["errors"] = ["Пароль неверный"];
            }
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function logout()
    {
        $user = auth('sanctum')->user();
        if ($user) Auth::guard('web')->logout();
    }
}
