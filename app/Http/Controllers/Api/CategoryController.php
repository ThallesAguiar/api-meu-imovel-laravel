<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        try {
            $category = Category::create($data);

            return response()->json(['success' => 'Category created']);
        } catch (\Exception $e) {
            $erro = new ApiMessages($e);

            return response()->json($erro->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);

            return response()->json($category);
        } catch (\Exception $e) {
            $erro = new ApiMessages($e);

            return response()->json($erro->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();

        try {
            $category = Category::findOrFail($id);

            $category->update($data);

            return response()->json(['success' => 'Category updated']);
        } catch (\Exception $e) {
            $erro = new ApiMessages($e);

            return response()->json($erro->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete($category);

            return response()->json(['success' => 'Category ' . $id . ' deleted']);
        } catch (\Exception $e) {
            $erro = new ApiMessages($e->getMessage());

            return response()->json($erro->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }

    public function realStates($id){

        try {
            $category = Category::findOrFail($id);

            return response()->json([
                'data'=> $category->realStates //realStates -> nome do metodo de relação no Model.
            ]);
        } catch (\Exception $e) {
            $erro = new ApiMessages($e->getMessage());

            return response()->json($erro->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }
}
