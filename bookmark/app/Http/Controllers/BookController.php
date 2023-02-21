<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {
        return 'Show all the books';
    }

    public function show($title) {
        # Query the database for the book where title = $title
        # Load a view to display the book that we got from the database
        return 'This is the details for the book: ' . $title;
    }

    public function filter($category, $subcategory) {
        return $category . ',' . $subcategory;
    }
}
