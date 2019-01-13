<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $fillable = [
        'periode_id',
        'name',
        'username',
        'nim',
        'email',
        'password',
        'tgl_lahir',
        'jenis_kelamin',
        'role',
        'alamat',
        'no_telp',
        'pict',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Periode(){
        return $this->hasOne('app\Periode');
    }

    public function Letter(){
        return $this->belongsTo('app\User');
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

    public function Inventory(){
        return $this->belongsTo('app\Inventory');
    }
}
