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
        Schema::create('answer_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_id');
            $table->foreignId('user_id');
            $table->timestamps();
            $table->unique(['answer_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_likes');
    }
};
