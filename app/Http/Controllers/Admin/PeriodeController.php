<?php

namespace App\Http\Controllers\Admin;

use App\Periode;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeriodeController extends Controller
{
    public function getPeriode(){
        $periodes = Periode::all();

        return response()->json([
            'periodes' => $periodes
        ]);
    }

    public function createPeriode(Request $r){
        $this->validate($r,[
            'periode' => 'required|max:9'
        ]);

        $periode = Periode::create([
            'periode' => $r->periode
        ]);

        return response()->json([
            'message' => 'Periode baru berhasil disimpan'
        ]);
    }

    public function editPeriode($id){
        $periodes = Periode::find($id);
        return response()->json([
            'periodes' => $periodes
        ]);
    }

    public function updatePeriode(Request $r, $id){
        $this->validate($r,[
            'periode' => 'required|max:9'
        ]);

        $periode = Periode::findOrFail($id)->update([
            'periode' => $r->periode,
            'status' => $r->status
        ]);

        if($r->status == 'aktif'){
            $status = '1';
        }else{
            $status = '0';
        }

        $users = User::where('periode_id', '=', $id)
        ->update([
            'status' => $status
        ]);
        
        return response()->json([
            'message' => 'Periode berhasil diubah'
        ]);
    }

    public function deletePeriode(Request $r){
        $periode = Periode::findOrFail($r->id)->delete();
        $response = [
            'message' => 'Berhasil menghapus data periode yang dipilih'
        ];
        return response()->json($response);
    }

    
}
