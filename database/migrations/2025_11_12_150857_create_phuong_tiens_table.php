<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phuong_tiens', function (Blueprint $table) {
            $table->id();
            $table->string('ten_phuong_tien');
            $table->string('mo_ta')->nullable();
            
            // Quan trọng: Biển số phải là duy nhất
            $table->string('bien_so')->unique(); 
            
            $table->integer('suc_chua');
            
            // 0: dang_dung, 1: san_sang, 2: bao_tri
            $table->tinyInteger('trang_thai')->default(1); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phuong_tiens');
    }
};