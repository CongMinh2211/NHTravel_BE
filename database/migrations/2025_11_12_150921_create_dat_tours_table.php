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
        Schema::create('dat_tours', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_khach_hang');
            $table->unsignedBigInteger('id_tour');
            $table->string('ma_don_hang')->unique();
            $table->dateTime('ngay_dat');
            $table->integer('so_nguoi_lon');
            $table->integer('so_tre_em')->default(0);
            $table->decimal('tong_tien', 12, 2);
            $table->decimal('giam_gia', 12, 2)->default(0);
            $table->decimal('tien_thuc_nhan', 12, 2);
            $table->unsignedBigInteger('id_ma_giam_gia')->nullable();
            $table->string('ten_lien_lac');
            $table->string('email_lien_lac');
            $table->string('so_dien_thoai_lien_lac');
            $table->string('dia_chi_lien_lac')->nullable();
            $table->enum('trang_thai', ['cho_xu_ly', 'da_thanh_toan', 'da_huy'])
                ->default('cho_xu_ly');
            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('id_khach_hang')->references('id')->on('nguoi_dungs')->onDelete('cascade');
            $table->foreign('id_tour')->references('id')->on('tour_du_liches')->onDelete('cascade');
            $table->foreign('id_ma_giam_gia')->references('id')->on('ma_giam_gias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dat_tours');
    }
};
