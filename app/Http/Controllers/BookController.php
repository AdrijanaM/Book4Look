<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Book;

class BookController extends Controller
{
    protected $myKey = 'ZntQSMfAAObel84F0rbsA';

//    protected $idOfCurentUser;

    public function XXMLtoJSON($url)
    {
        $fileContents = file_get_contents($url);
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents);
//        $json = json_encode($simpleXml);
        return $simpleXml;
    }

    public function postBook(Request $request)
    {
        $user = JWTAuth::parseToken()->toUser();
        $book = new Book();
        $books = Book::all();
        if (!$books->contains('title', $request->input('title'))) {
            $book->title = $request->input('title');
            $book->userId = $user->id;
            $book->save();
            $this->bookId($book);
        }
        return response()->json(['book' => $request->input('title'), 'user' => $user], 201); //ok
    }

    public function getBooks($userId)
    {
        $books = Book::where('userId', $userId)->get();

        foreach ($books as $book) {
            $book::where('description', '')->delete();
        }

        $response = [
            'books' => $books
        ];
        return response()->json($response, 200);
    }
    public function getFavBooks($userId)
    {
        $books = Book::where('userId', $userId)->get();
        $favBooks = [];
        foreach ($books as $book) {
           $favBooks =  $book::where('addToFav', 1)->get();
        }

        $response = [
            'books' => $favBooks
        ];
        return response()->json($response, 200);
    }

    public function getSearchedBook($title)
    {
        $user = JWTAuth::parseToken()->toUser();
        $book = Book::where('title', $title)->first();
        if (empty($book)) {
            $book = new Book();
            $book->title = $title;
            $book->userId = $user->id;
            $book->save();
            $this->bookId($book);
        }
        $response = [
            'book' => $book
        ];
        return response()->json($response, 200);
    }

    public function updateBook( $id)
    {
        $book = Book::all()->find($id);
        $book->addToFav = 1;
        $book->save();
        return response()->json(['book' => $book], 200);
    }

    public function bookId($book)
    {
        $bookTitle = $book->title;
        $url = 'https://www.goodreads.com/search/index.xml?key=' . $this->myKey . '&q=' . $bookTitle;
        $json = $this->XXMLtoJSON($url);
        $id = $json->search->results->work->best_book->id;
        $book->idBook = $id;
        $book->bookAuthor = $json->search->results->work->best_book->author->name;
        $book->save();
        $this->bookInfo($id);
    }

    public function bookInfo($id)
    {
        $url = 'https://www.goodreads.com/book/show/' . $id . '.xml?key=' . $this->myKey;
        $json = $this->XXMLtoJSON($url);
        $book = Book::where('idbook', $id)->first();
//        echo "\n";
        if (!empty($book)) {
            $book->average_rating = $json->book->average_rating;
            $book->description = $json->book->description;
            $book->image = $json->book->image_url;
            $book->addToFav = 0;
            $book->save();
        } else {
            $newBook = new Book;
            $newBook->idbook = $id;
            $newBook->title = $json->book->title;
            $newBook->bookAuthor = $json->authors->author->name;
            $newBook->average_rating = $json->book->average_rating;
            $newBook->description = $json->book->description;
            $book->image = $json->book->image_url;
            $book->addToFav = 0;
            $newBook->save();
        }

    }

}
