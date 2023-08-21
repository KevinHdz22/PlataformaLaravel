<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'primer_nombre', 'primer_apellido', 'correo', 'contrasenia',
        'usuario_modificacion', 'usuario_creacion', 'eliminado'
    ];

    protected $hidden = [
        'contrasenia', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Métodos requeridos por JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
       return [
            'id' => $this->id,
            'id_sesion' => uniqid(),
            'primer_nombre' => $this->primer_nombre,
            'primer_apellido' => $this->primer_apellido,
            // ... otros campos relevantes ...
        ];
    }
}
