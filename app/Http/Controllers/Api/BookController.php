<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::where('_deleted', 0);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }

        $books = $query->latest()->paginate(10);

        return response()->json([
            'status' => true,
            'data' => $books,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'cover_image' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'published_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $book = Book::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Book created successfully',
            'data' => $book,
        ], 201);
    }

    public function show($id)
    {
        $book = Book::where('_deleted', 0)->find($id);

        if (!$book) {
            return response()->json([
                'status' => false,
                'message' => 'Book not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $book,
        ]);
    }

    public function update(Request $request, $id)
    {
        $book = Book::where('_deleted', 0)->find($id);

        if (!$book) {
            return response()->json([
                'status' => false,
                'message' => 'Book not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'cover_image' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'published_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $book->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Book updated successfully',
            'data' => $book,
        ]);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book || $book->_deleted == 1) {
            return response()->json([
                'status' => false,
                'message' => 'Book not found',
            ], 404);
        }

        $book->_deleted = 1;
        $book->save();

        return response()->json([
            'status' => true,
            'message' => 'Book deleted successfully',
        ]);
    }
}