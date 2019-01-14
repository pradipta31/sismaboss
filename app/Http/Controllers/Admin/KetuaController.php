<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Periode;
use App\User;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KetuaController extends Controller
{
    public function getPeriode(){
        $periodes = Periode::where('status', '=', 'nonaktif')->get();

        return response()->json([
            'periodes' => $periodes
        ]);
    }

    public function createKetua(Request $r){
        $this->validate($r,[
            'periode_id' => 'required',
            'name' => 'required',
            'nim' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $ketua = User::create([
            'periode_id' => $r->periode_id,
            'name' => $r->name,
            'username' => $r->username,
            'nim' => $r->nim,
            'email' => $r->email,
            'password' => bcrypt($r->password),
            'role' => 'ketua',
            'status' => '1'
        ]);

        $members = Member::create([
            'periode_id' => $r->periode_id,
            'name' => $r->name,
            'nim' => $r->nim
        ]);

        $periode = Periode::findOrFail($r->periode_id)->update([
            'status' => 'aktif'
        ]);

        return response()->json([
            'message' => 'Data Ketua baru berhasil disimpan'
        ]);
    }

    public function getKetua(){
        $ketuas = User::select('users.*','periodes.periode')
        ->join('periodes','periodes.id','=','users.periode_id')
        ->where('role','=','ketua')
        ->get();

        return response()->json([
            'ketuas' => $ketuas
        ]);
    }

    public function deleteKetua($id){
        $user = User::findOrFail($id);
        $periode = Periode::findOrFail($user->periode_id)->update([
            'status' => 'nonaktif'
        ]);
        $ketua = User::findOrFail($id)
        ->where('periode_id','=',$user->periode_id)
        ->delete();

        $response = [
            'message' => 'Berhasil menghapus data ketua yang dipilih'
        ];
        return response()->json($response);
    }

    public function showKetua($id){
        $users = User::select('users.*','periodes.periode')
        ->join('periodes','periodes.id','=','users.periode_id')
        ->where('users.id','=',$id)
        ->first();

        $response = [
            'user' => $users
        ];

        return response()->json($response);
    }

    public function editKetua($id){
        $users = User::find($id);

        return response()->json([
            'user' => $users
        ]);
    }

    public function updateKetua(Request $r, $id){
        $getUsers = User::findOrFail($id);
        $users = User::findOrFail($id)->update([
            'name' => $r->name,
            'username' => $r->username,
            'email' => $r->email,
            'nim' => $r->nim,
            'password' => bcrypt($r->password),
            'status' => $r->status
        ]);

        if($r->status == '0'){
            $users = User::where('periode_id','=',$getUsers->periode_id)->update([
                'status' => $r->status
            ]);
        }else{
            $users = User::where('periode_id','=',$getUsers->periode_id)->update([
                'status' => $r->status
            ]);
        }

        return response()->json([
            'message' => 'Update data ketua berhasil'
        ]);
    }
}
