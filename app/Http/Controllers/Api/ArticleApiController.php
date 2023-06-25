<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Word;
use Illuminate\Http\Request;

class ArticleApiController extends Controller
{
    public function getArticlesList()
    {
        $articles = Article::where("course_id", null)->get();

        if ($articles) {
            $response = [
                "success" => true,
                "articles" => $articles,
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Can't find articles",
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function getArticle(Request $request)
    {
        $id = $request->input('id');
        $article = Article::find($id);

        if ($article) {
           $response = [
               "success" => true,
               "article" => $article,
               "words" => Word::where("article_id", $article->id)->get(),
           ];
        } else {
            $response = [
                "success" => false,
                "error" => "Article doesn't exist"
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
