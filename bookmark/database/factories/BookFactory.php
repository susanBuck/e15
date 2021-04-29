<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * The model’s default state
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->words(rand(3, 6), true); # e.g. green park balloon
        $slug = Str::slug($title, '-'); # e.g. green-park-balloon

        return [
            'slug' => $slug,
            'title' => $title,
            'published_year' => $this->faker->year,
            'cover_url' => 'https://hes-bookmark.s3.amazonaws.com/cover-placeholder.png',
            'info_url' => 'https://en.wikipedia.org/wiki/' . $slug,
            'purchase_url' => 'https://www.barnesandnoble.com/' . $slug,
            'description' => $this->faker->paragraphs(2, true),
            'author_id' => Author::factory(),
        ];
    }

    /**
     * Special state: Book with no author
     */
    public function withoutAuthor()
    {
        return $this->state(function (array $attributes) {
            return [
                'author_id' => null,
            ];
        });
    }
}