<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Alumno extends Authenticatable
{
    // Usar 'dni' como llave primaria en lugar de 'id'
    protected $primaryKey = 'dni';
    public $incrementing = false;     // 'dni' no es autoincremental
    protected $keyType = 'string';    // o 'int' si tu DNI lo defines como numérico

    /**
     * Campos que pueden asignarse masivamente.
     */
    protected $fillable = [
        'dni',
        'nombre',
        'email',   // campo de correo electrónico estándar
        'password',
    ];

    /**
     * Campos ocultos al serializar el modelo.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
