<?php

namespace App\Http\Controllers\Sekretaris;

use DB;
use App\User;
use App\Periode;
use App\Member;
use App\FileMember;
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

    public function createMember(Request $r){
        $this->validate($r,[
            'anggota.*.nim' => 'required',
            'anggota.*.nama' => 'required',
            'anggota.*.handphone' => 'required'
        ]);
        
        DB::transaction(function() use($r){
            foreach ($r->anggota as $anggota) {
                $members = Member::create([
                    'periode_id' => auth()->user()->periode_id,
                    'user_id' => auth()->user()->id,
                    'nim' => $anggota['nim'],
                    'nama' => $anggota['nama'],
                    'handphone' => $anggota['handphone']
                ]);
            }
        });
        
        return response()->json([
            'message' => 'Data anggota baru berhasil di tambahkan'
        ]);
    }

    public function showMember($id){
        $members = Member::select('members.*','periodes.periode')
        ->join('periodes','periodes.id','=','members.periode_id')
        ->where('members.id','=',$id)
        ->first();

        $response = [
            'members' => $members
        ];

        return response()->json($response);
    }

    public function editMember($id){
        $members = Member::select('members.*','periodes.periode')
        ->join('periodes','periodes.id','=','members.periode_id')
        ->where('members.id','=',$id)
        ->first();

        $response = [
            'members' => $members
        ];

        return response()->json($response);
    }

    public function updateMember(Request $r, $id){
        $members = Member::findOrFail($id)->update([
            'user_id' => auth()->user()->id,
            'nama' => $r->nama,
            'nim' => $r->nim,
            'handphone' => $r->handphone
        ]);

        return response()->json([
            'message' => 'Data anggota berhasil diubah'
        ]);
    }

    public function deleteMember($id){
        $members = Member::findOrFail($id)->delete();

        $response = [
            'message' => 'Berhasil menghapus data member yang dipilih'
        ];

        return response()->json($response);
    }
}
