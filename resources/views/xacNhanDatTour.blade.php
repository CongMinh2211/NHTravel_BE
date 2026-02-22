<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đặt Tour - NHTravel</title>
</head>

<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; line-height: 1.6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f0f2f5;">
        <tr>
            <td style="padding: 20px 0;">
                <table role="presentation"
                    style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">

                    <!-- Header with gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                            <div style="background-color: rgba(255,255,255,0.15); display: inline-block; padding: 12px 24px; border-radius: 50px; margin-bottom: 16px;">
                                <span style="color: #ffffff; font-size: 28px; font-weight: 800; letter-spacing: 2px;">
                                    ✈️ NHTravel
                                </span>
                            </div>
                            <h2 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 300; opacity: 0.95;">
                                Đặt tour thành công!
                            </h2>
                        </td>
                    </tr>

                    <!-- Success Icon & Greeting -->
                    <tr>
                        <td style="padding: 35px 30px 20px 30px; text-align: center;">
                            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #00b894 0%, #00cec9 100%); border-radius: 50%; margin: 0 auto 20px auto; display: flex; align-items: center; justify-content: center; line-height: 70px;">
                                <span style="font-size: 32px;">✅</span>
                            </div>
                            <h3 style="color: #2d3436; font-size: 20px; margin: 0 0 10px 0; font-weight: 700;">
                                Xin chào {{ $data['ten_lien_lac'] }}!
                            </h3>
                            <p style="color: #636e72; font-size: 15px; margin: 0; line-height: 1.7;">
                                Cảm ơn bạn đã đặt tour tại <strong style="color: #667eea;">NHTravel</strong>.
                                Dưới đây là thông tin chi tiết đơn hàng của bạn.
                            </p>
                        </td>
                    </tr>

                    <!-- Order Info Card -->
                    <tr>
                        <td style="padding: 0 30px 25px 30px;">
                            <div style="background: linear-gradient(135deg, #667eea08 0%, #764ba208 100%); border: 1px solid #667eea20; border-radius: 12px; overflow: hidden;">
                                <!-- Order Header -->
                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 14px 20px; display: flex; justify-content: space-between; align-items: center;">
                                    <span style="color: #ffffff; font-size: 14px; font-weight: 600;">
                                        📋 Mã đơn hàng: <strong>{{ $data['ma_don_hang'] }}</strong>
                                    </span>
                                </div>

                                <!-- Tour Info -->
                                <div style="padding: 20px;">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #636e72; font-size: 14px; width: 40%;">
                                                🗺️ Tour du lịch
                                            </td>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #2d3436; font-size: 14px; font-weight: 600; text-align: right;">
                                                {{ $data['ten_tour'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #636e72; font-size: 14px;">
                                                📅 Ngày đặt
                                            </td>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #2d3436; font-size: 14px; font-weight: 600; text-align: right;">
                                                {{ $data['ngay_dat'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #636e72; font-size: 14px;">
                                                👥 Số khách
                                            </td>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #2d3436; font-size: 14px; font-weight: 600; text-align: right;">
                                                {{ $data['so_nguoi_lon'] }} người lớn{{ $data['so_tre_em'] > 0 ? ', ' . $data['so_tre_em'] . ' trẻ em' : '' }}
                                            </td>
                                        </tr>
                                        @if(!empty($data['ngay_khoi_hanh']))
                                        <tr>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #636e72; font-size: 14px;">
                                                🚀 Ngày khởi hành
                                            </td>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; color: #2d3436; font-size: 14px; font-weight: 600; text-align: right;">
                                                {{ $data['ngay_khoi_hanh'] }}
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Payment Details Card -->
                    <tr>
                        <td style="padding: 0 30px 25px 30px;">
                            <div style="background-color: #fafafa; border-radius: 12px; padding: 20px; border: 1px solid #e8e8e8;">
                                <h4 style="margin: 0 0 15px 0; color: #2d3436; font-size: 16px; font-weight: 700;">
                                    💰 Chi tiết thanh toán
                                </h4>

                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 8px 0; color: #636e72; font-size: 14px;">Tổng tiền</td>
                                        <td style="padding: 8px 0; color: #2d3436; font-size: 14px; text-align: right;">
                                            {{ number_format($data['tong_tien'], 0, ',', '.') }} VND
                                        </td>
                                    </tr>
                                    @if($data['giam_gia'] > 0)
                                    <tr>
                                        <td style="padding: 8px 0; color: #00b894; font-size: 14px;">🎁 Giảm giá</td>
                                        <td style="padding: 8px 0; color: #00b894; font-size: 14px; text-align: right; font-weight: 600;">
                                            -{{ number_format($data['giam_gia'], 0, ',', '.') }} VND
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="2" style="padding: 0;">
                                            <div style="border-top: 2px dashed #e0e0e0; margin: 8px 0;"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 0; color: #2d3436; font-size: 16px; font-weight: 800;">
                                            Thành tiền
                                        </td>
                                        <td style="padding: 10px 0; color: #e17055; font-size: 20px; font-weight: 800; text-align: right;">
                                            {{ number_format($data['tien_thuc_nhan'], 0, ',', '.') }} VND
                                        </td>
                                    </tr>
                                </table>

                                <!-- Payment Method -->
                                <div style="margin-top: 15px; padding: 12px 16px; background-color: #ffffff; border-radius: 8px; border: 1px solid #e8e8e8;">
                                    <span style="color: #636e72; font-size: 13px;">Phương thức: </span>
                                    <strong style="color: #667eea; font-size: 13px;">{{ $data['phuong_thuc'] }}</strong>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Contact Info -->
                    <tr>
                        <td style="padding: 0 30px 25px 30px;">
                            <div style="background-color: #f8f9fa; border-radius: 12px; padding: 20px; border-left: 4px solid #667eea;">
                                <h4 style="margin: 0 0 12px 0; color: #2d3436; font-size: 15px; font-weight: 700;">
                                    📞 Thông tin liên hệ
                                </h4>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 5px 0; color: #636e72; font-size: 13px; width: 35%;">Họ tên</td>
                                        <td style="padding: 5px 0; color: #2d3436; font-size: 13px; font-weight: 600;">{{ $data['ten_lien_lac'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 0; color: #636e72; font-size: 13px;">Email</td>
                                        <td style="padding: 5px 0; color: #2d3436; font-size: 13px; font-weight: 600;">{{ $data['email_lien_lac'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 0; color: #636e72; font-size: 13px;">Số điện thoại</td>
                                        <td style="padding: 5px 0; color: #2d3436; font-size: 13px; font-weight: 600;">{{ $data['so_dien_thoai'] }}</td>
                                    </tr>
                                    @if(!empty($data['dia_chi']))
                                    <tr>
                                        <td style="padding: 5px 0; color: #636e72; font-size: 13px;">Địa chỉ</td>
                                        <td style="padding: 5px 0; color: #2d3436; font-size: 13px; font-weight: 600;">{{ $data['dia_chi'] }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- Status Banner -->
                    <tr>
                        <td style="padding: 0 30px 25px 30px;">
                            @if($data['phuong_thuc_raw'] === 'cash')
                            <div style="background: linear-gradient(135deg, #00b894 0%, #00cec9 100%); border-radius: 10px; padding: 18px; text-align: center;">
                                <span style="color: #ffffff; font-size: 15px; font-weight: 600;">
                                    ✅ Đơn hàng đã xác nhận — Thanh toán khi đi tour
                                </span>
                            </div>
                            @else
                            <div style="background: linear-gradient(135deg, #fdcb6e 0%, #f39c12 100%); border-radius: 10px; padding: 18px; text-align: center;">
                                <span style="color: #ffffff; font-size: 15px; font-weight: 600;">
                                    ⏳ Đang chờ thanh toán — Vui lòng thanh toán trong 15 phút
                                </span>
                            </div>
                            @endif
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td style="padding: 0 30px 35px 30px; text-align: center;">
                            <a href="{{ $data['link_don_hang'] }}"
                                style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; font-size: 15px; font-weight: 600; border-radius: 50px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); letter-spacing: 0.5px;">
                                📋 Xem đơn hàng của tôi
                            </a>
                        </td>
                    </tr>

                    <!-- Help Section -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px;">
                            <div style="background: linear-gradient(135deg, #dfe6e9 0%, #b2bec3 100%); border-radius: 10px; padding: 20px; text-align: center;">
                                <p style="color: #2d3436; font-size: 14px; margin: 0 0 10px 0; font-weight: 600;">
                                    Cần hỗ trợ? Liên hệ ngay!
                                </p>
                                <p style="color: #636e72; font-size: 13px; margin: 0; line-height: 1.8;">
                                    📞 Hotline: <strong>0369 636 310</strong><br>
                                    📧 Email: <strong>support@nhtravel.com</strong>
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #2d3436; padding: 30px; text-align: center;">
                            <h3 style="color: #ffffff; font-size: 18px; margin: 0 0 10px 0; font-weight: 700;">
                                ✈️ NHTravel
                            </h3>
                            <p style="color: #b2bec3; font-size: 13px; margin: 0 0 15px 0;">
                                Đặt tour dễ dàng — Trải nghiệm hoàn hảo — Giá tốt mỗi ngày
                            </p>
                            <div style="border-top: 1px solid #636e72; padding-top: 15px; margin-top: 15px;">
                                <p style="color: #95a5a6; font-size: 11px; margin: 0 0 8px 0;">
                                    📧 Email được gửi tự động, vui lòng không trả lời.
                                </p>
                                <p style="color: #95a5a6; font-size: 11px; margin: 0;">
                                    © {{ date('Y') }} NHTravel. All rights reserved.
                                </p>
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
