<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseApiController extends Controller
{
    public function getCoursesList()
    {
        $courses = Course::all();

        if($courses) {
            $response = [
                "success" => true,
                "courses" => $courses,
            ];
        } else {
            $response = [
                "success" => false,
                "error" => "Can't find courses",
            ];
        }

        header('Content-type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
