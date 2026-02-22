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
        Schema::create('thong_tin_lien_hes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_khach_hang')->nullable();
            $table->string('ten');
            $table->string('email');
            $table->string('so_dien_thoai');
            $table->text('tin_nhan');
            $table->enum('trang_thai', ['chua_xem', 'da_xem', 'da_tra_loi']);
            $table->timestamps();

            $table->foreign('id_khach_hang')->references('id')->on('nguoi_dungs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thong_tin_lien_hes');
    }
};
