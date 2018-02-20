<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Quote;

class QuoteController extends Controller
{

    public function postQuote(Request $request)
    {
//        if(! $user = JWTAuth::parseToken()->authenticate()){
//            // we dont have a user
//            return response()->json([
//                'message' => 'User not fount'
//            ],404);
//        }
        $user = JWTAuth::parseToken()->toUser();
        $quote = new Quote();
        $quote->content = $request->input('content');
        $quote->userId = $user->id;
        $quote->save();
        return response()->json(['quote' => $quote, 'user' => $user], 201); //ok

    }

    public function getQuotes()
    {
        $quotes = Quote::all();
        $response = [
            'quotes' => $quotes
        ];
        return response()->json($response, 200);
    }


    public function putQuote(Request $request, $id)
    {
        $quote = Quote::all()->find($id);
        if (!$quote) {
            return response()->json(['message' => 'Document not found']);
        }
        $quote->content = $request->input('content');
        $quote->save();
        return response()->json(['quote' => $quote], 200);

    }


    public function deleteQuote($id)
    {
        $quote = Quote::all()->find($id);
        $quote->delete();
        return response()->json(['message' => 'Quote deleted'], 200);
    }
}