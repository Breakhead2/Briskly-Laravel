<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Slide;
use Illuminate\Http\Request;

class SliderApiController extends Controller
{
    public function getSlides()
    {
        $slides = Slide::orderByDesc('created_at')->limit(3);
        if ($slides) {
            $response = [
                "success" => true,
                "slides" => $slides,
            ];
        } else {
            $response["success"] = false;
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
