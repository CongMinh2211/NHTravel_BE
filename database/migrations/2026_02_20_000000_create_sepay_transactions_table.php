<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sepay_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique(); // ID giao dịch từ SePay
            $table->string('ma_don_hang')->nullable(); // Mã đơn hàng trong hệ thống
            
            $table->string('gateway')->nullable(); // Tên ngân hàng giao dịch
            $table->string('account_number')->nullable(); // Số tài khoản người chuyển
            
            $table->decimal('transfer_amount', 15, 2)->default(0); // Số tiền chuyển
            $table->string('transfer_type')->nullable(); // Loại giao dịch: in/out
            $table->text('content')->nullable(); // Nội dung chuyển khoản
            
            $table->string('reference_code')->nullable(); // Mã tham chiếu
            $table->dateTime('transaction_date')->nullable(); // Thời gian giao dịch
            
            $table->enum('trang_thai', ['cho_xu_ly', 'da_xac_nhan', 'that_bai', 'khong_khop'])
                  ->default('cho_xu_ly');
            $table->text('ghi_chu')->nullable(); // Ghi chú xử lý
            
            $table->timestamps();
            
            // Index for faster queries
            $table->index('ma_don_hang');
            $table->index('trang_thai');
            $table->index('transaction_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sepay_transactions');
    }
};
