<?php

namespace App\Http\Controllers\Extra;

use App\Http\Controllers\Controller;
use App\Http\Requests\Extra\ExtraStoreRequest;
use App\Http\Requests\Extra\ExtraUpdateRequest;
use App\Models\Extra;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $paginate = (int) request()->get('paginate', 13);
            $page = (int) request()->get('page', 1);

            $extras = Extra::paginate($paginate, ['*'], 'page', $page);
            return $this->successResponse(['extras List: ', $extras], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(
                ['Error retrieving Extras list',  $e->getMessage()],
            );
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ExtraStoreRequest $request)
    {
        try {
            $extra = Extra::create($request->validated());
            return $this->successResponse(["Extra created successfully", $extra],201);
        } catch (\Exception $e) {
            return $this->errorResponse(['Error creating the extra', $e->getMessage()], 500);
        }   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $extra = Extra::findOrFail($id);
            return $this->successResponse(["Extra listed successfully", $extra],200);
        }   catch (ModelNotFoundException $e) {
            return $this->errorResponse(['Extra not found.'], 404);
        }   catch (\Exception $e) {
            return $this->errorResponse(['Error creating the extra', $e->getMessage()], 500);
        }   
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ExtraUpdateRequest $request, Extra $extra)
    {
        try {
            $extra->update($request->validated());
            return $this->successResponse(["Extra updated successfully", $extra],201);
        } catch (\Exception $e) {
            return $this->errorResponse(['Error updating the Extra', $e->getMessage()], 500);
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Extra $extra)
    {
        try {
            $extra->delete();
            return $this->successResponse(['Extra deleted successfully', $extra], 201);
        } catch (\Exception $e) {
            return $this->errorResponse(['Error deleting the Extra', $e->getMessage()], 500);
        }
    }
}
