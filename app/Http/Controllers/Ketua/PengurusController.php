<?php

namespace App\Http\Controllers\Ketua;

use DB;
use App\Periode;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengurusController extends Controller
{
    public function getPengurus(){
        $admins = User::where('role','!=','ketua')
        ->where('role','!=','admin')
        ->where('periode_id','=',auth()->user()->periode_id)
        ->get();

        return response()->json([
            'admins' => $admins
        ]);
    }

    public function createPengurus(Request $r){
        $this->validate($r,[
            'role' => 'required',
            'name' => 'required',
            'nim' => 'required',
            'username' => 'required|max:15',
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        $users = User::where('id','=',auth()->user()->id)->first();
        $checkEmail = User::where('email','=',$r->email)
        ->first();
        $checkNim = User::where('nim','=',$r->nim)->first();
        $checkUsername = User::where('username', '=', $r->username)->first();
        $role = User::where('role', '=', $r->role)
        ->where('periode_id','=', $users->periode_id)
        ->get();
        
        if($role->count() < 2){
            if($checkUsername == null){
                if($checkNim == null){
                    if($checkEmail == null){
                        $ketua = User::create([
                            'periode_id' => $users->periode_id,
                            'role' => $r->role,
                            'name' => $r->name,
                            'username' => $r->username,
                            'nim' => $r->nim,
                            'email' => $r->email,
                            'password' => bcrypt($r->password),
                            'status' => '1'
                        ]);
                    }else{
                        return response()->json([
                            'error' => 'Data Email '.$r->email.' Sudah ada'
                        ]);    
                    }
                }else{
                    return response()->json([
                        'error' => 'Data NIM '.$r->nim.' Sudah ada'
                    ]);  
                }
            }else{
                return response()->json([
                    'error' => 'Data Username '.$r->username.' Sudah ada'
                ]);  
            }
        }else{
            return response()->json([
                'error' => 'Jabatan '.$r->role.' sudah melebihi batas'
            ]);  
        }

        return response()->json([
            'message' => 'Data Pengurus baru berhasil disimpan'
        ]);
    }

    public function showPengurus($id){
        $admins = User::where('users.id','=',$id)->first();

        $response = [
            'admins' => $admins
        ];

        return response()->json($response);
    }

    public function editPengurus($id){
        $users = User::find($id);

        return response()->json([
            'user' => $users
        ]);
    }

    public function updatePengurus(Request $r,$id){
        if($r->password == null){
            $users = User::findOrFail($id)->update([
                'role' => $r->role,
                'name' => $r->name,
                'username' => $r->username,
                'email' => $r->email,
                'nim' => $r->nim
            ]);
        }else{
            $users = User::findOrFail($id)->update([
                'role' => $r->role,
                'name' => $r->name,
                'username' => $r->username,
                'email' => $r->email,
                'nim' => $r->nim,
                'password' => bcrypt($r->password)
            ]);
        }

        return response()->json([
            'message' => 'Update data ketua berhasil'
        ]);
    }

    public function deletePengurus($id){
        $user = User::findOrFail($id)->delete();

        $response = [
            'message' => 'Berhasil menghapus data pengurus yang dipilih'
        ];

        return response()->json($response);
    }
}
