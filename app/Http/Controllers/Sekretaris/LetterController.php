<?php

namespace App\Http\Controllers\Sekretaris;

use Image;
use DB;
use App\User;
use App\Periode;
use App\Letter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LetterController extends Controller
{
    public function createLetter(Request $r){
        $this->validate($r,[
            'jenis' => 'required',
            'nomor_surat' => 'required',
            'perihal' => 'required',
            'tanggal' => 'required',
            'deskripsi' => 'required'
        ]);

        $select = User::where('id','=',auth()->user()->id)->first();

        if(!$r->hasFile('pict') && $r->hasFile('surat')){
            $surat = $r->file('surat');
            $file = time().'.'.$surat->getClientOriginalExtension();
            $path = 'file/surat';
            $surat->storeAs($path,$file,'public');
            if ($r->file('surat')->isValid()) {
                $letters = Letter::create([
                    'periode_id' => $select->periode_id,
                    'user_id' => auth()->user()->id,
                    'jenis' => $r->jenis,
                    'nomor_surat' => $r->nomor_surat,
                    'perihal' => $r->perihal,
                    'surat' => $file,
                    'tanggal' => $r->tanggal,
                    'deskripsi' => $r->deskripsi
                ]);
            }
        }elseif($r->hasFile('pict') && !$r->hasFile('surat')){
            $gambar = $r->file('pict');
            $filename = time() . '.' . $gambar->getClientOriginalExtension();
            if ($r->file('pict')->isValid() || $r->file('surat')->isValid()) {
                Image::make($gambar)->save(public_path('/images/surat/'.$filename));
                $letters = Letter::create([
                    'periode_id' => $select->periode_id,
                    'user_id' => auth()->user()->id,
                    'jenis' => $r->jenis,
                    'nomor_surat' => $r->nomor_surat,
                    'perihal' => $r->perihal,
                    'pict' => $filename,
                    'tanggal' => $r->tanggal,
                    'deskripsi' => $r->deskripsi
                ]);
            }
        }elseif($r->hasFile('pict') && $r->hasFile('surat')){
            $surat = $r->file('surat');
            $gambar = $r->file('pict');
            $filename = time() . '.' . $gambar->getClientOriginalExtension();
            $file = time().'.'.$r->file->getClientOriginalExtension();
            if ($r->file('pict')->isValid() && $r->file('surat')->isValid()) {
                Image::make($gambar)->save(public_path('/images/surat/'.$filename));
                $letters = Letter::create([
                    'periode_id' => $select->periode_id,
                    'user_id' => auth()->user()->id,
                    'jenis' => $r->jenis,
                    'nomor_surat' => $r->nomor_surat,
                    'perihal' => $r->perihal,
                    'surat' => $surat->mone(public_path('/file/surat'),$file),
                    'pict' => $filename,
                    'tanggal' => $r->tanggal,
                    'deskripsi' => $r->deskripsi
                ]);
            }
        }

        return response()->json([
            'message' => 'Data surat Berhasil disimpan'
        ]);
    }

    public function getSuratMasuk(){
        $letters = Letter::select('letters.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','letters.periode_id')
        ->join('users','users.id','=','letters.user_id')
        ->where('letters.jenis','=','Surat Masuk')
        ->get();

        return response()->json([
            'letters' => $letters
        ]);
    }

    public function editSuratMasuk($id){
        $letters = Letter::where('id','=',$id)->first();

        return response()->json([
            'letters'  => $letters
        ]);
    }

    public function getSuratKeluar(){
        $letters = Letter::select('letters.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','letters.periode_id')
        ->join('users','users.id','=','letters.user_id')
        ->where('letters.jenis','=','Surat Keluar')
        ->get();

        return response()->json([
            'letters' => $letters
        ]);
    }

    public function downloadSuratKeluar($id){
        $file= public_path(). "/file/surat/info.pdf";

        $headers = array(
                'Content-Type: application/pdf',
                );

        return Response::download($file, 'filename.pdf', $headers);
    }

    public function showSuratMasuk($id){
        $letters = Letter::select('letters.*','periodes.periode','users.username')
        ->join('periodes','periodes.id','=','letters.periode_id')
        ->join('users','users.id','=','letters.user_id')
        ->where('letters.id','=',$id)
        ->first();

        $response = [
            'let' => $letters
        ];
        return response()->json($response);
    }
}