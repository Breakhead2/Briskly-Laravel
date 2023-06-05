<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Rules\ConfirmPassword;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            "name" => "required|max:255",
            "email" => "required|email|max:255|unique:users",
            "password" => ["required", "min:8"],
            "repeat_pass" => ["required", new ConfirmPassword($request->input('password'))]
        ],
            $messages = [
                "required" => "Поле обязательно к заполнению",
                "email" => "Укажите корректно электронный почтовый адрес",
                "unique" => "Такой email уже зарегистрирован",
                "min" => "Минимальная длина пароля 8 символов",
            ],
        );
    }

    public function create(Request $request)
    {
        $validator = $this->validator($request);

        if($validator->fails()){
            return [
                "success" => false,
                "errors" => $validator->errors()->all(),
            ];
        }

        $user = User::create([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "password" => Hash::make($request->input('password')),
        ]);
        Auth::loginUsingId($user->id, true);

        $profile = Profile::create([
            "name" => $user->name,
        ]);

        $user->profile_id = $profile->id;
        $user->save();

        $response["success"] = true;
        $response["data"] = [
            "user" => $user,
            "profile" => Profile::find($user->profile_id),
        ];

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
