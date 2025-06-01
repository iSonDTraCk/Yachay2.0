<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Profesor extends Authenticatable
{
    // Usar 'dni' como llave primaria en lugar de 'id'
    protected $primaryKey = 'dni';
    public $incrementing = false;     // 'dni' no es autoincremental
    protected $keyType = 'string';    // o 'int' si tu DNI lo defines numérico

    /**
     * Campos que pueden asignarse masivamente.
     */
    protected $fillable = [
        'dni',
        'nombre',
        'email',   // si prefieres 'email' renómbralo aquí y en migración
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
