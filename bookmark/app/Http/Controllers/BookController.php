<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BookController extends Controller
{
    /**
     * GET /books
     */
    public function index()
    {
        # Load book data using PHP’s file_get_contents
        # We specify the books.json file path using Laravel’s database_path helper
        $bookData = file_get_contents(database_path('books.json'));

        # Convert the string of JSON text loaded from books.json into an
        # array using PHP’s built-in json_decode function
        $books = json_decode($bookData, true);

        # Alphabetize the books by title using Laravel’s Arr::sort
        $books = Arr::sort($books, function ($value) {
            return $value['title'];
        });
        
        return view('books/index', ['books' => $books]);
    }

    /**
     * GET /books/{slug}
     */
    public function show($slug)
    {
        # Load book data
        # @TODO: This code is redundant with loading the books in the index method
        $bookData = file_get_contents(database_path('books.json'));
        $books = json_decode($bookData, true);

        # Narrow down array of books to the single book we’re loading
        $book = Arr::first($books, function ($value, $key) use ($slug) {
            return $key == $slug;
        });

        return view('books/show', [
            'book' => $book
        ]);
    }

    /**
     *
     */
    public function filter($category, $subcategory)
    {
        return 'Show all books in these categories: ' . $category . ',' . $subcategory;
    }
}
