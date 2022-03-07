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

        foreach($posts as $post) {
            if($post->cover) {
                $post->cover = url('storage/' . $post->cover);
            }
        }
        
        $response_array = [
            'success' => true,
            'result' => $posts
        ];
        return response()->json($response_array);
    }
    public function show($slug) {
        $post = Blog::where('slug', '=', $slug)->with(['category', 'tags'])->first();
        
        if($post->cover) {
            $post->cover = url('storage/' . $post->cover);
        }

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
