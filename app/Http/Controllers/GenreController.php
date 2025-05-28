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

    // POST
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

    public function show(string $id) {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Genre retrieved successfully',
            'data' => $genre
        ], 200);
    }

    // PUT
    public function update(string $id, Request $request) {
        // 1. mencari data
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found',
            ], 404);
        }

        // 2. validasi data
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

        // 3. siapkan data yang ingin di update 
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // 4. update daya baru ke database
        $genre->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Genre updated successfully',
            'data' => $genre
        ], 200);
    }

    // DELETE
    public function destroy(string $id) {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'genre not found',
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'genre deleted successfully',
        ], 200);
    }
}
