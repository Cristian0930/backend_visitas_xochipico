<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify')->except('index', 'show');
        $this->middleware('admin')->except('index', 'show');
    }

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Post::all()->load('category');
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'url_image' => 'required|string|max:255',
            'category_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post = Post::create($request->all());
        return response()->json($post, 201);
    }

    public function show(Post $post): Post
    {
        return $post;
    }

    public function update(Request $request, Post $post): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'url_image' => 'required|string|max:255',
            'category_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post->update($request->all());

        return response()->json($post);
    }

    public function destroy(Post $post): \Illuminate\Http\JsonResponse
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
