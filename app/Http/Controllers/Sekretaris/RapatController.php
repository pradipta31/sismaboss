<?php

namespace App\Http\Controllers\Sekretaris;

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

    public function createRapat(Request $r){
        $this->validate($r,[
            'judul_rapat' => 'required',
            'tgl_rapat' => 'required',
            'hasil_rapat' => 'required',
            'moderator' => 'required',
            'jumlah_hadir' => 'required'
        ]);

        $periode = Meeting::create([
            'periode_id' => auth()->user()->periode_id,
            'user_id' => auth()->user()->id,
            'judul_rapat' => $r->judul_rapat,
            'tgl_rapat' => $r->tgl_rapat,
            'hasil_rapat' => $r->hasil_rapat,
            'moderator' => $r->moderator,
            'jumlah_hadir' => $r->jumlah_hadir
        ]);

        return response()->json([
            'message' => 'Periode baru berhasil disimpan'
        ]);
    }

    public function showRapat($id){
        $meetings = Meeting::where('meetings.id','=',$id)->first();

        $response = [
            'meetings' => $meetings
        ];

        return response()->json($response);
    }

    public function editRapat($id){
        $rapats = Meeting::where('meetings.id','=',$id)->first();

        $response = [
            'rapats' => $rapats
        ];

        return response()->json($response);
    }

    public function updateRapat(Request $r, $id){
        $this->validate($r,[
            'judul_rapat' => 'required',
            'tgl_rapat' => 'required',
            'hasil_rapat' => 'required',
            'moderator' => 'required',
            'jumlah_hadir' => 'required'
        ]);

        $meetings = Meeting::findOrFail($id)->update([
            'judul_rapat' => $r->judul_rapat,
            'tgl_rapat' => $r->tgl_rapat,
            'hasil_rapat' => $r->hasil_rapat,
            'moderator' => $r->moderator,
            'jumlah_hadir' => $r->jumlah_hadir
        ]);

        return response()->json([
            'message' => 'Data rapat berhasil diubah'
        ]);
    }

    public function deleteRapat($id){
        $meetings = Meeting::findOrFail($id)->delete();

        $response = [
            'message' => 'Berhasil menghapus data rapat yang dipilih'
        ];

        return response()->json($response);
    }
}
