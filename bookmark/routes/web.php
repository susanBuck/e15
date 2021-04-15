<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PracticeController;

/**
 * Misc.
 */
Route::get('/', [PageController::class, 'index']);
Route::get('/support', [PageController::class, 'support']);
Route::any('/practice/{n?}', [PracticeController::class, 'index']);


Route::group(['middleware' => 'auth'], function () {

    /**
     * Book - CREATE
     */
    # Make sure the create route comes before `/books/{slug?}` so it takes precedence
    Route::get('/books/create', [BookController::class, 'create']);

    # Note the use of the post method in this route
    Route::post('/books', [BookController::class, 'store']);

    /**
     * Book - READ
     */
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/search', [BookController::class, 'search']);
    Route::get('/books/{slug}', [BookController::class, 'show']);
    Route::get('/list', [BookController::class, 'list']);

    /**
     * Book - UPDATE
     */
    # Show the form to edit a specific book
    Route::get('/books/{slug}/edit', [BookController::class, 'edit']);

    # Process the form to edit a specific book
    Route::put('/books/{slug}', [BookController::class, 'update']);

    /**
     * Book - DELETE
     */
    # Show the page to confirm deletion of a book
    Route::get('/books/{slug}/delete', [BookController::class, 'delete']);

    # Process the deletion of a book
    Route::delete('/books/{slug}', [BookController::class, 'destroy']);
});