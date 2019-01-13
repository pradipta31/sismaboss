<?php

namespace App\Http\Controllers\Ketua;

use DB;
use App\Periode;
use App\User;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function getEvent(){
        $events = Event::select('events.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','events.periode_id')
        ->join('users','users.id','=','events.user_id')
        ->where('users.periode_id','=',auth()->user()->periode_id)
        ->get();

        return response()->json([
            'events' => $events
        ]);
    }

    public function showEvent($id){
        $events = Event::where('events.id','=',$id)->first();

        $response = [
            'events' => $events
        ];

        return response()->json($response);
    }
}
