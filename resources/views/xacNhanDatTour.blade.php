<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đặt Tour - NHTravel</title>
</head>
<body style="margin:0; padding:0; font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif; background-color:#f4f7fa; color:#333;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7fa;">
    <tr>
        <td align="center" style="padding:20px 10px;">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 10px 25px rgba(0,0,0,0.1);">
                
                <!-- ===== LOGO & HEADER ===== -->
                <tr>
                    <td style="padding:20px 30px; background-color:#ffffff; text-align:center;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center">
                                    <!-- Dùng logo từ nguồn Unsplash placeholder hoặc text-logo đẹp nếu ảnh bị block -->
                                    <div style="display:inline-block; padding:10px; border-radius:50%; background-color:#f0f3ff;">
                                        <span style="font-size:32px;">✈️</span>
                                    </div>
                                    <h1 style="margin:10px 0 0 0; color:#4f46e5; font-size:24px; font-weight:800; letter-spacing:1px; text-transform:uppercase;">NHTravel</h1>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- ===== HERO BANNER (CẢNH ĐẸP VIỆT NAM) ===== -->
                <tr>
                    <td style="padding:0; position:relative;">
                        <img src="https://images.unsplash.com/photo-1528127269322-539801943592?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             alt="Vietnam Beauty" style="width:100%; height:250px; display:block; object-fit:cover;">
                        <div style="background:linear-gradient(to top, rgba(0,0,0,0.7), transparent); position:absolute; bottom:0; left:0; right:0; padding:20px 30px; text-align:left;">
                            <h2 style="margin:0; color:#ffffff; font-size:22px; font-weight:700;">Hành trình tuyệt vời đang chờ bạn!</h2>
                            <p style="margin:5px 0 0 0; color:#f0f0f0; font-size:14px;">Xác nhận đặt tour thành công 🎉</p>
                        </div>
                    </td>
                </tr>

                <!-- ===== GREETING & STATUS ===== -->
                <tr>
                    <td style="padding:30px 40px 10px 40px; text-align:center;">
                        <h2 style="margin:0 0 10px 0; color:#1f2937; font-size:20px; font-weight:700;">Xin chào {{ $data['ten_lien_lac'] }}!</h2>
                        <p style="margin:0; color:#4b5563; font-size:15px; line-height:1.6;">
                            Cảm ơn bạn đã lựa chọn <strong>NHTravel</strong> cho chuyến đi sắp tới. 
                            Chúng tôi đã nhận được yêu cầu đặt tour của bạn và đang chuẩn bị mọi thứ tốt nhất.
                        </p>
                    </td>
                </tr>

                <!-- ===== ORDER INFO BADGE ===== -->
                <tr>
                    <td style="padding:20px 40px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef2ff; border:1px solid #c7d2fe; border-radius:12px;">
                            <tr>
                                <td style="padding:15px 20px;">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="width:50%;">
                                                <span style="color:#6366f1; font-size:12px; font-weight:700; text-transform:uppercase;">Mã đơn hàng</span><br>
                                                <span style="color:#1e1b4b; font-size:18px; font-weight:800;">{{ $data['ma_don_hang'] }}</span>
                                            </td>
                                            <td align="right">
                                                <div style="background-color:#6366f1; color:#ffffff; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:700;">
                                                    {{ $data['phuong_thuc_raw'] === 'cash' ? 'XÁC NHẬN ✅' : 'CHỜ THANH TOÁN ⏳' }}
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- ===== TOUR & PAYMENT DETAILS ===== -->
                <tr>
                    <td style="padding:0 40px 30px 40px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
                            <tr>
                                <td colspan="2" style="background-color:#f9fafb; padding:12px 20px; border-bottom:1px solid #e5e7eb;">
                                    <span style="color:#374151; font-size:14px; font-weight:700;">📋 Thông tin chuyến đi</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px 20px; border-bottom:1px solid #f3f4f6; color:#6b7280; font-size:13px;">Tour du lịch</td>
                                <td style="padding:12px 20px; border-bottom:1px solid #f3f4f6; color:#111827; font-size:13px; font-weight:700; text-align:right;">{{ $data['ten_tour'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:12px 20px; border-bottom:1px solid #f3f4f6; color:#6b7280; font-size:13px;">Ngày đặt</td>
                                <td style="padding:12px 20px; border-bottom:1px solid #f3f4f6; color:#111827; font-size:13px; text-align:right;">{{ $data['ngay_dat'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:12px 20px; border-bottom:1px solid #f3f4f6; color:#6b7280; font-size:13px;">Số lượng khách</td>
                                <td style="padding:12px 20px; border-bottom:1px solid #f3f4f6; color:#111827; font-size:13px; text-align:right;">
                                    {{ $data['so_nguoi_lon'] }} người lớn{{ $data['so_tre_em'] > 0 ? ', ' . $data['so_tre_em'] . ' trẻ em' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px 20px; background-color:#fdf2f2; color:#b91c1c; font-size:14px; font-weight:700;">Tổng cộng</td>
                                <td style="padding:12px 20px; background-color:#fdf2f2; color:#dc2626; font-size:18px; font-weight:800; text-align:right;">{{ number_format($data['tien_thuc_nhan'], 0, ',', '.') }} ₫</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- ===== VIETNAM DISCOVERY SECTION (STABLE IMAGES) ===== -->
                <tr>
                    <td style="padding:0 40px 30px 40px;">
                        <h3 style="margin:0 0 15px 0; color:#374151; font-size:16px; font-weight:700;">Gợi ý cho chuyến hành trình 🇻🇳</h3>
                        <div style="border-radius:12px; overflow:hidden; border:1px solid #e5e7eb;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Night_in_Hoi_An_Ancient_Town.jpg/600px-Night_in_Hoi_An_Ancient_Town.jpg" 
                                 style="width:100%; display:block;" alt="Hội An đẹp lung linh">
                            <div style="padding:15px; background-color:#f9fafb; text-align:center;">
                                <b style="color:#111827; font-size:14px;">Phố cổ Hội An - Di sản văn hóa thế giới</b>
                                <p style="margin:5px 0 0 0; color:#6b7280; font-size:12px;">Đừng bỏ lỡ những đêm đèn lồng huyền ảo.</p>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- ===== CTA BUTTON ===== -->
                <tr>
                    <td align="center" style="padding:0 40px 40px 40px;">
                        <a href="{{ $data['link_don_hang'] }}" 
                           style="display:inline-block; background-color:#4f46e5; color:#ffffff; padding:15px 35px; border-radius:30px; text-decoration:none; font-size:15px; font-weight:700; box-shadow:0 5px 15px rgba(79, 70, 229, 0.3);">
                            CHI TIẾT ĐƠN HÀNG
                        </a>
                    </td>
                </tr>

                <!-- ===== SUPPORT & FOOTER ===== -->
                <tr>
                    <td style="padding:30px 40px; background-color:#111827; text-align:center;">
                        <span style="color:#ffffff; font-size:18px; font-weight:800; letter-spacing:1px;">NHTravel</span>
                        <div style="margin:15px 0; border-top:1px solid #374151;"></div>
                        <p style="margin:0; color:#9ca3af; font-size:13px; line-height:1.8;">
                            Email: support@nhtravel.com | Hotline: 0369 636 310<br>
                            Địa chỉ: 52 Lê Đại Hành, Q.11, TP.HCM
                        </p>
                        <div style="margin:20px 0 0 0;">
                            <span style="color:#6b7280; font-size:11px;">Đây là email tự động từ hệ thống. Vui lòng không trả lời email này.</span>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
