<?php

namespace App\Http\Controllers;

use App\Models\SepayTransaction;
use Illuminate\Http\Request;

class SepayTransactionController extends Controller
{
    /**
     * Danh sách tất cả giao dịch SePay
     */
    public function index(Request $request)
    {
        $query = SepayTransaction::query();

        // Lọc theo trạng thái
        if ($request->has('trang_thai') && $request->trang_thai) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // Lọc theo mã đơn hàng
        if ($request->has('ma_don_hang') && $request->ma_don_hang) {
            $query->where('ma_don_hang', 'like', '%' . $request->ma_don_hang . '%');
        }

        // Sắp xếp theo thời gian giảm dần
        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($transactions);
    }

    /**
     * Chi tiết một giao dịch
     */
    public function show($id)
    {
        $transaction = SepayTransaction::findOrFail($id);
        return response()->json($transaction);
    }

    /**
     * Thống kê giao dịch SePay
     */
    public function statistics()
    {
        $total = SepayTransaction::count();
        $daXacNhan = SepayTransaction::where('trang_thai', 'da_xac_nhan')->count();
        $choXuLy = SepayTransaction::where('trang_thai', 'cho_xu_ly')->count();
        $khongKhop = SepayTransaction::where('trang_thai', 'khong_khop')->count();
        
        $tongTien = SepayTransaction::where('trang_thai', 'da_xac_nhan')
            ->sum('transfer_amount');

        return response()->json([
            'total' => $total,
            'da_xac_nhan' => $daXacNhan,
            'cho_xu_ly' => $choXuLy,
            'khong_khop' => $khongKhop,
            'tong_tien' => $tongTien,
        ]);
    }
}
