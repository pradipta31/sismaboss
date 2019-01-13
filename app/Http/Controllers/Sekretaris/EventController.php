<?php

namespace App\Http\Controllers\Sekretaris;

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

    public function createEvent(Request $r){
        $this->validate($r,[
            'nama_event' => 'required',
            'ketua_panitia' => 'required',
            'deskripsi' => 'required',
        ]);

        $check = Event::where('nama_event', '=', $r->nama_event)->first();
        if($check == null){
            $event = Event::create([
                'periode_id' => auth()->user()->periode_id,
                'user_id' => auth()->user()->id,
                'nama_event' => $r->nama_event,
                'ketua_panitia' => $r->ketua_panitia,
                'tgl_mulai' => $r->tgl_mulai,
                'tgl_akhir' => $r->tgl_akhir,
                'deskripsi' => $r->deskripsi
            ]);
        }else{
            return response()->json([
                'error' => 'Event '.$r->nama_event.' Sudah ada'
            ]);
        }

        return response()->json([
            'message' => 'Event baru berhasil disimpan'
        ]);
    }

    public function showEvent($id){
        $events = Event::where('events.id','=',$id)->first();

        $response = [
            'events' => $events
        ];

        return response()->json($response);
    }

    public function editEvent($id){
        $events = Event::where('events.id','=',$id)->first();

        $response = [
            'events' => $events
        ];

        return response()->json($response);
    }

    public function updateEvent(Request $r, $id){
        $this->validate($r,[
            'nama_event' => 'required',
            'ketua_panitia' => 'required',
            'deskripsi' => 'required',
        ]);

        $events = Event::findOrFail($id)->update([
            'nama_event' => $r->nama_event,
            'ketua_panitia' => $r->ketua_panitia,
            'tgl_mulai' => $r->tgl_mulai,
            'tgl_akhir' => $r->tgl_akhir,
            'deskripsi' => $r->deskripsi
        ]);

        return response()->json([
            'message' => 'Data event berhasil diubah'
        ]);
    }

    public function deleteEvent($id){
        $events = Event::findOrFail($id)->delete();

        $response = [
            'message' => 'Berhasil menghapus data event yang dipilih'
        ];

        return response()->json($response);
    }
}
