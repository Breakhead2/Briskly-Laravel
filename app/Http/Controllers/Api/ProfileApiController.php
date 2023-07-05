<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserLesson;
use App\Models\UserTest;
use App\Models\UserWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileApiController extends Controller
{
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            "name" => "required|max:255",
            "password" => ["required"],
            "surname" => ["max:255", "sometimes", "nullable"],
        ],
            $messages = [
                "name.required" => "Укажите как к вам обращаться",
                "password.required" => "Необходимо указать пароль",
            ],
        );
    }

    public function getProfile()
    {
        $user = auth('sanctum')->user();

        if ($user){
            $response = [
                "success" => true,
                "profile" => Profile::find($user->profile_id),
                "avatars" => Avatar::all(),
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

    public function editProfile(Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return [
                "success" => false,
                "errors" => $validator->errors()->all(),
            ];
        }
        $user = auth("sanctum")->user();

        if (Hash::check($request->input("password"), $user->password)) {
            $profile = Profile::find($user->profile_id);
            $profile->fill([
                'name' => $request->input("name"),
                'surname' => $request->input("surname"),
            ]);
            $profile->save();

            $response = [
                "success" => true,
                "profile" => $profile,
            ];
        } else {
            $response = [
                "success" => false,
                "errors" => ["Неверный пароль"],
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
                        ["test_id", $request->input('id')]
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
                        ["lesson_id", $request->input('id')]
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

            header('Content-type: application/json');
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

    public function storeWords(Request $request)
    {
        $user = auth('sanctum')->user();

        if ($user) {
            $newWords = ($request->input('words'));
            $userWords = UserWord::where("user_id", $user->id)->get();
            $vocabulary = [];

            foreach ($userWords as $userWord) {
                $vocabulary[] = $userWord->word_id;
            }

            foreach ($newWords as $newWord) {
                if (!in_array($newWord, $vocabulary)) {
                    UserWord::create([
                        "user_id" => $user->id,
                        "word_id" => $newWord
                    ]);
                }
            }
            $response = [
                "success" => true,
                "message" => "Слова успешно добавлены в словарь."
            ];

            header('Content-type: application/json');
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }
}
