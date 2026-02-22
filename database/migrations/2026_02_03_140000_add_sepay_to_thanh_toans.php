<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Migration: Thêm phương thức thanh toán 'sepay' vào bảng thanh_toans
 * 
 * Lưu ý: SQLite không hỗ trợ thay đổi enum trực tiếp,
 * nên migration này sẽ đổi cột sang VARCHAR
 */
return new class extends Migration
{
    public function up(): void
    {
        // Đối với SQLite, cần recreate table vì SQLite không hỗ trợ ALTER COLUMN
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite: Không thực sự cần migration vì đang dùng fillable
            // Model sẽ tự validate, nhưng cần update model thôi
            // Bỏ qua vì SQLite không validate enum ở DB level
        } else {
            // MySQL/PostgreSQL: Thay đổi enum
            DB::statement("ALTER TABLE thanh_toans MODIFY COLUMN phuong_thuc ENUM('momo', 'vnpay', 'bank', 'tien_mat', 'visa', 'mbbank', 'sepay')");
        }
    }

    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver !== 'sqlite') {
            DB::statement("ALTER TABLE thanh_toans MODIFY COLUMN phuong_thuc ENUM('momo', 'vnpay', 'bank', 'tien_mat', 'visa', 'mbbank')");
        }
    }
};
