<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Cambiamos las columnas a tipo JSON para almacenar arrays de forma nativa
            $table->json('resources')->nullable()->change();
            $table->json('external_links')->nullable()->change();
            // Agregar la columna 'completed' para marcar si el curso está completado
            $table->boolean('completed')->default(false)->after('external_links');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Permite revertir los cambios si es necesario
            $table->text('resources')->nullable()->change();
            $table->text('external_links')->nullable()->change();
            // Eliminar la columna 'completed' si se revierte la migración
            $table->dropColumn('completed');
        });
    }
};
