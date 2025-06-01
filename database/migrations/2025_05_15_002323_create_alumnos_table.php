<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->string('dni', 8)->primary();  // Clave primaria personalizada
            $table->string('nombre');
            $table->string('email')->unique();   // Usamos 'email', no 'correo'
            $table->string('password');
            $table->rememberToken();             // Opcional para login
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
