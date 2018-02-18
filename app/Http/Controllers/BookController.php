<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function postBook(Request $request){
        $book = new Book();
        $book->title = $request->input('title');
        echo $request->input('title');
        $book->save();
        return response()->json(['book' => $book], 201); //ok
    }

    public function getBooks()
    {
        $books = Book::all();
//        foreach ($books as $book){
//            foreach ($book->authors as $author) {
//                $url = 'https://www.goodreads.com/book/title.xml?author=' . $author->fullName . '&key=ZntQSMfAAObel84F0rbsA&title=' . $book->title;
//                $json = $this->XMLtoJSON($url);
//                $book->title = $json->book->title;
//                $book->bookAuthor = $json->authors->name;
//                $book->save();
//            }
//        }

        $response = [
            'books' => $books
        ];

        return response()->json($response,200);

    }

}
