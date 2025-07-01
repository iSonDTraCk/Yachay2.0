<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('level');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status');
            $table->boolean('completed')->default(false); // Asegúrate de incluir esta columna
            $table->text('external_links')->nullable();
            $table->text('resources')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'description',
                'level',
                'start_date',
                'end_date',
                'status',
                'completed',
                'external_links',
                'resources',
            ]);
        });
    }
};
