<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Fix: SQLite CHECK constraint on phuong_thuc column
 * 
 * SQLite enum generates a CHECK constraint that blocks 'sepay' value.
 * This migration recreates the table with 'sepay' included in the enum,
 * preserving all existing data.
 */
return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite requires table recreation to change CHECK constraints
            // Step 1: Create temp table with correct schema
            DB::statement("CREATE TABLE thanh_toans_new (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                id_dat_tour INTEGER NOT NULL,
                phuong_thuc VARCHAR(20) CHECK(phuong_thuc IN ('momo','vnpay','bank','tien_mat','visa','mbbank','sepay','chuyen_khoan')) NOT NULL,
                thoi_gian_thanh_toan DATETIME,
                so_tien DECIMAL(12,2) DEFAULT 0,
                trang_thai VARCHAR(20) CHECK(trang_thai IN ('cho_thanh_toan','thanh_cong','that_bai')) DEFAULT 'cho_thanh_toan',
                created_at TIMESTAMP,
                updated_at TIMESTAMP,
                FOREIGN KEY (id_dat_tour) REFERENCES dat_tours(id) ON DELETE CASCADE
            )");

            // Step 2: Copy data
            DB::statement("INSERT INTO thanh_toans_new SELECT * FROM thanh_toans");

            // Step 3: Drop old table
            DB::statement("DROP TABLE thanh_toans");

            // Step 4: Rename new table
            DB::statement("ALTER TABLE thanh_toans_new RENAME TO thanh_toans");
        } else {
            // MySQL/PostgreSQL: Just modify the enum
            DB::statement("ALTER TABLE thanh_toans MODIFY COLUMN phuong_thuc ENUM('momo','vnpay','bank','tien_mat','visa','mbbank','sepay','chuyen_khoan')");
        }
    }

    public function down(): void
    {
        // No rollback needed - the previous migration already attempted this
    }
};
