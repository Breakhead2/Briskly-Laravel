<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestApiController extends Controller
{
    public function getTestsList()
    {
        $tests = Test::all();

        if ($tests) {
            $response = [
                "success" => true,
                "courses" => $tests,
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Can't find tests",
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
