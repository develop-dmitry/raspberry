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
        Schema::create('clothes_style', function (Blueprint $table) {
            $table->foreignId('clothes_id')->references('id')->on('clothes');
            $table->foreignId('style_id')->references('id')->on('styles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothes_style');
    }
};
