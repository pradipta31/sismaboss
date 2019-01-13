<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periodes';
    protected $fillable = ['periode','status'];

    public function User(){
        return $this->belongsTo('app\User');
    }
    public function Letter(){
        return $this->belongsTo('app\Letter');
    }
    public function Meeting(){
        return $this->belongsTo('app\Meeting');
    }
    public function Event(){
        return $this->belongsTo('app\Event');
    }
    public function Fund(){
        return $this->belongsTo('app\Fund');
    }
    public function Member(){
        return $this->belongsTo('app\Member');
    }
    public function Absen(){
        return $this->belongsTo('app\Absen');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($periode) {
             $periode->User()->delete();
        });
    }
}
