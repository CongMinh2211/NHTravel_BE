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
        Schema::create('phan_quyens', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_chuc_vu');
            $table->unsignedBigInteger('id_chuc_nang');
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('id_chuc_vu')
                  ->references('id')->on('chuc_vus')
                  ->onDelete('cascade'); // Xóa chức vụ thì xóa luôn phân quyền liên quan

            $table->foreign('id_chuc_nang')
                  ->references('id')->on('chuc_nangs')
                  ->onDelete('cascade'); // Xóa chức năng thì xóa luôn phân quyền liên quan

            // Ràng buộc duy nhất: Một chức vụ không thể có 2 quyền giống hệt nhau
            // Ví dụ: Admin đã có quyền "Xem danh sách" thì không add thêm dòng y hệt nữa
            $table->unique(['id_chuc_vu', 'id_chuc_nang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phan_quyens');
    }
};