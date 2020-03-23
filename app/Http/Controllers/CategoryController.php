<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Category;

class CategoryController extends Controller {
    public function index() {
        $categories = Category::orderBy('name')->get();

        if ($categories->count() == 0) {
            return response()->json(["message" => "Categories not found!"], 404);
        }

        return response()->json($categories, 200);
    }

    public function store(Request $request) {
        $rules = [
            'name' => 'required|max:30|unique:categories'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $name = $request->get('name');

        $category = new Category([
            'name' => $name
        ]);

        $category->save();

        return response()->json($category, 201);
    }
}
