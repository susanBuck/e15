<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome() {
        return '<h1>Bookmark</h1>';
    }

    public function contact() {
        return '<h1>Contact us at mail@bookmark.com</h1>';
    }
}
