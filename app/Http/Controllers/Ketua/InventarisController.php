<?php

namespace App\Http\Controllers\Ketua;

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

    public function showInventaris($id){
        $inventaris = Inventory::where('inventories.id','=',$id)->first();

        $response = [
            'inventaris' => $inventaris
        ];

        return response()->json($response);
    }
}
