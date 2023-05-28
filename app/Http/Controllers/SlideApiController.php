<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;

class SlideApiController extends Controller
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
