<?php

namespace App\Http\Controllers\Sekretaris;

use DB;
use App\Periode;
use App\User;
use App\Absen;
use App\Member;
use App\AbsentDetail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsenController extends Controller
{
    public function getAbsen(){
        $absents = Absen::select('absents.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','absents.periode_id')
        ->join('users','users.id','=','absents.user_id')
        ->where('users.periode_id','=',auth()->user()->periode_id)
        ->get();

        return response()->json([
            'absents' => $absents
        ]);
    }

    public function createAbsen(Request $r){
        $this->validate($r,[
            'judul_absen' => 'required',
            'deskripsi' => 'required',
        ]);

        $absent = Absen::create([
            'periode_id' => auth()->user()->periode_id,
            'user_id' => auth()->user()->id,
            'judul_absen' => $r->judul_absen,
            'deskripsi' => $r->deskripsi
        ]);

        return response()->json([
            'message' => 'Absen baru berhasil disimpan'
        ]);
    }

    public function showAbsen($id){
        $absents = Absen::where('absents.id','=',$id)->first();

        $response = [
            'absents' => $absents
        ];

        return response()->json($response);
    }

    public function editAbsen($id){
        $absents = Absen::where('absents.id','=',$id)->first();

        $response = [
            'absents' => $absents
        ];

        return response()->json($response);
    }

    public function updateAbsen(Request $r, $id){
        $this->validate($r,[
            'judul_absen' => 'required',
            'deskripsi' => 'required',
        ]);

        $absents = Absen::findOrFail($id)->update([
            'judul_absen' => $r->judul_absen,
            'deskripsi' => $r->deskripsi
        ]);

        return response()->json([
            'message' => 'Data absen berhasil diubah'
        ]);
    }

    public function deleteAbsen($id){
        $absents = Absen::findOrFail($id)->delete();

        $response = [
            'message' => 'Berhasil menghapus data absen yang dipilih'
        ];

        return response()->json($response);
    }

    // TAMBAH ABSEN

    public function getAbsenT($id){
        $absents = AbsentDetail::select('absent_details.id','members.nim','members.name')
        ->join('members','members.id','=','absent_details.member_id')
        ->where('absent_id','=',$id)
        ->get();

        $response = [
            'absents' => $absents
        ];

        return response()->json($response);
    }

    public function createAbsenT(Request $r, $id){
        $this->validate($r,[
            'nim' => 'required|exists:members,nim'
        ]);
        $members = Member::where('nim','=',$r->nim)->first();
        $absent = AbsentDetail::where('member_id','=',$members->id)
        ->where('absent_id','=',$id)
        ->first();
        if($absent == null){
            $absents = AbsentDetail::create([
                'absent_id' => $id,
                'member_id' => $members->id
            ]);
            return response()->json([
                'message' => 'Berhasil menambah absen'
            ]);
        }else{
            return response()->json([
                'error' => 'Anggota sudah di absen'
            ]);
        }
    }

    public function deleteAbsenT($id){
        $absents = AbsentDetail::where('id','=',$id)->delete();

        return response()->json([
            'message' => 'Berhasil menghapus data absen anggota'
        ]);
    }

    public function download($periode_id){
        $spreadsheet = new Spreadsheet();

        $absents = AbsentDetail::select('absent_details.id','members.nim','members.name','members.periode_id')
        ->join('members','members.id','=','absent_details.member_id')
        ->where('members.periode_id','=',$periode_id)
        ->get();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'NAMA');
        $row = 2;
        $nomor = 1;
        foreach($absents as $absent){
            $sheet->setCellValue('A'.$row,$nomor++);
            $sheet->setCellValue('B'.$row,$absent->nim);
            $sheet->setCellValue('C'.$row,$absent->name);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('download.xlsx');
        return response()->download(public_path('download.xlsx'))->deleteFileAfterSend();
    }
}
