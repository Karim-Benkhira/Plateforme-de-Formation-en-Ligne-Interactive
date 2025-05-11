<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showCategories() {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function createCategory() {
        return view('admin.createCategory');
    }

    public function storeCategory(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->icon = $request->icon;
        $category->color = $request->color;
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function editCategory($id) {
        $category = Category::findOrFail($id);
        return view('admin.editCategory', compact('category'));
    }

    public function updateCategory(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->icon = $request->icon;
        $category->color = $request->color;
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function deleteCategory($id) {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }
}
