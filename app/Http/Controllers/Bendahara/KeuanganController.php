<?php

namespace App\Http\Controllers\Bendahara;

use Carbon\Carbon;
use DB;
use App\Fund;
use App\User;
use App\Periode;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

    public function download($periode_id){
        $spreadsheet = new Spreadsheet();

        $funds = Fund::select('funds.*', 'periodes.periode','users.username')
        ->join('periodes', 'periodes.id', '=', 'funds.periode_id')
        ->join('users', 'users.id', '=', 'funds.user_id')
        ->where('funds.periode_id', '=', $periode_id)
        ->get();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'TANGGAL');
        $sheet->setCellValue('C1', 'KETERANGAN');
        $sheet->setCellValue('D1', 'DEBIT');
        $sheet->setCellValue('E1', 'KREDIT');
        $sheet->setCellValue('F1', 'SALDO');
        $sheet->setCellValue('G1', 'PJ');
        $row = 2;
        $total = 0;
        $nomor = 1;
        foreach($funds as $fund){
            $total += $fund->jenis == 'Debit' ? $fund->nominal : 0;
            $total -= $fund->jenis == 'Kredit' ? $fund->nominal : 0;
            $sheet->setCellValue('A'.$row,$nomor++);
            $sheet->setCellValue('B'.$row,$fund->created_at);
            $sheet->setCellValue('C'.$row,$fund->keterangan);
            $sheet->setCellValue('D'.$row,$fund->jenis == 'Debit' ? $fund->nominal : 0);
            $sheet->setCellValue('E'.$row,$fund->jenis == 'Kredit' ? $fund->nominal : 0);
            $sheet->setCellValue('F'.$row,$total);
            $sheet->setCellValue('G'.$row,$fund->username);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('download.xlsx');
        return response()->download(public_path('download.xlsx'))->deleteFileAfterSend();
    }
}
