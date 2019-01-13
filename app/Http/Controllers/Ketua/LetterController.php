<?php

namespace App\Http\Controllers\Ketua;

use DB;
use App\User;
use App\Periode;
use App\Letter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LetterController extends Controller
{
    public function getLetter(){
        $letters = Letter::select('letters.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','letters.periode_id')
        ->join('users','users.id','=','letters.user_id')
        ->get();

        return response()->json([
            'letters' => $letters
        ]);
    }

    public function showLetter($id){
        $letters = Letter::select('letters.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','letters.periode_id')
        ->join('users','users.id','=','letters.user_id')
        ->where('letters.id','=',$id)
        ->first();

        $response = [
            'letters' => $letters
        ];
        return response()->json($response);
    }
}
