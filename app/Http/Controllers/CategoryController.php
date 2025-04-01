<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|min:3|max:64|unique:categories,name',
            ]);

            $category = Category::create([
                'name' => $validated['name'],
            ]);

            return response()->json([
                'message' => 'Category created successfully',
                'category' => $category
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating category',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found'
                ], Response::HTTP_NOT_FOUND);
            }

            $validated = $request->validate([
                'name' => 'required|string|min:3|max:64|unique:categories,name,' . $id,
            ]);

            $category->update([
                'name' => $validated['name'],
            ]);

            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $category
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating category',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found'
                ], Response::HTTP_NOT_FOUND);
            }

            // Check if the category is being used by any notes
            $notesCount = $category->notes()->count();
            if ($notesCount > 0) {
                return response()->json([
                    'message' => 'Cannot delete category that is still in use',
                    'notes_count' => $notesCount
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $category->delete();

            return response()->json([
                'message' => 'Category deleted successfully'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting category',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function findByName(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:64',
            ]);

            $category = Category::findByName($validated['name']);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error searching for category',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}