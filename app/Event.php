<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = [
        'periode_id',
        'user_id',
        'nama_event',
        'ketua_panitia',
        'tgl_mulai',
        'tgl_akhir',
        'deskripsi'
    ];

    public function User(){
        return $this->hasOne('app\User');
    }

    public function Periode(){
        return $this->hasOne('app\Periode');
    }
}
