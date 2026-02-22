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
        Schema::create('nguoi_dungs', function (Blueprint $table) {

            $table->id();
            $table->string('ho_ten');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('so_dien_thoai')->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->string('cccd')->unique();
            $table->unsignedBigInteger('id_chuc_vu'); // khóa ngoại
            $table->enum('trang_thai', ['active', 'inactive', 'banned'])->default('inactive');
            $table->string('avatar')->nullable();
            $table->string('hash_reset')->nullable(); // để reset mật khẩu
            $table->string('hash_active')->nullable(); // để kích hoạt email
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('id_chuc_vu')->references('id')->on('chuc_vus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguoi_dungs');
    }
};
