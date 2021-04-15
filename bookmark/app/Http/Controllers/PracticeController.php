<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Author;

class PracticeController extends Controller
{
    public function practice12()
    {
        # Eager load the author with the book
        $books = Book::with('author')->get();

        foreach ($books as $book) {
            if ($book->author) {
                dump($book->author->first_name.' '.$book->author->last_name.' wrote '.$book->title);
            } else {
                dump($book->title. ' has no author associated with it.');
            }
        }

        dump($books->toArray());
    }

    
    public function practice11()
    {
        # Get an example book
        $book = Book::whereNotNull('author_id')->first();

        # Get the author from this book using the "author" dynamic property
        # "author" corresponds to the the relationship method defined in the Book model
        $author = $book->author;

        # Output
        dump($book->title.' was written by '.$author->first_name.' '.$author->last_name);
        dump($book->toArray());
    }
    
    public function practice10()
    {
        $author = Author::where('first_name', '=', 'J.K.')->first();

        $book = new Book;
        $book->slug = 'fantastic-beasts-and-where-to-find-them';
        $book->title = "Fantastic Beasts and Where to Find Them";
        $book->published_year = 2001;
        $book->cover_url = 'https://hes-bookmark.s3.amazonaws.com/cover-placeholder.png';
        $book->info_url = 'https://en.wikipedia.org/wiki/Fantastic_Beasts_and_Where_to_Find_Them';
        $book->purchase_url = 'http://www.barnesandnoble.com/w/fantastic-beasts-and-where-to-find-them-j-k-rowling/1004478855';
        $book->author()->associate($author); # <--- Associate the author with this book
        $book->description = 'Fantastic Beasts and Where to Find Them is a 2001 guide book written by British author J. K. Rowling (under the pen name of the fictitious author Newt Scamander) about the magical creatures in the Harry Potter universe. The original version, illustrated by the author herself, purports to be Harry Potter’s copy of the textbook of the same name mentioned in Harry Potter and the Philosopher’s Stone (or Harry Potter and the Sorcerer’s Stone in the US), the first novel of the Harry Potter series. It includes several notes inside it supposedly handwritten by Harry, Ron Weasley, and Hermione Granger, detailing their own experiences with some of the beasts described, and including in-jokes relating to the original series.';
        $book->save();
        dump($book->toArray());
    }
    
    public function practice9(Request $request)
    {
        # Retrieve the currently authenticated user via the Auth facade
        // $user = Auth::user();
        // dump($user);

        // # Retrieve the currently authenticated user via request object
        // $user = $request->user();
        // dump($user->toArray());

        // # Check if the user is logged in
        if (Auth::check()) {
            dump('The user ID is '.Auth::id());
            dump($request->user()->id);
            dump(Auth::user()->id);
        }
    }


    /**
    * Demonstrating Collections
    */
    public function practice8()
    {
        $books = Book::all();
        // echo $books; # This will output a JSON string

        $results = Book::all();
        //dump($results); # Shows an object of type Illuminate\Database\Eloquent\Collection that contains multiple Book objects

        $results = Book::where('published_year', '>', 1990)->get();
        //dump($results); # Shows an object of type Illuminate\Database\Eloquent\Collection that contains multiple Book objects

        # Even if our query finds just 1 result, *get* still yields a Collection, it'll just be a Collection of 1 object:
        $books = Book::where('title', '=', 'The Bell Jar')->get();
        foreach ($books as $book) {
            $book->title = 'abc';
            $book->save();
        }
        // dump($books); # Shows an object of type Illuminate\Database\Eloquent\Collection that contains 1 Book object

        # Similarly, if our query does not find any results, *get* still yields a Collection, it’ll just be empty
        $results = Book::where('author', '=', 'Amy Tan')->get();
        // dump($results); # Empty collection

        # Even if we limit our query to 1 book, because we're using the *get* method, we will get a Collection in return
        $results = Book::limit(1)->get();
    }

