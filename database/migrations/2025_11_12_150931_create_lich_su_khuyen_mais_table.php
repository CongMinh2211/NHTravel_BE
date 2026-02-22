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
        Schema::create('lich_su_khuyen_mais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_khach_hang');
            $table->unsignedBigInteger('id_ma_giam_gia');
            $table->dateTime('thoi_gian_su_dung');
            $table->timestamps();

            $table->foreign('id_khach_hang')->references('id')->on('nguoi_dungs')->onDelete('cascade');
            $table->foreign('id_ma_giam_gia')->references('id')->on('ma_giam_gias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_su_khuyen_mais');
    }
};
