<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = [
        'id_usuario', 'codigo_recuperacion', 'fecha_expiracion_codigo'
    ];

    protected $primaryKey = 'id_usuario'; // Define el campo de clave primaria

    public $incrementing = false; // Indica que la clave primaria no es autoincremental

    protected $keyType = 'string'; // Define el tipo de dato de la clave primaria

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}
