<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserWord;
use App\Models\Word;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class DictionaryApiController extends Controller
{
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            "word" => ["required", "max:64"],
            "translate" => ["required", "max:64"],
            "image" => ["required"]
        ],
            $messages = [
                "word.required" => "Необходимо заполнить поле слово",
                "word.max" => "Слишком длинное слово",
                "translate.required" => "Необходимо указать перевод",
                "translate.max" => "Слишком длинное слово",
                "image.required" => "Необходимо задать картинку",
            ],
        );
    }

    public function getDictionary(): void
    {
        $user = auth('sanctum')->user();

        $words = [];
        $userWordsId = UserWord::where("user_id", $user->id)->get();

        if ($userWordsId) {
            foreach ($userWordsId as $item) {
                $words[] = Word::find($item->word_id);
            }

            $response = [
                "success" => true,
                "words" => $words,
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "You dictionary is empty",
            ];
        }

        header("Content-type: application/json");
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function removeWord(Request $request)
    {
        $user = auth('sanctum')->user();

        $wordId = $request->input('id');
        $userWord = UserWord::where([
            ["word_id", $wordId],
            ["user_id", $user->id],
            ])->first();
        Word::find($wordId)->delete();
        $userWord->delete();

        $words = [];
        $userWordsId = UserWord::where("user_id", $user->id)->get();
        foreach ($userWordsId as $item) {
            $words[] = Word::find($item->word_id);
        }

        $response = [
            "success" => true,
            "words" => $words,
            ];
        header("Content-type: application/json");
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function storeWord(Request $request)
    {
        $user = auth("sanctum")->user();
//        $user = User::find(15);

        $validator = $this->validator($request);

        if ($validator->fails()) {
            return [
                "success" => false,
                "errors" => $validator->errors()->all(),
            ];
        }

        $word = Word::updateOrCreate(["id" => $request->input("wordId")], [
            "value" => $request->input("word"),
            "translate" =>$request->input("translate"),
        ]);

        if ($request->input("image") && !str_contains($request->input('image'), env('APP_URL'))) {

            $code = explode('base64,', $request->input("image"))[1];
            $image = base64_decode($code);

            if (isset($word->image)) {
                Storage::delete(Storage::files('public/images/words/' . $word->id));
            }

            $file = $request->input('word') . Str::random(5) . '.png';
            Storage::put('public/images/words/' . $word->id . '/' . $file, $image);
            $path = env('APP_URL') . 'storage/images/words/' . $word->id . '/' . $file;
            $word->image = $path;
            $word->save();
        }

        $userWord = UserWord::where([
            ["word_id", $word->id],
            ["user_id", $user->id],
        ])->first();

        if (is_null($userWord)) {
            UserWord::create([
                "user_id" => $user->id,
                "word_id" => $word->id,
            ]);
        }

        $userWordsId = UserWord::where("user_id", $user->id)->get();
        $words = [];
        foreach ($userWordsId as $item) {
            $words[] = Word::find($item->word_id);
        }

        $response = [
            "success" => true,
            "words" => $words,
        ];

        header("Content-type: application/json");
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function getWord(Request $request)
    {
        $user = auth("sanctum")->user();
        $wordId = $request->input("id");

        $word = Word::find($wordId);

        if ($word) {
            $response = [
                "success" => true,
                "word" => $word,
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Word doesn't exist",
            ];
        }

        header("Content-type: application/json");
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function clearForm() {
        $response = [
            "success" => true,
            "word" => [
                "value" => "",
                "translate" => "",
                "image" => "",
            ]
        ];

        header("Content-type: application/json");
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
