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
        Schema::create('bai_viets', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de', 255);
            $table->string('mo_ta_ngan', 500)->nullable();
            $table->text('noi_dung');
            $table->string('hinh_anh', 500)->nullable();
            $table->string('tag', 255)->nullable();
            $table->unsignedBigInteger('id_danh_muc');
            $table->enum('tinh_trang', ['nhap', 'xuat_ban'])->default('nhap');
            $table->timestamps();

            $table->foreign('id_danh_muc')->references('id')->on('danh_muc_bai_viets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bai_viets');
    }
};
