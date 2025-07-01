<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    /**
     * Los campos que se pueden asignar masivamente.
     * Es crucial que todos los campos del formulario estén aquí.
     */
    protected $fillable = [
        'title',
        'description',
        'level',
        'start_date',
        'end_date',
        'task',
        'status',
        'external_links',
        'resources',
        'completed',
    ];

    /**
     * The attributes that should be cast.
     * Esto le dice a Laravel que trate estas columnas como arrays.
     * ¡Es crucial para que guardar y leer los datos funcione bien!
     */
    protected $casts = [
        'external_links' => 'array',
        'resources' => 'array',
        'completed' => 'boolean',
    ];

    // La línea 'public $timestamps = true;' no es necesaria,
    // ya que es el comportamiento por defecto de Laravel.

    /**
     * The "booted" method of the model.
     * Aquí es donde podemos establecer valores predeterminados
     * o realizar acciones después de que el modelo haya sido creado.
     */
    protected static function booted()
    {
        static::creating(function ($lesson) {
            // Establecer el estado predeterminado como 'BORRADOR'
            $lesson->status = 'BORRADOR';
        });
    }
}
