<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog;
class BlogController extends Controller
{
    //
    public function index() {
        $posts = Blog::all();
        
        $response_array = [
            'success' => true,
            'result' => $posts
        ];
        return response()->json($response_array);
    }
}
