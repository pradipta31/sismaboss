<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsentDetail extends Model
{
    protected $table = 'absent_details';
    protected $fillable = [
        'absent_id',
        'member_id'
    ];
}
