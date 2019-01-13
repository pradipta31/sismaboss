<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $table = 'funds';
    protected $fillable = [
        'periode_id',
        'user_id',
        'jenis',
        'tanggal',
        'debit',
        'kredit',
        'saldo',
        'total',
        'nominal',
        'keterangan'
    ];

    public function Periode(){
        $this->hasOne('app\Periode');
    }
    public function User(){
        $this->hasOne('app\User');
    }
}
