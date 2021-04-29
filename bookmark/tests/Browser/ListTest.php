<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Book;
use App\Models\User;

class ListTest extends DuskTestCase
{
    use withFaker;
    use DatabaseMigrations;

    /**
     *
     */
    public function testListWithBooks()
    {
        $this->browse(function (Browser $browser) {
            $book = Book::factory()->has(User::factory())->create();
            $user = $book->users()->first();
            
            $browser->loginAs($user->id)
                    ->visit('/list')
                    ->assertSee($book->title);
        });
    }

    /**
     *
     */
    public function testEmptyList()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            
            $browser->loginAs($user->id)
                    ->visit('/list')
                    ->assertPresent('@no-books-message');
        });
    }

    /**
     *
     */
    public function testAddingToList()
    {
        $this->browse(function (Browser $browser) {

            # A user to work with
            $user = User::factory()->create();

            # A book the user can add to their list
            $book = Book::factory()->create();
            
            # Some dummy text for the notes
            $notes = $this->faker->sentences(2, true);

            $browser->loginAs($user->id)
                    ->visit('/books/' . $book->slug)
                    ->click('@add-to-list-button')
                    ->type('@notes-textarea', $notes)
                    ->click('@save-button')
                    ->assertPathIs('/list')
                    ->assertSee($book->title)
                    ->assertSee($notes);
        });
    }

    /**
     *
     */
    public function testUpdatingList()
    {
        $this->browse(function (Browser $browser) {
            $book = Book::factory()->has(User::factory())->create();
            $user = $book->users()->first();
            $newNote = $this->faker->sentences(2, true);
        
            $browser->loginAs($user->id)
                    ->visit('/list')
                    ->type('@' . $book->slug . '-notes-textarea', $newNote)
                    ->click('@update-button')
                    ->assertSeeIn('@flash-alert', $book->title)
                    ->assertSeeIn('@flash-alert', 'updated');
        });
    }

    /**
     *
     */
    public function testRemovingFromList()
    {
        $this->browse(function (Browser $browser) {
            $book = Book::factory()->has(User::factory())->create();
            $user = $book->users()->first();
            
            $browser->loginAs($user->id)
                    ->visit('/list')
                    ->click('@' . $book->slug . '-remove-from-list-button')
                    ->assertSeeIn('@flash-alert', $book->title)
                    ->assertSeeIn('@flash-alert', 'removed')
                    ->assertVisible('@no-books-message');
        });
    }
}