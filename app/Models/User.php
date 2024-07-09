<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function Role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function MappingShift()
    {
        return $this->hasMany(MappingShift::class);
    }

    public function Lembur()
    {
        return $this->hasMany(Lembur::class);
    }

    public function Ijin()
    {
        return $this->hasMany(Ijin::class);
    }

    public function Lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function whatsapp($phoneNumber) {
        if (substr($phoneNumber, 0, 1) == '0') {
            return '62' . substr($phoneNumber, 1);
        }
        return $phoneNumber;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }
}
