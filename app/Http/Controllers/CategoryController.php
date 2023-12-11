<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    
    public function index()
    {
        $category = Category::get();
        return Response::json([
            'data' => $category,
            'success' => true
        ]);
    }

    /**
     * Insert the data.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories',
            'desc' => 'required',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->desc = $request->desc;
        $category->save();

        return Response::json([
            'data' => $category,
            'success' => true
        ], 201);
    }

    /**
     * Display the particular record.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if ($category) {
            return Response::json([
                'data' => $category,
                'success' => true
            ]);
        } else {
            return Response::json([
                'data' => $category,
                'success' => false,
                'message' => 'category not found'
            ], 404);
        }
    }

    /**
     * Update particular record.
     */
    public function update(string $id, Request $request,)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $id,
            'desc' => 'required',
        ]);

        $category = Category::find($id);
        if ($category) {
            $category->name = $request->name;
            $category->desc = $request->desc;
            $category->save();

            return Response::json([
                'data' => $category,
                'success' => true
            ]);
        } else {
            return Response::json([
                'data' => $category,
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }
    }

    /**
     * Delete the particular record.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return Response::json([
                'message' => 'Category Deleted successfully',
                'success' => true
            ]);
        } else {
            return Response::json([
                'message' => 'Category not found',
                'success' => false
            ], 400);
        }
    }
}