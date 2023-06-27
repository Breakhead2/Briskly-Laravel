<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserWord;
use App\Models\Word;
use App\Models\User;
use Illuminate\Http\Request;

class DictionaryApiController extends Controller
{
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
        $userWord->delete();

        $response["success"] = true;
        header("Content-type: application/json");
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
