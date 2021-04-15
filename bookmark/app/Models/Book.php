<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     *
     */
    public static function findBySlug($slug)
    {
        return self::where('slug', '=', $slug)->first();
    }

    public function isModern()
    {
        return $this->published_year > 2000;
    }

    public function author()
    {
        # Book belongs to Author
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('App\Models\Author');
    }
}
