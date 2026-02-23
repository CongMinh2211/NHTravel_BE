<?php

namespace App\Http\Controllers;

use App\Models\DatTour;
use App\Models\MaGiamGia;
use App\Models\TourDuLich;
use App\Mail\MasterMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class DatTourController extends Controller
{
    public function getData()
    {
        $data = DatTour::join('nguoi_dungs', 'dat_tours.id_khach_hang', '=', 'nguoi_dungs.id')
            ->join('tour_du_liches', 'dat_tours.id_tour', '=', 'tour_du_liches.id')
            ->leftJoin('ma_giam_gias', 'dat_tours.id_ma_giam_gia', '=', 'ma_giam_gias.id')
            ->select(
                'dat_tours.*',
                'nguoi_dungs.ho_ten as ten_khach_hang',
                'nguoi_dungs.avatar',
                'nguoi_dungs.cccd as cccd',
                'tour_du_liches.ten_tour as ten_tour',
                'ma_giam_gias.phan_tram_giam as phan_tram_giam'
            )
            ->orderBy('dat_tours.id', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }



    public function destroy(Request $request)
    {
        $booking = DatTour::find($request->id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy đơn đặt tour'
            ], 404);
        }

        $booking->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa dữ liệu thành công'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'trang_thai' => [
                'required',
                'string',
                Rule::in(['cho_xu_ly', 'da_thanh_toan', 'da_huy']),
            ],
        ]);

        $booking = DatTour::find($request->id);

        if (!$booking) {
            // Trả về 404 Not Found nếu không tìm thấy ID
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy đơn đặt tour'
            ], 404);
        }

        // Cập nhật và lưu
        $booking->trang_thai = $request->trang_thai;
        $booking->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật trạng thái thành công'
        ]);
    }

    public function locThongTin(Request $request)
    {
        $query = DatTour::join('nguoi_dungs', 'dat_tours.id_khach_hang', '=', 'nguoi_dungs.id')
            ->join('tour_du_liches', 'dat_tours.id_tour', '=', 'tour_du_liches.id')
            ->leftJoin('ma_giam_gias', 'dat_tours.id_ma_giam_gia', '=', 'ma_giam_gias.id')
            ->select(
                'dat_tours.*',
                'nguoi_dungs.ho_ten as ten_khach_hang',
                'nguoi_dungs.avatar',
                'nguoi_dungs.cccd',
                'tour_du_liches.ten_tour',
                'ma_giam_gias.phan_tram_giam'
            );

        if ($request->from_date) {
            $query->whereDate('ngay_dat', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('ngay_dat', '<=', $request->to_date);
        }

        $data = $query->orderBy('dat_tours.id', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getDatTour(Request $request)
    {
        $data_tour = TourDuLich::with(['anh', 'phuongTiens'])->where('id', $request->id)->first();
        $data_tour->anh_dai_dien = $data_tour->anh->first()->url ?? null;

        if ($data_tour) {
            return response()->json([
                'status'            => true,
                'data_tour'         => $data_tour,
            ]);
        }
        return response()->json([
            'status'     =>  false,
            'message'    =>  "Không tồn tại tour này!!!"
        ]);
    }

    public function tinhTien(Request $request)
    {
        $tour = TourDuLich::find($request->id_tour);

        if (!$tour) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy tour'
            ]);
        }

        // 1) Tính tổng tiền ban đầu
        $tong_tien =
            $request->so_nguoi_lon * $tour->gia_nguoi_lon +
            $request->so_tre_em * $tour->gia_tre_em;

        // 2) Tính giảm giá
        $giam_gia = 0;

        if ($request->id_ma_giam_gia) {
            $voucher = MaGiamGia::find($request->id_ma_giam_gia);

            if ($voucher && $voucher->so_luong > 0) {
                $giam_gia = $tong_tien * ($voucher->phan_tram_giam / 100);
            }
        }

        // 3) Tính tiền thực nhận
        $tien_thuc_nhan = $tong_tien - $giam_gia;

        return response()->json([
            'status' => true,
            'tong_tien' => $tong_tien,
            'giam_gia' => $giam_gia,
            'tien_thuc_nhan' => $tien_thuc_nhan,
        ]);
    }

    private function calculateAmounts($tour, $soNguoiLon, $soTreEm, $voucher = null)
    {
        $tongTien =
            $soNguoiLon * $tour->gia_nguoi_lon +
            $soTreEm * $tour->gia_tre_em;

        $giamGia = 0;

        if ($voucher) {
            $giamGia = $tongTien * ($voucher->phan_tram_giam / 100);
        }

        $tienThucNhan = $tongTien - $giamGia;

        return [$tongTien, $giamGia, $tienThucNhan];
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_khach_hang'   => 'required|integer',
            'id_tour'         => 'required|integer',
            'so_nguoi_lon'    => 'required|integer|min:1',
            'so_tre_em'       => 'required|integer|min:0',
            'id_ma_giam_gia'  => 'nullable|integer',

            'ten_lien_lac'    => 'required|string',
            'email_lien_lac'  => 'required|email',
            'so_dien_thoai_lien_lac' => 'required|string',
            'dia_chi_lien_lac' => 'nullable|string',
            'id_phuong_tien'  => 'nullable|integer',
        ]);

        $tour = TourDuLich::find($request->id_tour);

        if (!$tour) {
            return response()->json([
                'status'  => false,
                'message' => 'Không tìm thấy tour',
            ], 404);
        }

        $voucher = null;
        if ($request->id_ma_giam_gia) {
            $voucher = MaGiamGia::find($request->id_ma_giam_gia);

            if (!$voucher || $voucher->so_luong <= 0) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Mã giảm giá không hợp lệ hoặc đã hết số lượt',
                ], 400);
            }
        }

        [$tongTien, $giamGia, $tienThucNhan] = $this->calculateAmounts(
            $tour,
            $request->so_nguoi_lon,
            $request->so_tre_em,
            $voucher
        );

        // Prefix ORD để SePay webhook có thể nhận diện qua regex
        $maDonHang = 'ORD' . now()->format('YmdHis') . rand(100, 999);

        $tong_khach = $request->so_nguoi_lon + $request->so_tre_em;

        if ($tour->so_cho_con < $tong_khach) {
            return response()->json([
                'status' => false,
                'message' => 'Số chỗ còn lại không đủ!'
            ]);
        }

        // Trừ chỗ
        $tour->so_cho_con -= $tong_khach;
        $tour->save();

        $booking = DatTour::create([
            'id_khach_hang'   => $request->id_khach_hang,
            'id_tour'         => $request->id_tour,
            'ma_don_hang'     => $maDonHang,
            'ngay_dat'        => now(),

            'so_nguoi_lon'    => $request->so_nguoi_lon,
            'so_tre_em'       => $request->so_tre_em,
            'tong_tien'       => $tongTien,
            'giam_gia'        => $giamGia,
            'tien_thuc_nhan'  => $tienThucNhan,

            'id_ma_giam_gia'  => $voucher ? $voucher->id : null,

            'ten_lien_lac'    => $request->ten_lien_lac,
            'email_lien_lac'  => $request->email_lien_lac,
            'so_dien_thoai_lien_lac' => $request->so_dien_thoai_lien_lac,
            'dia_chi_lien_lac' => $request->dia_chi_lien_lac,

            'trang_thai'      => $request->phuong_thuc_thanh_toan === 'cash' ? 'da_thanh_toan' : 'cho_xu_ly',
            'id_phuong_tien'  => $request->id_phuong_tien,
        ]);

        // Tạo bản ghi ThanhToan nếu là thanh toán khi đi tour
        if ($request->phuong_thuc_thanh_toan === 'cash') {
            \App\Models\ThanhToan::create([
                'id_dat_tour' => $booking->id,
                'phuong_thuc' => 'tien_mat',
                'so_tien' => $tienThucNhan,
                'trang_thai' => 'thanh_cong',
                'thoi_gian_thanh_toan' => now(),
            ]);
        }

        if ($voucher) {
            $voucher->so_luong -= 1;
            $voucher->save();
        }

        // Gửi email xác nhận đặt tour
        try {
            $phuongThucMap = [
                'sepay' => '💳 Chuyển khoản ngân hàng (SePay)',
                'cash'  => '💵 Thanh toán khi đi tour',
            ];

            $mailData = [
                'ten_lien_lac'    => $booking->ten_lien_lac,
                'email_lien_lac'  => $booking->email_lien_lac,
                'so_dien_thoai'   => $booking->so_dien_thoai_lien_lac,
                'dia_chi'         => $booking->dia_chi_lien_lac,
                'ma_don_hang'     => $booking->ma_don_hang,
                'ten_tour'        => $tour->ten_tour ?? 'Tour du lịch',
                'ngay_dat'        => now()->format('d/m/Y H:i'),
                'ngay_khoi_hanh'  => $tour->ngay_khoi_hanh ? Carbon::parse($tour->ngay_khoi_hanh)->format('d/m/Y') : '',
                'so_nguoi_lon'    => $booking->so_nguoi_lon,
                'so_tre_em'       => $booking->so_tre_em,
                'tong_tien'       => $tongTien,
                'giam_gia'        => $giamGia,
                'tien_thuc_nhan'  => $tienThucNhan,
                'phuong_thuc'     => $phuongThucMap[$request->phuong_thuc_thanh_toan] ?? 'Khác',
                'phuong_thuc_raw' => $request->phuong_thuc_thanh_toan,
                'link_don_hang'   => env('FRONTEND_URL', 'https://nhtravel.vercel.app') . '/lich-su-don-hang',
            ];

            Mail::to($booking->email_lien_lac)->send(
                new MasterMail(
                    '✈️ Xác nhận đặt tour - ' . $booking->ma_don_hang,
                    'xacNhanDatTour',
                    $mailData
                )
            );

            Log::info('Email xác nhận đặt tour đã gửi thành công', ['ma_don_hang' => $booking->ma_don_hang]);
        } catch (\Exception $e) {
            // Không block response nếu gửi mail thất bại
            Log::error('Gửi email xác nhận đặt tour thất bại: ' . $e->getMessage(), [
                'ma_don_hang' => $booking->ma_don_hang,
                'email' => $booking->email_lien_lac,
            ]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Đặt tour thành công',
            'data'    => $booking,
        ]);
    }
}
