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

    /**
     * Hypotehtical method to contrast the use of static vs. not
     */
    public function isModern()
    {
        return $this->published_year > 2000;
    }
}
