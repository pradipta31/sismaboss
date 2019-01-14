<?php

namespace App\Http\Controllers\Sekretaris;

use DB;
use App\Periode;
use App\User;
use App\Inventory;
use Image;
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
        $filename = time() . '.' . $r->file('pict')->getClientOriginalExtension();
        Image::make($r->file('pict'))->save(public_path('/images/inventaris/'.$filename));
        $invents = Inventory::create([
            'periode_id' => auth()->user()->periode_id,
            'nama' => $r->nama,
            'penanggung_jawab' => $r->penanggung_jawab,
            'pict' => $filename,
            'keterangan' => $r->keterangan
        ]);

        return response()->json([
            'message' => 'Data inventaris baru berhasil ditambahkan'
        ]);
    }

    public function showInventaris($id){
        $inventaris = Inventory::where('inventories.id','=',$id)->first();

        $response = [
            'inventaris' => $inventaris
        ];

        return response()->json($response);
    }

    public function editInventaris($id){
        $inventories = Inventory::where('inventories.id','=',$id)->first();

        $response = [
            'inventories' => $inventories
        ];

        return response()->json($response);
    }

    public function updateInventaris(Request $r, $id){
        $this->validate($r,[
            'nama' => 'required',
            'penanggung_jawab' => 'required',
            'keterangan' => 'required'
        ]);

        $invents = Inventory::findOrFail($id)->update([
            'nama' => $r->nama,
            'penanggung_jawab' => $r->penanggung_jawab,
            'keterangan' => $r->keterangan
        ]);
        
        return response()->json([
            'message' => 'Data inventaris berhasil diubah'
        ]);
    }

    public function deleteInventaris($id){
        $invents = Inventory::findOrFail($id)->delete();

        $response = [
            'message' => 'Berhasil menghapus data inventaris yang dipilih'
        ];

        return response()->json($response);
    }
}
