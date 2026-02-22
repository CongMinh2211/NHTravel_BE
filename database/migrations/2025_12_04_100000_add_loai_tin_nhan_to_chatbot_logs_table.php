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
        Schema::table('chatbot_logs', function (Blueprint $table) {
            $table->string('loai_tin_nhan')->default('user')->nullable()->after('noi_dung');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chatbot_logs', function (Blueprint $table) {
            $table->dropColumn('loai_tin_nhan');
        });
    }
};
