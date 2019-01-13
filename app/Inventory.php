<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';
    protected $fillable = [
        'periode_id',
        'penanggung_jawab',
        'nama',
        'keterangan',
        'pict'
    ];

    public function Periode(){
        return $this->hasOne('app\Periode');
    }

    public function User(){
        return $this->hasOne('app\User');
    }
}
