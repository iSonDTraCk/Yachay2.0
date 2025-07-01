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
            $table->string('task')->nullable()->after('end_date');
            $table->text('external_links')->nullable()->after('task');
            $table->text('resources')->nullable()->after('external_links');
            $table->string('status')->default('publicada')->after('resources'); // solo si usas status
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('task');
            $table->dropColumn('external_links');
            $table->dropColumn('resources');
            $table->dropColumn('status'); // solo si la agregaste arriba
        });
    }
};
