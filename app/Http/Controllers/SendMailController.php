<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class SendMailController extends Controller
{
    public function sendNotification(Request $request) {
        $validator = Validator::make($request->all(),
            ["email" => "required|email:rfc,dns"],
            $messages = [
                "required" => "Поле обязательно к заполнению",
                "email" => "Укажите корректно электронный почтовый адрес",
            ]);

        if($validator->fails()){
            return [
                'success' => false,
                'errors' => $validator->errors()->all(),
            ];
        }

        $subs = Subscriber::where('email', $request->input('email'))->first();

        if(is_null($subs)){
            $newSubs = Subscriber::create(['email' => $request->input('email')]);

            $messageTemplate = new SendMail();
            $response = [];

            Mail::to($newSubs->email)->send($messageTemplate);
            $response["success"] = true;
            $response["message"] = "Нам очень приятно, что вы стали частью дружной школы Briskly Learn.";
        } else {
            $response["success"] = true;
            $response["message"] = "Вы уже подписаны на рассылку обновлений.";
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