    /**
    * Demonstrating deleting
    */
    public function practice7()
    {
        # First get a book to delete
        $book = Book::where('author', '=', 'F. Scott Fitzgerald')->first();

        if (!$book) {
            dump('Did not delete- Book not found.');
        } else {
            $book->delete();
            dump('Deletion complete; check the database to see if it worked...');
        }
    }


    /**
    * Demonstrating updating
    */
    public function practice6()
    {
        # First get a book to update
        $book = Book::where('author', '=', 'F. Scott Fitzgerald')->first();

        if (!$book) {
            dump("Book not found, can not update.");
        } else {
            # Change some properties
            $book->title = 'The Really Great Gatsby';
            $book->published_year = '2025';

            # Save the changes
            $book->save();

            dump('Update complete; check the database to confirm the update worked.');
        }
    }


    /**
    * Demonstrating querying for a single row
    */
    public function practice5()
    {
        $book = Book::where('slug', '=', 'the-martian')->first();
        dump($book);
        dump($book->toArray());
    }


    /**
     * Demonstrating querying for multiple rows
     */
    public function practice4()
    {
        //$book = new Book();
        //$books = Book::where('title', 'LIKE', '%Harry Potter%')->get();
        $books = Book::where('title', 'LIKE', '%Harry Potter%')->where('published_year', '>=', 1998)->get();

        if ($books->isEmpty()) {
            dump('No matches found');
        } else {
            dump($books->toArray());
            
            foreach ($books as $book) {
                dump($book->title);
            }
        }
    }
    
    /**
     * Demonstrating adding a new row
     */
    public function practice3()
    {
        # Instantiate a new Book Model object
        $book = new Book();

        # Set the properties
        # Note how each property corresponds to a column in the table
        $book->slug = 'the-martian';
        $book->title = 'The Martian';
        $book->author = 'Anthony Weir';
        $book->published_year = 2011;
        $book->cover_url = 'https://hes-bookmark.s3.amazonaws.com/the-martian.jpg';
        $book->info_url = 'https://en.wikipedia.org/wiki/The_Martian_(Weir_novel)';
        $book->purchase_url = 'https://www.barnesandnoble.com/w/the-martian-andy-weir/1114993828';
        $book->description = 'The Martian is a 2011 science fiction novel written by Andy Weir. It was his debut novel under his own name. It was originally self-published in 2011; Crown Publishing purchased the rights and re-released it in 2014. The story follows an American astronaut, Mark Watney, as he becomes stranded alone on Mars in the year 2035 and must improvise in order to survive.';

        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data
        $book->save();

        dump('Added: ' . $book->title);
    }

    /**
     * Demonstrating using the Book Model
     */
    public function practice2()
    {
        // dump(Str::plural('mouse'));
        dump(Book::find(3));
        dump(Book::all()->toArray());
    }
    
    /**
     * First practice example
     */
    public function practice1()
    {
        dump('This is the first example.');
    }

    /**
     * ANY (GET/POST/PUT/DELETE)
     * /practice/{n?}
     * This method accepts all requests to /practice/ and
     * invokes the appropriate method.
     * http://e15bookmark.loc/practice => Shows a listing of all practice routes
     * http://e15bookmark.loc/practice/1 => Invokes practice1
     * http://e15bookmark.loc/practice/5 => Invokes practice5
     * http://e15bookmark.loc/practice/999 => 404 not found
     */
    public function index(Request $request, $n = null)
    {
        $methods = [];

        # Load the requested `practiceN` method
        if (!is_null($n)) {
            $method = 'practice' . $n; # practice1

            # Invoke the requested method if it exists; if not, throw a 404 error
            return (method_exists($this, $method)) ? $this->$method($request) : abort(404);
        } # If no `n` is specified, show index of all available methods
        else {
            # Build an array of all methods in this class that start with `practice`
            foreach (get_class_methods($this) as $method) {
                if (strstr($method, 'practice')) {
                    $methods[] = $method;
                }
            }

            # Load the view and pass it the array of methods
            return view('practice')->with(['methods' => $methods]);
        }
    }
}