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
        Schema::create('ma_giam_gias', function (Blueprint $table) {
            $table->id();
            $table->string('ma');
            $table->string('mo_ta')->nullable();
            $table->integer('phan_tram_giam');
            $table->date('hieu_luc_tu');
            $table->date('hieu_luc_den');
            $table->integer('so_luong');
            $table->unsignedBigInteger('tao_boi');
            $table->enum('trang_thai', ['con_hieu_luc', 'het_hieu_luc']);
            $table->timestamps();

            $table->foreign('tao_boi')->references('id')->on('nguoi_dungs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ma_giam_gias');
    }
};
