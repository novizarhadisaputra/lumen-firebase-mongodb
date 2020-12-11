<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::all();
        return response()->json(['message' => 'List category', 'data' => compact('category')], 200);
    }

    public function show(Request $request, $id)
    {
        $category = Category::find($id);

        return response()->json(['message' => 'List category', 'data' => compact('category')], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['message' => 'Invalid input', 'data' => $errors], 400);
        }

        $category = Category::create($request->all());

        return response()->json(['message' => 'Category created', 'data' => compact('category')]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['message' => 'Invalid input', 'data' => $errors], 400);
        }
        $category = Category::where(['_id' => $id])->update($request->all());
        $category = Category::find($id);
        return response()->json(['message' => 'Category created', 'data' => compact('category')]);
    }

    public function delete(Request $request, $id)
    {
        $category = Category::where(['_id' => $id])->delete();
        return response()->json(['message' => 'Category deleted']);
    }
}
