<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index() {
        $books = Book::all();

        if ($books->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No books found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Books retrieved successfully',
            'data' => $books,
        ], 200);
    }

    public function store(Request $request) {
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'genre_id' => 'required|exists:genres,id',
        'author_id' => 'required|exists:authors,id'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ], 422);
    }

    $image = $request->file('cover_photo');
    $image->store('books', 'public');

    $book = Book::create([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
        'cover_photo' => $image->hashName(),
        'genre_id' => $request->genre_id,
        'author_id' => $request->author_id,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Book created successfully',
        'data' => $book
    ], 201);
}
}
