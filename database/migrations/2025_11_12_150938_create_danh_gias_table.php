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
        Schema::create('danh_gias', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_tour');
            $table->unsignedBigInteger('id_nguoi_dung');
            $table->text('hinh_anh')->nullable();
            $table->integer('diem'); // Điểm số (1-5 sao)
            $table->text('binh_luan')->nullable(); // Nội dung khách hàng viết
            $table->text('phan_hoi')->nullable(); // Nội dung Admin trả lời
            $table->enum('trang_thai', ['cho_duyet', 'hien_thi', 'an'])->default('cho_duyet'); // Kiểm duyệt

            $table->timestamps();

            // Khóa ngoại
            $table->foreign('id_tour')->references('id')->on('tour_du_liches')->onDelete('cascade');
            $table->foreign('id_nguoi_dung')->references('id')->on('nguoi_dungs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_gias');
    }
};
