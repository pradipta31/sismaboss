<?php

namespace App\Http\Controllers\Sekretaris;

use DB;
use App\Periode;
use App\User;
use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InventarisController extends Controller
{
    public function getInventaris(){
        $inventories = Inventory::select('inventories.*','periodes.periode')
        ->join('periodes','periodes.id','=','inventories.periode_id')
        ->where('inventories.periode_id','=',auth()->user()->periode_id)
        ->get();

        return response()->json([
            'inventories' => $inventories
        ]);
    }

    public function createInventaris(Request $r){
        $this->validate($r,[
            'nama' => 'required',
            'penanggung_jawab' => 'required',
            'keterangan' => 'required'
        ]);

        $invents = Inventory::create([
            'periode_id' => auth()->user()->periode_id,
            'nama' => $r->nama,
            'penanggung_jawab' => $r->penanggung_jawab,
            'keterangan' => $r->keterangan
        ]);

        return response()->json([
            'message' => 'Data inventaris baru berhasil ditambahkan'
        ]);
    }
}
