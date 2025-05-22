<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index() {
        $genres = Genre::all();

        if ($genres->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No genres found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Genres retrieved successfully',
            'data' => $genres,
        ], 200);
    }

    public function store(Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ], 422);
    }


    $genre = Genre::create([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Genre created successfully',
        'data' => $genre
    ], 201);
}
}
