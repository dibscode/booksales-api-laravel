<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    // POST
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

    // GET
    public function show(string $id) {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'author not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'author retrieved successfully',
            'data' => $author
        ], 200);
    }

    // PUT
    public function update(string $id, Request $request) {
        // 1. mencari data
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'author not found',
            ], 404);
        }

        // 2. validasi data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        //4. handle image (upload & delete photo)
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image->store('authors', 'public');

            if($author->photo) {
                Storage::disk('public')->delete('authors/' . $author->photo);
            }

            $data['photo'] = $image->hashName();
        }

        // 5. update daya baru ke database
        $author->update($data);
        return response()->json([
            'success' => true,
            'message' => 'author updated successfully',
            'data' => $author
        ], 200);
    }

    // DELETE
    public function destroy(string $id) {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'author not found',
            ], 404);
        }

        if ($author->cover_photo) {
            // delete from storage
            Storage::disk('public')->delete('authors/' . $author->cover_photo);
        }

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'author deleted successfully',
        ], 200);
    }
}
