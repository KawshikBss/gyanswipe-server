<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\UserPreferredCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::paginate(10);
        $userPreferredCategories = UserPreferredCategory::where('device_id', $request->device_id)->pluck('category_id')->toArray();
        $categories->getCollection()->transform(function ($category) use ($userPreferredCategories) {
            $category->is_preferred = in_array($category->id, $userPreferredCategories);
            return $category;
        });
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

    public function togglePreference(Request $request, Category $category)
    {
        $request->validate([
            'device_id' => 'required|string|max:255',
        ]);

        $userPreferredCategory = UserPreferredCategory::where('device_id', $request->device_id)
            ->where('category_id', $category->id)
            ->first();

        if ($userPreferredCategory) {
            $userPreferredCategory->delete();
            return response()->json(['message' => 'Preference removed', 'active' => false]);
        } else {
            UserPreferredCategory::create([
                'device_id' => $request->device_id,
                'category_id' => $category->id,
            ]);
            return response()->json(['message' => 'Preference added', 'active' => true]);
        }
    }
}
