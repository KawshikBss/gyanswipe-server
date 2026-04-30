<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $category->thumbnail = $path;
        }

        $category->save();

        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:categories,slug,' . $category->id,
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->has('name')) {
            $category->name = $request->name;
        }
        if ($request->has('slug')) {
            $category->slug = $request->slug;
        }
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $category->thumbnail = $path;
        }

        $category->save();

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 204);
    }
}
