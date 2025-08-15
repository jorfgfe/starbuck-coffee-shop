<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $paginate = (int) request()->get('paginate', 13);
            $page = (int) request()->get('page', 1);

            $products = Product::paginate($paginate, ['*'], 'page', $page);
            return $this->successResponse(['Products List: ', $products], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(
                ['Error retrieving Products list',  $e->getMessage()],
            );
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            $product = Product::create($request->validated());
            return $this->successResponse(["Product created successfully", $product],201);
        } catch (\Exception $e) {
            return $this->errorResponse(['Error creating the Product', $e->getMessage()], 500);
        }   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            return $this->successResponse(["Product listed successfully", $product],200);
        }   catch (ModelNotFoundException $e) {
            return $this->errorResponse(['Product not found.'], 404);
        }   catch (\Exception $e) {
            return $this->errorResponse(['Error creating the Product', $e->getMessage()], 500);
        }   
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        try {
            $product->update($request->validated());
            return $this->successResponse(["Product updated successfully", $product],201);
        } catch (\Exception $e) {
            return $this->errorResponse(['Error updating the Product', $e->getMessage()], 500);
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return $this->successResponse(['Product deleted successfully', $product], 201);
        } catch (\Exception $e) {
            return $this->errorResponse(['Error deleting the Product', $e->getMessage()], 500);
        }
    }
}
