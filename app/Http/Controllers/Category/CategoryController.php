<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $paginate = (int) request()->get('paginate', 13);
            $page = (int) request()->get('page', 1);

            $categories = Category::paginate($paginate, ['*'], 'page', $page);
            return $this->successResponse(['Categories List: ', $categories], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(
                ['Error retrieving categories list',  $e->getMessage()],
            );
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        try {
            $category = Category::create($request->validated());
            return $this->successResponse(["Category created successfully", $category],201);
        } catch (\Exception $e) {
            return $this->errorResponse(['Error creating the category', $e->getMessage()], 500);
        }   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            return $this->successResponse(["Category listed successfully", $category],200);
        }   catch (ModelNotFoundException $e) {
            return $this->errorResponse(['Category not found.'], 404);
        }   catch (\Exception $e) {
            return $this->errorResponse(['Error creating the category', $e->getMessage()], 500);
        }   
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        try {
            $category->update($request->validated());
            return $this->successResponse(["Category updated successfully", $category],201);
        } catch (\Exception $e) {
            return $this->errorResponse(['Error updating the category', $e->getMessage()], 500);
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->successResponse(['Category deleted successfully', $category], 201);
        } catch (\Exception $e) {
            return $this->errorResponse(['Error deleting the category', $e->getMessage()], 500);
        }
    }
}
