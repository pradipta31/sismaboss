<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileMember extends Model
{
    protected $table = 'file_members';
    protected $fillable = [
        'periode_id',
        'user_id',
        'excel_file'
    ];

    public function Periode(){
        return $this->hasOne('app\Periode');
    }

    public function User(){
        return $this->hasOne('app\User');
    }
}
