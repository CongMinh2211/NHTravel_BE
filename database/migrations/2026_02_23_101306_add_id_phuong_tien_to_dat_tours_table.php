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
        Schema::table('dat_tours', function (Blueprint $table) {
            $table->unsignedBigInteger('id_phuong_tien')->nullable()->after('id_tour');
            
            $table->foreign('id_phuong_tien')
                  ->references('id')->on('phuong_tiens')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dat_tours', function (Blueprint $table) {
            $table->dropForeign(['id_phuong_tien']);
            $table->dropColumn('id_phuong_tien');
        });
    }
};
