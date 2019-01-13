<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'absents';
    protected $fillable = [
        'periode_id',
        'user_id',
        'judul_absen',
        'deskripsi'
    ];

    public function User(){
        return $this->hasOne('app\User');
    }

    public function Periode(){
        return $this->hasOne('app\Periode');
    }
}
