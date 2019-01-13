<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table = 'meetings';
    protected $fillable = [
        'periode_id',
        'user_id',
        'judul_rapat',
        'tgl_rapat',
        'hasil_rapat',
        'jumlah_hadir',
        'moderator'
    ];

    public function User(){
        return $this->hasOne('app\User');
    }

    public function Periode(){
        return $this->hasOne('app\Periode');
    }
}
