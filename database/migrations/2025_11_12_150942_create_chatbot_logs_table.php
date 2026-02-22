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
        Schema::create('chatbot_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_khach_hang')->nullable();
            $table->text('noi_dung');
            $table->timestamps();

            $table->foreign('id_khach_hang')->references('id')->on('nguoi_dungs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_logs');
    }
};
