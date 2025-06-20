<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory; // Habilita el uso de factories

    // Si estás usando timestamps (created_at y updated_at), puedes omitir esto.
    public $timestamps = true;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'university',
        'level',
        'title',
        'description',
        'start_date',
        'end_date',
    ];
}
