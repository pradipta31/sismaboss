<?php

namespace App\Http\Controllers\Wakil;

use DB;
use App\User;
use App\Periode;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function getMember(){
        $members = Member::select('members.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','members.periode_id')
        ->join('users','users.id','=','members.user_id')
        ->where('users.periode_id','=',auth()->user()->periode_id)
        ->get();

        return response()->json([
            'members' => $members
        ]);
    }
}
