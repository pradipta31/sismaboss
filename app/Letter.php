<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $table = 'letters';
    protected $fillable = [
        'periode_id',
        'user_id',
        'jenis',
        'nomor_surat',
        'perihal',
        'tanggal',
        'pict',
        'surat',
        'deskripsi'
    ];

    public function Periode(){
        return $this->hasOne('app\Periode');
    }
    public function User(){
        return $this->hasOne('app\User');
    }
}
