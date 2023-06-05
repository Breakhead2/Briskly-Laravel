<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleApiController extends Controller
{
    public function getArticlesList()
    {
        $articles = Article::all();

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
}
