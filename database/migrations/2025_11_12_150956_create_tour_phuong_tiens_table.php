<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_phuong_tiens', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_tour');
            $table->unsignedBigInteger('id_phuong_tien');
            
            // Chỉ giữ lại ghi chú (ví dụ: "Xe chở khách VIP", "Xe chở hành lý")
            $table->string('ghi_chu')->nullable();

            $table->timestamps();

            // Khóa ngoại
            $table->foreign('id_tour')
                  ->references('id')->on('tour_du_liches')
                  ->onDelete('cascade');

            $table->foreign('id_phuong_tien')
                  ->references('id')->on('phuong_tiens')
                  ->onDelete('cascade');

            // Ràng buộc: Một xe không thể được thêm 2 lần vào cùng 1 tour
            $table->unique(['id_tour', 'id_phuong_tien']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_phuong_tiens');
    }
};