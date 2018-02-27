<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Challenge;
use App\User;

class ChallengeController extends Controller
{
    public function postChallenge(Request $request, $userId)
    {
        $user = JWTAuth::parseToken()->toUser();

        $challenge = new Challenge();

        $challenge->numberOfBooks = $request->input('numberOfBooks');
        $userEmail = $request->input('userEmail');
        $idToSend = User::where('email', $userEmail)->get('id');
        $challenge->idOfReceiver = $idToSend;
        $challenge->idOfSender = $userId;
        $challenge->save();
        return response()->json(['challenge' => $challenge, 'user' => $user], 201); //ok

    }
}
