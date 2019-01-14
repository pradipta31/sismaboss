<?php

namespace App\Http\Controllers\Ketua;

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
        $members = Member::select('members.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','members.periode_id')
        ->join('users','users.id','=','members.user_id')
        ->where('users.periode_id','=',auth()->user()->periode_id)
        ->get();

        return response()->json([
            'members' => $members
        ]);
    }

    public function download($periode_id){
        $spreadsheet = new Spreadsheet();

        $members = Member::select('members.*', 'periodes.periode')
        ->join('periodes', 'periodes.id', '=', 'members.periode_id')
        ->where('members.periode_id', '=', $periode_id)
        ->get();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIM');
        $sheet->setCellValue('B1', 'NAMA');
        $sheet->setCellValue('C1', 'NO TELP');
        $row = 2;
        foreach($members as $member){
            $sheet->setCellValue('A'.$row,$member->nim);
            $sheet->setCellValue('B'.$row,$member->name);
            $sheet->setCellValue('C'.$row,$member->handphone);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('download.xlsx');
        return response()->download(public_path('download.xlsx'))->deleteFileAfterSend();
    }
}
