<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index()
    {
        try {
            $books = Books::paginate(25);

            return response()->json([
                'status' => true,
                'message' => 'Success get all books',
                'data' => $books
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to get books',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publish_date' => 'required',
        ]);

        try {
            $book = new Books;
            $book->name = $validateData['name'];
            $book->author = $validateData['author'];
            $book->publish_date = $validateData['publish_date'];
            $book->save();

            return response()->json([
                'status' => true,
                'message' => 'Success to store a book',
                'data' => $book
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to store a book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $book = Books::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Success get book details',
                'data' => $book
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to get book details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $book = Books::findOrFail($id);

            $book->name = $request->name;
            $book->author = $request->author;
            $book->publish_date = $request->publish_date;
            $book->save();

            return response()->json([
                'status' => true,
                'message' => 'Book updated successfully',
                'data' => $book
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $book = Books::findOrFail($id);

            $book->delete();

            return response()->json([
                'status' => true,
                'message' => 'Book deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete book',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
