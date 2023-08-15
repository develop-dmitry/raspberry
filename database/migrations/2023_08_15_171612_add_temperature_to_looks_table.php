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
        Schema::table('looks', function (Blueprint $table) {
            $table->integer('min_temperature');
            $table->integer('max_temperature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('looks', function (Blueprint $table) {
            $table->dropColumn('min_temperature');
            $table->dropColumn('max_temperature');
        });
    }
};
