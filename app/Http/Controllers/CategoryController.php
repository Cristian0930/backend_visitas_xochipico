<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify')->except('index', 'show');
        $this->middleware('admin')->except('index', 'show');
    }

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Category::all();
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    public function show(Category $category): Category
    {
        return $category;
    }

    public function update(Request $request, Category $category): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $category->update($request->all());

        return response()->json($category);
    }

    public function destroy(Category $category): \Illuminate\Http\JsonResponse
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
