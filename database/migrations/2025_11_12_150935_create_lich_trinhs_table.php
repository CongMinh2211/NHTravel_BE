<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lich_trinhs', function (Blueprint $table) {
            $table->id();

            // Foreign key tới tour
            $table->unsignedBigInteger('id_tour');
            $table->foreign('id_tour')->references('id')->on('tour_du_liches')->onDelete('cascade');

            $table->integer('ngay_lich_trinh'); // index + 1
            $table->integer('thu_tu');          // index + 1
            $table->string('tieu_de');          // FE gửi: value.tieu_de
            $table->text('noi_dung')->nullable(); // FE gửi: value.noi_dung
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lich_trinhs');
    }
};
