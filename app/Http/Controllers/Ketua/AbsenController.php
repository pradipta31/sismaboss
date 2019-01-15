<?php

namespace App\Http\Controllers\Ketua;

use DB;
use App\Periode;
use App\User;
use App\Absen;
use App\Member;
use App\AbsentDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsenController extends Controller
{
    public function getAbsen(){
        $absents = Absen::select('absents.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','absents.periode_id')
        ->join('users','users.id','=','absents.user_id')
        ->where('users.periode_id','=',auth()->user()->periode_id)
        ->get();

        return response()->json([
            'absents' => $absents
        ]);
    }

    public function showAbsen($id){
        $absents = Absen::where('absents.id','=',$id)->first();

        $response = [
            'absents' => $absents
        ];

        return response()->json($response);
    }

    public function lihatAbsen($id){
        $absents = AbsentDetail::select('absent_details.id','members.nim','members.name')
        ->join('members','members.id','=','absent_details.member_id')
        ->where('absent_id','=',$id)
        ->get();

        $response = [
            'absents' => $absents
        ];

        return response()->json($response);
    }
}
