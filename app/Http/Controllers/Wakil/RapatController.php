<?php

namespace App\Http\Controllers\Wakil;

use DB;
use App\Periode;
use App\User;
use App\Meeting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RapatController extends Controller
{
    public function getRapat(){
        $meetings = Meeting::select('meetings.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','meetings.periode_id')
        ->join('users','users.id','=','meetings.user_id')
        ->where('users.periode_id','=',auth()->user()->periode_id)
        ->get();

        return response()->json([
            'meetings' => $meetings
        ]);
    }

    public function showRapat($id){
        $meetings = Meeting::where('meetings.id','=',$id)->first();

        $response = [
            'meetings' => $meetings
        ];

        return response()->json($response);
    }
}
