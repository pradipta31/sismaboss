<?php

namespace App\Http\Controllers\Bendahara;

use Carbon\Carbon;
use DB;
use App\Fund;
use App\User;
use App\Periode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KeuanganController extends Controller
{
    public function getKeuangan(){
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

    public function createKeuangan(Request $r){
        $this->validate($r,[
            'jenis' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
            'keterangan' => 'required'
        ]);

        $funds = Fund::create([
            'periode_id' => auth()->user()->periode_id,
            'user_id' => auth()->user()->id,
            'jenis' => $r->jenis,
            'tanggal' => $r->tanggal,
            'nominal' => $r->nominal,
            'keterangan' => $r->keterangan
        ]);

        return response()->json([
            'message' => 'Data keuangan baru berhasil disimpan'
        ]);
    }

    public function getResult(){
        $cek = Fund::where('saldo','!=',null)
        ->whereBetween('funds.tanggal',[Carbon::now()->format('Y').'-'.Carbon::now()->format('m').'-01',
        Carbon::now()])
        ->get();

        // if(!$cek == null){
            $debits = Fund::select('funds.*','periodes.periode','users.username')
            ->select(DB::raw('SUM(nominal) AS debit'))
            ->join('periodes','periodes.id','=','funds.periode_id')
            ->join('users','users.id','=','funds.user_id')
            ->where('funds.jenis','debit')
            ->where('users.periode_id',auth()->user()->periode_id)
            ->whereBetween('funds.tanggal',[Carbon::now()->format('Y').'-'.Carbon::now()->format('m').'-01',
            Carbon::now()])
            ->first();

            $kredits = Fund::select('funds.*','periodes.periode','users.username')
            ->select(DB::raw('SUM(nominal) AS kredit'))
            ->join('periodes','periodes.id','=','funds.periode_id')
            ->join('users','users.id','=','funds.user_id')
            ->where('funds.jenis','=','kredit')
            ->where('users.periode_id','=',auth()->user()->periode_id)
            ->whereBetween('funds.tanggal',[Carbon::now()->format('Y').'-'.Carbon::now()->format('m').'-01',
            Carbon::now()])
            ->first();

            $results = $debits->debit - $kredits->kredit; 
            
            return response()->json([
                'debits' => $debits,
                'kredits' => $kredits,
                'results' => $results
            ]);
        // }else{
        //     return response()->json([
        //         'error' => 'Saldo bulanan sudah ada pada bulan ini'
        //     ]);
        // }
    }

    public function createSaldo(Request $r){
        $this->validate($r,[
            'debit' => 'required',
            'kredit' => 'required',
            'saldo' => 'required',
            'keterangan' => 'required'
        ]);
        // $cek = Fund::where('saldo','!=',null)
        // ->whereBetween('funds.tanggal',[Carbon::now()->format('Y').'-'.Carbon::now()->format('m').'-01',
        // Carbon::now()])
        // ->get();

        // if(!$cek){
            $funds = Fund::create([
                'periode_id' => auth()->user()->periode_id,
                'user_id' => auth()->user()->id,
                'debit' => $r->debit,
                'kredit' => $r->kredit,
                'saldo' => $r->saldo,
                'keterangan' => $r->keterangan
            ]);
            return response()->json([
                'message' => 'Data saldo baru berhasil disimpan'
            ]);
        // }else{
        //     return response()->json([
        //         'error' => 'Data saldo bulan ini sudah ada'
        //     ]);
        // }
        
    }

    public function editKeuangan($id){
        $funds = Fund::where('funds.id','=',$id)->first();

        $response = [
            'funds' => $funds
        ];

        return response()->json($response);
    }

    public function updateKeuangan(Request $r, $id){
        $funds = Fund::findOrFail($id)->update([
            'periode_id' => auth()->user()->periode_id,
            'user_id' => auth()->user()->id,
            'jenis' => $r->jenis,
            'tanggal' => $r->tanggal,
            'nominal' => $r->nominal,
            'keterangan' => $r->keterangan
        ]);

        return response()->json([
            'message' => 'Data saldo baru berhasil disimpan'
        ]);
    }

    public function deleteKeuangan($id){
        $funds = Fund::findOrFail($id)->delete();

        $response = [
            'message' => 'Berhasil menghapus data keuangan yang dipilih'
        ];

        return response()->json($response);
    }
}
