<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Challenge;
use App\User;

class ChallengeController extends Controller
{
    public function postChallenge(Request $request)
    {
        $user = JWTAuth::parseToken()->toUser();

        $challenge = new Challenge();
        echo $request;
        echo $request->input('numberOfBooks') . "aDriu";
        $challenge->numberOfBooks = $request->input('numberOfBooks');
        $userEmail = $request->input('userEmail');

        $userToSend = User::where('email', $userEmail)->first();
        $user_id = $userToSend->id;
//        $neededUser = User::where('email', $userEmail)->get();
        $challenge->idOfReceiver = $user_id;

//        $challenge->idOfReceiver = $userToSend->id;
        $challenge->idOfSender = $user->id;
        $challenge->save();
        return response()->json(['challenge' => $challenge, 'user' => $user], 201); //ok

    }

    public function getChallenges($userId){
        $challenges = Challenge::where('idOfReceiver', $userId)->get();
        $response = [
            'challenges' => $challenges
        ];
        return response()->json($response, 200);
    }

    public function deleteChallenge($id)
    {
        $challenge = Challenge::all()->find($id);
        $challenge->delete();
        return response()->json(['message' => 'Challenge deleted'], 200);
    }
}
