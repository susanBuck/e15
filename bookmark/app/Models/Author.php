<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Author;

class Author extends Model
{
    use HasFactory;

    public function books()
    {
        # Author has many Books
        # Define a one-to-many relationship.
        return $this->hasMany('App\Models\Book');
    }

    /**
     *
     */
    public static function getForDropdown()
    {
        # Get data for authors in alphabetical order by last name
        return self::orderBy('last_name')->select(['id', 'first_name', 'last_name'])->get();
    }

    /**
     *
     */
    public function getFullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
