<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index() {
        $authors = Author::all();

        if ($authors->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No authors found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Authors retrieved successfully',
            'data' => $authors,
        ], 200);
    }

    public function store(Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ], 422);
    }

    $image = $request->file('photo');
    $image->store('authors', 'public');

    $author = Author::create([
        'name' => $request->name,
        'description' => $request->description,
        'photo' => $image->hashName(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Author created successfully',
        'data' => $author
    ], 201);
}
}
