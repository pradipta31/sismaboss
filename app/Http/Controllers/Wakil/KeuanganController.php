<?php

namespace App\Http\Controllers\Wakil;

use DB;
use App\Fund;
use App\User;
use App\Periode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KeuanganController extends Controller
{
    public function getData(){
        $funds = Fund::select('funds.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','funds.periode_id')
        ->join('users','users.id','=','funds.user_id')
        ->orderBy('funds.tanggal','ASC')
        ->where('users.periode_id','=',auth()->user()->periode_id)
        ->get();

        $saldo = 0;
        $data = [];
        foreach($funds as $key => $f){
            if($f->jenis == 'Debit'){
                $saldo += $f->nominal;
            }else{
                $saldo -= $f->nominal;
            }
            $data[$key] = [
                'debit' => $f->jenis == 'Debit' ? $f->nominal : 0,
                'kredit' => $f->jenis == 'Kredit' ? $f->nominal : 0,
                'saldo' => $saldo,
                'id' => $f->id,
                'tanggal' => $f->tanggal,
                'created_at' => $f->created_at,
                'keterangan' => $f->keterangan,
                'username' => $f->username
            ];
        }

        return response()->json([
            'funds' => $data,
        ]);
    }
}
