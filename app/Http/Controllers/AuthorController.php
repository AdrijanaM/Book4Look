<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Author;

class AuthorController extends Controller
{

    protected $myKey = 'ZntQSMfAAObel84F0rbsA';

    public function XMLtoJSON($url)
    {
        $fileContents = file_get_contents($url);
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents);
//        $json = json_decode($simpleXml);
        return $simpleXml;
    }

    public function postAuthor(Request $request)
    {
        $user = JWTAuth::parseToken()->toUser();
        $author = new Author();
        $authors = Author::all();
        if (!$authors->contains('fullName', $request->input('fullName'))) {
            $author->fullName = $request->input('fullName');
            $author->userId = $user->id;
            $author->save();
            $this->authorId($author);
//            return response()->json(['author' => $author, 'user' => $user], 201); //ok
        }
        return response()->json(['author' => $request->input('fullName'), 'user' => $user], 201); //ok
    }

    public function getAuthors($userId)
    {
        $authors = Author::where('userId', $userId)->get();
        foreach ($authors as $author) {
//            if ($book->description === '') {
            $author::where('about', '')->delete();
//            }
        }

        $authors = Author::all();

        $response = [
            'authors' => $authors
        ];

        return response()->json($response, 200);
    }

    public function getSearchedAuthor($fullName)
    {
        $user = JWTAuth::parseToken()->toUser();
        $author = Author::where('fullName', $fullName)->first();
        if (empty($author)) {
            $author = new Author();
            $author->fullName = $fullName;
            $author->userId = $user->id;
            $author->save();
            $this->authorId($author);
        }


        $response = [
            'author' => $author
        ];
        return response()->json($response, 200);
    }
    public function authorId($author)
    {
        $authorName = $author->fullName;
//        echo $authorName;
        $url = 'https://www.goodreads.com/api/author_url/' . $authorName . '?key=ZntQSMfAAObel84F0rbsA';
        $json = $this->XMLtoJSON($url);
        $id = $json->author['id'];
        $author->idAuthor = $id;
        $author->save();

        $this->authorInfo($id);
    }

    public function authorInfo($id)
    {
        $url = 'https://www.goodreads.com/author/show/' . $id . '?&key=ZntQSMfAAObel84F0rbsA';
        $json = $this->XMLtoJSON($url);
//        echo $json->author->about;
        $author = Author::where('idAuthor', $id)->first();
//        echo "\n";
        if (!empty($author)) {
            $author->gender = $json->author->gender;
            $author->worksCount = $json->author->works_count;
            $author->about = $json->author->about;
            $author->save();
        } else {
            $newAuthor = new Author;
            $newAuthor->idAuthor = $id;
            $newAuthor->gender = $json->author->gender;
            $newAuthor->fullName = $json->author->name;
            $newAuthor->about = $json->author->about;
            $newAuthor->worksCount = $json->author->works_count;
            $newAuthor->save();
        }
    }

}
