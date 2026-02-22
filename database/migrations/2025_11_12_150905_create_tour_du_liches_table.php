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
        Schema::create('tour_du_liches', function (Blueprint $table) {
            $table->id();
            $table->string('ma_tour')->unique();
            // Tên tour
            $table->string('ten_tour');

            // Mô tả – textarea nên allow nullable
            $table->text('mo_ta')->nullable();

            // Danh mục bắt buộc
            $table->unsignedBigInteger('id_danh_muc');

            $table->integer('gia_nguoi_lon')->nullable();
            $table->integer('gia_tre_em')->nullable();

            // Vue dùng <input type="date"> → giữ nguyên date
            $table->date('ngay_di')->nullable();
            $table->date('ngay_ve')->nullable();

            // Vue gửi giờ dạng HH:mm → giữ nguyên time
            $table->time('gio_di')->nullable();
            $table->time('gio_ve')->nullable();
            $table->string('dia_diem')->nullable();

            // Người tạo → FE lấy từ localStorage → luôn có số
            $table->unsignedBigInteger('tao_boi');
            $table->integer('so_cho')->nullable();
            $table->integer('so_cho_con')->nullable();

            $table->enum('trang_thai', ['hoat_dong', 'tam_dung'])->default('hoat_dong');

            $table->timestamps();

            // Foreign keys
            $table->foreign('id_danh_muc')->references('id')->on('danh_mucs')->onDelete('cascade');
            $table->foreign('tao_boi')->references('id')->on('nguoi_dungs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_du_liches');
    }
};
