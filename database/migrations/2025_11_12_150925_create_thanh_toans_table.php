<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thanh_toans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dat_tour');

            $table->enum('phuong_thuc', ['momo', 'vnpay', 'bank', 'tien_mat', 'visa', 'mbbank']);
            $table->dateTime('thoi_gian_thanh_toan')->nullable();

            $table->decimal('so_tien', 12, 2)->default(0);

            $table->enum('trang_thai', ['cho_thanh_toan', 'thanh_cong', 'that_bai'])
                  ->default('cho_thanh_toan');

            $table->timestamps();

            $table->foreign('id_dat_tour')
                  ->references('id')->on('dat_tours')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thanh_toans');
    }
};
