<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Book;

class BookController extends Controller
{
    protected $myKey = 'ZntQSMfAAObel84F0rbsA';

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
            echo $request->input('title');
            $book->save();
            return response()->json(['book' => $book, 'user' => $user], 201);

        }
        return response()->json(['book' => $request->input('title'), 'user' => $user], 201); //ok
    }

    public function getBooks()
    {
        $books = Book::all();
        foreach ($books as $book) {
            $this->bookId($book);
        }

        $response = [
            'books' => $books
        ];

        return response()->json($response, 200);
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
            $book->save();
        } else {
            $newBook = new Book;
            $newBook->idbook = $id;
            $newBook->title = $json->book->title;
            $newBook->bookAuthor = $json->authors->author->name;
            $newBook->average_rating = $json->book->average_rating;
            $newBook->description = $json->book->description;
            $newBook->save();
        }


    }

}
