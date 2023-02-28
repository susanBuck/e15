<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        # TODO: Query DB for all books
        
        //return view('books/index');
    }

    public function show($title)
    {
        # TODO: Query the database for the book where title = $title

        return view('books/show', [
            'title' => $title,
            'bookFound' => false
        ]);
    }

    public function filter($category, $subcategory)
    {
        return 'Show all books in these categories: ' . $category . ',' . $subcategory;
    }
}
