<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = [
        'periode_id',
        'user_id',
        'name',
        'nim',
        'handphone'
    ];

    public function Periode(){
        return $this->hasOne('app\Periode');
    }

    public function User(){
        return $this->hasOne('app\User');
    }
}
