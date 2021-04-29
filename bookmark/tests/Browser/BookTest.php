<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Book;
use App\Models\User;

class BookTest extends DuskTestCase
{
    use withFaker;
    use DatabaseMigrations;

    /**
     *
     */
    public function testLoadingBookWithAuthor()
    {
        $this->browse(function (Browser $browser) {
            $book = Book::factory()->has(User::factory())->create();
            $user = $book->users()->first();
            
            $browser->loginAs($user->id)
                    ->visit('/books/' . $book->slug)
                    ->assertSee($book->title)
                    ->assertPresent('@author-info');
        });
    }

    /**
     * This test is a little superfulous and redundant from the above test
     * Including it just to show how we can use a factory state (`withoutAuthor`)
     */
    public function testLoadingBookWithNoAuthor()
    {
        $this->browse(function (Browser $browser) {
            $book = Book::factory()->withoutAuthor()->has(User::factory())->create();
            $user = $book->users()->first();
            $browser->loginAs($user->id)
                    ->visit('/books/' . $book->slug)
                    ->assertMissing('@author-info');
        });
    }

    /**
     *
     */
    public function testAddingBook()
    {
        $this->browse(function (Browser $browser) {
            
            # Let our book factory generate a book for us
            # here we use the `make` method instead of `create`
            # so the data is generated but not actually persisted to the database
            $book = Book::factory()->make();
            
            # Create a user to create a new book as
            $user = User::factory()->create();
            
            $browser->loginAs($user->id)
                    ->visit('/books/create')
                    ->value('@slug-input', $book->slug)
                    ->value('@title-input', $book->title)
                    ->value('@published-year-input', $book->published_year)
                    ->value('@cover-url-input', $book->cover_url)
                    ->value('@info-url-input', $book->info_url)
                    ->value('@purchase-url-input', $book->purchase_url)
                    ->value('@author-id-select', $book->author->id)
                    ->value('@description-textarea', $book->description)
                    ->click('@add-book-button')
                    ->assertPathIs('/books/create')
                    ->assertSeeIn('@flash-alert', $book->title);
        });
    }

    /**
     *
     */
    public function testAddingBookWithExistingSlug()
    {
        $this->browse(function (Browser $browser) {
            
            # Generate an existing book
            $book = Book::factory()->create();
            
            # Create a user to create a new book as
            $user = User::factory()->create();
            
            $browser->loginAs($user->id)
                    ->visit('/books/create')
                    ->value('@slug-input', $book->slug) # Existing Slug
                    ->value('@title-input', $book->title)
                    ->value('@published-year-input', $book->published_year)
                    ->value('@cover-url-input', $book->cover_url)
                    ->value('@info-url-input', $book->info_url)
                    ->value('@purchase-url-input', $book->purchase_url)
                    ->value('@author-id-select', $book->author->id)
                    ->value('@description-textarea', $book->description)
                    ->click('@add-book-button')
                    ->assertPresent('@error-field-slug');
        });
    }

    /**
     *
     */
    public function testDeletingBook()
    {
        $this->browse(function (Browser $browser) {
            
            # Generate an existing book
            $book = Book::factory()->create();
            
            # Create a user to create a new book as
            $user = User::factory()->create();
            
            $browser->loginAs($user->id)
                    ->visit('/books/'.$book->slug)
                    
                    ->click('@delete-button')
                    ->click('@confirm-delete-button')
                    ->assertSeeIn('@flash-alert', $book->title)
                    ->assertSeeIn('@flash-alert', 'removed')
                    ->assertPresent('@empty-books');
        });
    }

    /**
     *
     */
    public function testUpdatingBook()
    {
        $this->browse(function (Browser $browser) {
            
            # Generate an existing book
            $book = Book::factory()->create();

            $updatedTitle = $book->title.' 2';
            
            # Create a user to create a new book as
            $user = User::factory()->create();
            
            $browser->loginAs($user->id)
                    ->visit('/books/'.$book->slug)
                    ->click('@edit-button')
                    ->type('@title-input', $updatedTitle)
                    ->click('@update-button')
                    ->assertSeeIn('@flash-alert', 'Your updates were saved')
                    ->assertSee($updatedTitle);
        });
    }
}