<?php

namespace App\Http\Controllers;

use Image;
use DB;
use App\Periode;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile(){
        $users = User::where('users.id','=',auth()->user()->id)->first();

        return response()->json([
            'users' => $users
        ]);
    }

    public function updateProfile(Request $r,$id){
        if($r->password == null){
            $users = User::findOrFail($id)->update([
                'name' => $r->name,
                'username' => $r->username,
                'email' => $r->email,
                'nim' => $r->nim,
                'tgl_lahir' => $r->tgl_lahir,
                'jenis_kelamin' => $r->jenis_kelamin,
                'alamat' => $r->alamat,
                'no_telp' => $r->no_telp
            ]);
        }else{
            $users = User::findOrFail($id)->update([
                'name' => $r->name,
                'username' => $r->username,
                'email' => $r->email,
                'nim' => $r->nim,
                'tgl_lahir' => $r->tgl_lahir,
                'password' => bcrypt($r->password),
                'jenis_kelamin' => $r->jenis_kelamin,
                'alamat' => $r->alamat,
                'no_telp' => $r->no_telp
            ]);
        }

        return response()->json([
            'message' => 'Profile anda berhasil diubah'
        ]);
    }

    public function updateAvatar(Request $r){
        $user = User::findOrFail(auth()->user()->id);

        $pict = $r->file('pict');
        $file = time().'.'.$pict->getClientOriginalExtension();
        $path = 'images/avatar';
        $pict->storeAs($path,$file,'public');
        if ($r->file('pict')->isValid()) {
            $user->update([
                'pict' => $file
            ]);
        }
        return response()->json([
            'message' => 'Foto profil berhasil diubah'
        ]);
    }

    public function showProfile($id){
        $users = User::where('id','=',$id);

        $response = [
            'users' => $users
        ];
        return response()->json($response);
    }
}
