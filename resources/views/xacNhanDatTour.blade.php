<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đặt Tour - NHTravel</title>
</head>
<body style="margin:0; padding:0; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif; background-color:#eef2f7;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef2f7;">
<tr><td align="center" style="padding:30px 10px;">

<table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,0.08);">

    <!-- ===== HEADER ===== -->
    <tr>
        <td style="background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 50%,#a855f7 100%); padding:0;">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding:35px 40px 20px 40px;">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="background:rgba(255,255,255,0.2); border-radius:12px; padding:8px 16px;">
                                    <span style="color:#ffffff; font-size:20px; font-weight:800; letter-spacing:1.5px;">✈️ NHTravel</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 40px 35px 40px;">
                        <h1 style="margin:0 0 8px 0; color:#ffffff; font-size:26px; font-weight:700;">
                            Đặt tour thành công! 🎉
                        </h1>
                        <p style="margin:0; color:rgba(255,255,255,0.85); font-size:14px; font-weight:400;">
                            Cảm ơn bạn đã tin tưởng NHTravel
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- ===== GREETING ===== -->
    <tr>
        <td style="padding:30px 40px 20px 40px;">
            <h2 style="margin:0 0 8px 0; color:#1e1b4b; font-size:20px; font-weight:700;">
                Xin chào {{ $data['ten_lien_lac'] }}! 👋
            </h2>
            <p style="margin:0; color:#64748b; font-size:14px; line-height:1.7;">
                Đơn hàng của bạn đã được ghi nhận. Dưới đây là thông tin chi tiết.
            </p>
        </td>
    </tr>

    <!-- ===== ORDER CODE BADGE ===== -->
    <tr>
        <td style="padding:0 40px 20px 40px;">
            <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:12px;">
                <tr>
                    <td style="padding:16px 20px;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <span style="color:rgba(255,255,255,0.8); font-size:12px; text-transform:uppercase; letter-spacing:1px;">Mã đơn hàng</span><br>
                                    <span style="color:#ffffff; font-size:20px; font-weight:800; letter-spacing:1px;">{{ $data['ma_don_hang'] }}</span>
                                </td>
                                <td align="right" style="vertical-align:middle;">
                                    <span style="font-size:36px;">📋</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- ===== TOUR DETAILS ===== -->
    <tr>
        <td style="padding:0 40px 20px 40px;">
            <table width="100%" cellpadding="0" cellspacing="0" style="border:2px solid #f1f5f9; border-radius:12px; overflow:hidden;">
                <!-- Title -->
                <tr>
                    <td colspan="2" style="background-color:#f8fafc; padding:14px 20px; border-bottom:1px solid #f1f5f9;">
                        <span style="color:#334155; font-size:14px; font-weight:700;">🗺️ Thông tin tour</span>
                    </td>
                </tr>
                <!-- Tour name -->
                <tr>
                    <td style="padding:14px 20px; border-bottom:1px solid #f1f5f9; color:#64748b; font-size:13px; width:130px;">
                        Tour du lịch
                    </td>
                    <td style="padding:14px 20px; border-bottom:1px solid #f1f5f9; color:#1e293b; font-size:13px; font-weight:700; text-align:right;">
                        {{ $data['ten_tour'] }}
                    </td>
                </tr>
                <!-- Ngay dat -->
                <tr>
                    <td style="padding:12px 20px; border-bottom:1px solid #f1f5f9; color:#64748b; font-size:13px;">
                        📅 Ngày đặt
                    </td>
                    <td style="padding:12px 20px; border-bottom:1px solid #f1f5f9; color:#1e293b; font-size:13px; font-weight:600; text-align:right;">
                        {{ $data['ngay_dat'] }}
                    </td>
                </tr>
                <!-- So khach -->
                <tr>
                    <td style="padding:12px 20px; border-bottom:1px solid #f1f5f9; color:#64748b; font-size:13px;">
                        👥 Số khách
                    </td>
                    <td style="padding:12px 20px; border-bottom:1px solid #f1f5f9; color:#1e293b; font-size:13px; font-weight:600; text-align:right;">
                        {{ $data['so_nguoi_lon'] }} người lớn{{ $data['so_tre_em'] > 0 ? ', ' . $data['so_tre_em'] . ' trẻ em' : '' }}
                    </td>
                </tr>
                <!-- Ngay khoi hanh -->
                @if(!empty($data['ngay_khoi_hanh']))
                <tr>
                    <td style="padding:12px 20px; color:#64748b; font-size:13px;">
                        🚀 Khởi hành
                    </td>
                    <td style="padding:12px 20px; color:#1e293b; font-size:13px; font-weight:600; text-align:right;">
                        {{ $data['ngay_khoi_hanh'] }}
                    </td>
                </tr>
                @endif
            </table>
        </td>
    </tr>

    <!-- ===== PAYMENT ===== -->
    <tr>
        <td style="padding:0 40px 20px 40px;">
            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fafbff; border:2px solid #e8ecf4; border-radius:12px; overflow:hidden;">
                <tr>
                    <td colspan="2" style="background-color:#f0f1ff; padding:14px 20px; border-bottom:1px solid #e8ecf4;">
                        <span style="color:#4338ca; font-size:14px; font-weight:700;">💰 Chi tiết thanh toán</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:12px 20px; border-bottom:1px solid #f0f0f0; color:#64748b; font-size:13px;">Tổng tiền</td>
                    <td style="padding:12px 20px; border-bottom:1px solid #f0f0f0; color:#1e293b; font-size:14px; text-align:right;">
                        {{ number_format($data['tong_tien'], 0, ',', '.') }} ₫
                    </td>
                </tr>
                @if($data['giam_gia'] > 0)
                <tr>
                    <td style="padding:12px 20px; border-bottom:1px solid #f0f0f0; color:#059669; font-size:13px;">🎁 Giảm giá</td>
                    <td style="padding:12px 20px; border-bottom:1px solid #f0f0f0; color:#059669; font-size:14px; font-weight:700; text-align:right;">
                        -{{ number_format($data['giam_gia'], 0, ',', '.') }} ₫
                    </td>
                </tr>
                @endif
                <!-- Divider -->
                <tr>
                    <td colspan="2" style="padding:0 20px;">
                        <div style="border-top:2px dashed #e2e8f0; margin:4px 0;"></div>
                    </td>
                </tr>
                <!-- Total -->
                <tr>
                    <td style="padding:14px 20px; color:#1e293b; font-size:15px; font-weight:800;">Thành tiền</td>
                    <td style="padding:14px 20px; text-align:right;">
                        <span style="color:#dc2626; font-size:22px; font-weight:800;">{{ number_format($data['tien_thuc_nhan'], 0, ',', '.') }} ₫</span>
                    </td>
                </tr>
                <!-- Payment method -->
                <tr>
                    <td colspan="2" style="padding:0 20px 16px 20px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#ffffff; border:1px solid #e2e8f0; border-radius:8px;">
                            <tr>
                                <td style="padding:10px 14px; color:#64748b; font-size:12px;">
                                    Phương thức: <strong style="color:#6366f1;">{{ $data['phuong_thuc'] }}</strong>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- ===== CONTACT INFO ===== -->
    <tr>
        <td style="padding:0 40px 20px 40px;">
            <table width="100%" cellpadding="0" cellspacing="0" style="border-left:4px solid #6366f1; background-color:#f8fafc; border-radius:0 12px 12px 0;">
                <tr>
                    <td style="padding:16px 20px;">
                        <p style="margin:0 0 10px 0; color:#334155; font-size:14px; font-weight:700;">
                            📞 Thông tin liên hệ
                        </p>
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:3px 0; color:#64748b; font-size:12px; width:90px;">Họ tên</td>
                                <td style="padding:3px 0; color:#1e293b; font-size:12px; font-weight:600;">{{ $data['ten_lien_lac'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:3px 0; color:#64748b; font-size:12px;">Email</td>
                                <td style="padding:3px 0; color:#1e293b; font-size:12px; font-weight:600;">{{ $data['email_lien_lac'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:3px 0; color:#64748b; font-size:12px;">SĐT</td>
                                <td style="padding:3px 0; color:#1e293b; font-size:12px; font-weight:600;">{{ $data['so_dien_thoai'] }}</td>
                            </tr>
                            @if(!empty($data['dia_chi']))
                            <tr>
                                <td style="padding:3px 0; color:#64748b; font-size:12px;">Địa chỉ</td>
                                <td style="padding:3px 0; color:#1e293b; font-size:12px; font-weight:600;">{{ $data['dia_chi'] }}</td>
                            </tr>
                            @endif
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- ===== STATUS BANNER ===== -->
    <tr>
        <td style="padding:0 40px 24px 40px;">
            @if($data['phuong_thuc_raw'] === 'cash')
            <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#059669,#10b981); border-radius:12px;">
                <tr>
                    <td align="center" style="padding:16px 20px;">
                        <span style="color:#ffffff; font-size:14px; font-weight:700;">
                            ✅ Đã xác nhận — Thanh toán khi đi tour
                        </span>
                    </td>
                </tr>
            </table>
            @else
            <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#f59e0b,#ef4444); border-radius:12px;">
                <tr>
                    <td align="center" style="padding:16px 20px;">
                        <span style="color:#ffffff; font-size:14px; font-weight:700;">
                            ⏳ Vui lòng thanh toán trong 15 phút
                        </span>
                    </td>
                </tr>
            </table>
            @endif
        </td>
    </tr>

    <!-- ===== CTA BUTTON ===== -->
    <tr>
        <td align="center" style="padding:0 40px 30px 40px;">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td style="background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:50px; box-shadow:0 4px 14px rgba(99,102,241,0.4);">
                        <a href="{{ $data['link_don_hang'] }}"
                            style="display:inline-block; color:#ffffff; text-decoration:none; padding:14px 40px; font-size:14px; font-weight:700; letter-spacing:0.5px;">
                            📋 Xem đơn hàng của tôi
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- ===== DIVIDER ===== -->
    <tr>
        <td style="padding:0 40px;">
            <div style="border-top:1px solid #e2e8f0;"></div>
        </td>
    </tr>

    <!-- ===== SUPPORT ===== -->
    <tr>
        <td align="center" style="padding:24px 40px;">
            <p style="margin:0 0 4px 0; color:#334155; font-size:14px; font-weight:700;">
                🎧 Cần hỗ trợ?
            </p>
            <p style="margin:0; color:#64748b; font-size:13px; line-height:1.8;">
                Hotline: <strong style="color:#6366f1;">0369 636 310</strong> &nbsp;|&nbsp;
                Email: <strong style="color:#6366f1;">support@nhtravel.com</strong>
            </p>
        </td>
    </tr>

    <!-- ===== FOOTER ===== -->
    <tr>
        <td style="background:#1e1b4b; padding:28px 40px; text-align:center;">
            <p style="margin:0 0 6px 0; color:#ffffff; font-size:18px; font-weight:800; letter-spacing:1.5px;">
                ✈️ NHTravel
            </p>
            <p style="margin:0 0 16px 0; color:rgba(255,255,255,0.6); font-size:12px;">
                Đặt tour dễ dàng — Trải nghiệm hoàn hảo — Giá tốt mỗi ngày
            </p>
            <div style="border-top:1px solid rgba(255,255,255,0.15); padding-top:16px;">
                <p style="margin:0 0 4px 0; color:rgba(255,255,255,0.4); font-size:11px;">
                    Email gửi tự động, vui lòng không trả lời.
                </p>
                <p style="margin:0; color:rgba(255,255,255,0.4); font-size:11px;">
                    © {{ date('Y') }} NHTravel. All rights reserved.
                </p>
            </div>
        </td>
    </tr>

</table>

</td></tr>
</table>

</body>
</html>
