<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog;
class BlogController extends Controller
{
    //
    public function index() {
        $posts = Blog::paginate(6);
        
        $response_array = [
            'success' => true,
            'result' => $posts
        ];
        return response()->json($response_array);
    }
    public function show($slug) {
        $post = Blog::where('slug', '=', $slug)->with(['category', 'tags'])->first();
        
        if($post) {
            return response()->json([
                'success' => true,
                'results' => $post
            ]);
        } else {
            return response()->json([
                'success' => false,
                'results' => []
            ]);
        }
    }
}
