<?php

namespace App\Http\Controllers\Sekretaris;

use DB;
use App\User;
use App\Periode;
use App\Member;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function getMember(){
        $members = Member::select('members.*','periodes.periode')
        ->join('periodes','periodes.id','=','members.periode_id')
        ->where('members.periode_id','=',auth()->user()->periode_id)
        ->get();

        return response()->json([
            'members' => $members
        ]);
    }

    public function createMember(Request $r){
        $this->validate($r,[
            'anggota.*.nim' => 'required',
            'anggota.*.name' => 'required',
        ]);

        DB::transaction(function() use($r){
            foreach ($r->anggota as $anggota) {
                $members = Member::create([
                    'periode_id' => auth()->user()->periode_id,
                    'user_id' => auth()->user()->id,
                    'nim' => $anggota['nim'],
                    'name' => $anggota['name'],
                    'handphone' => $anggota['handphone']
                ]);
            }
        });

        return response()->json([
            'message' => 'Data anggota baru berhasil di tambahkan'
        ]);
    }

    public function showMember($id){
        $members = Member::select('members.*','periodes.periode')
        ->join('periodes','periodes.id','=','members.periode_id')
        ->where('members.id','=',$id)
        ->first();

        $response = [
            'members' => $members
        ];

        return response()->json($response);
    }

    public function editMember($id){
        $members = Member::select('members.*','periodes.periode')
        ->join('periodes','periodes.id','=','members.periode_id')
        ->where('members.id','=',$id)
        ->first();

        $response = [
            'members' => $members
        ];

        return response()->json($response);
    }

    public function updateMember(Request $r, $id){
        $members = Member::findOrFail($id)->update([
            'user_id' => auth()->user()->id,
            'name' => $r->name,
            'nim' => $r->nim,
            'handphone' => $r->handphone
        ]);

        return response()->json([
            'message' => 'Data anggota berhasil diubah'
        ]);
    }

    public function deleteMember($id){
        $members = Member::findOrFail($id)->delete();

        $response = [
            'message' => 'Berhasil menghapus data member yang dipilih'
        ];

        return response()->json($response);
    }

    public function download($periode_id){
        $spreadsheet = new Spreadsheet();

        $members = Member::select('members.*', 'periodes.periode')
        ->join('periodes', 'periodes.id', '=', 'members.periode_id')
        ->where('members.periode_id', '=', $periode_id)
        ->get();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'NAMA');
        $sheet->setCellValue('D1', 'NO TELP');
        $row = 2;
        $nomor = 1;
        foreach($members as $member){
            $sheet->setCellValue('A'.$row,$nomor++);
            $sheet->setCellValue('B'.$row,$member->nim);
            $sheet->setCellValue('C'.$row,$member->name);
            $sheet->setCellValue('D'.$row,$member->handphone);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('download.xlsx');
        return response()->download(public_path('download.xlsx'))->deleteFileAfterSend();
    }
}
