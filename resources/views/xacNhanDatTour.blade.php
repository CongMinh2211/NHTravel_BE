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
                    style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 0; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">

                    <!-- Hero Banner with Travel Image -->
                    <tr>
                        <td style="padding: 0; position: relative;">
                            <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=600&h=200&fit=crop&crop=bottom"
                                alt="NHTravel" style="width: 100%; height: 200px; object-fit: cover; display: block;">
                            <table role="presentation" style="width: 100%; position: relative; margin-top: -200px;">
                                <tr>
                                    <td style="background: linear-gradient(180deg, rgba(102,126,234,0.85) 0%, rgba(118,75,162,0.9) 100%); padding: 40px 30px; text-align: center; height: 120px;">
                                        <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 28px; font-weight: 800; letter-spacing: 2px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                            NHTravel
                                        </h1>
                                        <p style="margin: 0; color: rgba(255,255,255,0.95); font-size: 16px; font-weight: 300;">
                                            Đặt tour thành công!
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Success Section with Image -->
                    <tr>
                        <td style="padding: 30px 30px 15px 30px; text-align: center;">
                            <img src="https://img.icons8.com/3d-fluency/94/checked.png"
                                alt="Success" style="width: 64px; height: 64px; margin-bottom: 15px;">
                            <h2 style="color: #2d3436; font-size: 20px; margin: 0 0 10px 0; font-weight: 700;">
                                Xin chào {{ $data['ten_lien_lac'] }}!
                            </h2>
                            <p style="color: #636e72; font-size: 14px; margin: 0; line-height: 1.7;">
                                Cảm ơn bạn đã tin tưởng và đặt tour tại <strong style="color: #667eea;">NHTravel</strong>.
                                Dưới đây là thông tin đơn hàng của bạn.
                            </p>
                        </td>
                    </tr>

                    <!-- Order Info Card -->
                    <tr>
                        <td style="padding: 10px 30px 20px 30px;">
                            <table role="presentation" style="width: 100%; border-collapse: collapse; border: 1px solid #e8e8e8; border-radius: 12px; overflow: hidden;">
                                <!-- Order Header -->
                                <tr>
                                    <td colspan="2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 12px 20px;">
                                        <table role="presentation" style="width: 100%;">
                                            <tr>
                                                <td style="width: 24px;">
                                                    <img src="https://img.icons8.com/3d-fluency/94/receipt.png"
                                                        alt="Order" style="width: 22px; height: 22px; vertical-align: middle;">
                                                </td>
                                                <td style="color: #ffffff; font-size: 14px; font-weight: 600; padding-left: 8px;">
                                                    Mã đơn: <strong>{{ $data['ma_don_hang'] }}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Tour Details -->
                                <tr>
                                    <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f0; width: 40%;">
                                        <table role="presentation"><tr>
                                            <td style="width: 24px; vertical-align: middle;">
                                                <img src="https://img.icons8.com/3d-fluency/94/map.png" alt="" style="width: 20px; height: 20px;">
                                            </td>
                                            <td style="color: #636e72; font-size: 13px; padding-left: 6px;">Tour du lịch</td>
                                        </tr></table>
                                    </td>
                                    <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f0; color: #2d3436; font-size: 13px; font-weight: 600; text-align: right;">
                                        {{ $data['ten_tour'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f0;">
                                        <table role="presentation"><tr>
                                            <td style="width: 24px; vertical-align: middle;">
                                                <img src="https://img.icons8.com/3d-fluency/94/calendar.png" alt="" style="width: 20px; height: 20px;">
                                            </td>
                                            <td style="color: #636e72; font-size: 13px; padding-left: 6px;">Ngày đặt</td>
                                        </tr></table>
                                    </td>
                                    <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f0; color: #2d3436; font-size: 13px; font-weight: 600; text-align: right;">
                                        {{ $data['ngay_dat'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f0;">
                                        <table role="presentation"><tr>
                                            <td style="width: 24px; vertical-align: middle;">
                                                <img src="https://img.icons8.com/3d-fluency/94/group.png" alt="" style="width: 20px; height: 20px;">
                                            </td>
                                            <td style="color: #636e72; font-size: 13px; padding-left: 6px;">Số khách</td>
                                        </tr></table>
                                    </td>
                                    <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f0; color: #2d3436; font-size: 13px; font-weight: 600; text-align: right;">
                                        {{ $data['so_nguoi_lon'] }} người lớn{{ $data['so_tre_em'] > 0 ? ', ' . $data['so_tre_em'] . ' trẻ em' : '' }}
                                    </td>
                                </tr>
                                @if(!empty($data['ngay_khoi_hanh']))
                                <tr>
                                    <td style="padding: 14px 20px;">
                                        <table role="presentation"><tr>
                                            <td style="width: 24px; vertical-align: middle;">
                                                <img src="https://img.icons8.com/3d-fluency/94/airplane-take-off.png" alt="" style="width: 20px; height: 20px;">
                                            </td>
                                            <td style="color: #636e72; font-size: 13px; padding-left: 6px;">Ngày khởi hành</td>
                                        </tr></table>
                                    </td>
                                    <td style="padding: 14px 20px; color: #2d3436; font-size: 13px; font-weight: 600; text-align: right;">
                                        {{ $data['ngay_khoi_hanh'] }}
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    <!-- Payment Card -->
                    <tr>
                        <td style="padding: 0 30px 20px 30px;">
                            <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #fafbfc; border: 1px solid #e8e8e8; border-radius: 12px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 16px 20px; border-bottom: 1px solid #e8e8e8;">
                                        <table role="presentation"><tr>
                                            <td style="width: 24px; vertical-align: middle;">
                                                <img src="https://img.icons8.com/3d-fluency/94/money-bag.png" alt="" style="width: 22px; height: 22px;">
                                            </td>
                                            <td style="color: #2d3436; font-size: 15px; font-weight: 700; padding-left: 8px;">Chi tiết thanh toán</td>
                                        </tr></table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 6px 0; color: #636e72; font-size: 14px;">Tổng tiền</td>
                                                <td style="padding: 6px 0; color: #2d3436; font-size: 14px; text-align: right;">
                                                    {{ number_format($data['tong_tien'], 0, ',', '.') }} VND
                                                </td>
                                            </tr>
                                            @if($data['giam_gia'] > 0)
                                            <tr>
                                                <td style="padding: 6px 0; color: #00b894; font-size: 14px;">
                                                    <img src="https://img.icons8.com/3d-fluency/94/gift.png" alt="" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 4px;">
                                                    Giảm giá
                                                </td>
                                                <td style="padding: 6px 0; color: #00b894; font-size: 14px; text-align: right; font-weight: 600;">
                                                    -{{ number_format($data['giam_gia'], 0, ',', '.') }} VND
                                                </td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td colspan="2" style="padding: 8px 0;">
                                                    <div style="border-top: 2px dashed #e0e0e0;"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #2d3436; font-size: 16px; font-weight: 800;">
                                                    Thành tiền
                                                </td>
                                                <td style="padding: 8px 0; color: #e17055; font-size: 22px; font-weight: 800; text-align: right;">
                                                    {{ number_format($data['tien_thuc_nhan'], 0, ',', '.') }} VND
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Payment Method -->
                                        <div style="margin-top: 12px; padding: 10px 14px; background-color: #ffffff; border-radius: 8px; border: 1px solid #e8e8e8;">
                                            <table role="presentation"><tr>
                                                <td style="width: 22px; vertical-align: middle;">
                                                    <img src="https://img.icons8.com/3d-fluency/94/bank-card-back-side.png" alt="" style="width: 20px; height: 20px;">
                                                </td>
                                                <td style="padding-left: 8px;">
                                                    <span style="color: #636e72; font-size: 12px;">Phương thức: </span>
                                                    <strong style="color: #667eea; font-size: 13px;">{{ $data['phuong_thuc'] }}</strong>
                                                </td>
                                            </tr></table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Contact Info -->
                    <tr>
                        <td style="padding: 0 30px 20px 30px;">
                            <table role="presentation" style="width: 100%; border-collapse: collapse; border-left: 4px solid #667eea; background-color: #f8f9fa; border-radius: 0 12px 12px 0; overflow: hidden;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <table role="presentation" style="margin-bottom: 12px;"><tr>
                                            <td style="width: 24px; vertical-align: middle;">
                                                <img src="https://img.icons8.com/3d-fluency/94/phone-ringing.png" alt="" style="width: 20px; height: 20px;">
                                            </td>
                                            <td style="color: #2d3436; font-size: 14px; font-weight: 700; padding-left: 8px;">Thông tin liên hệ</td>
                                        </tr></table>

                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 4px 0; color: #636e72; font-size: 13px; width: 35%;">Họ tên</td>
                                                <td style="padding: 4px 0; color: #2d3436; font-size: 13px; font-weight: 600;">{{ $data['ten_lien_lac'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 0; color: #636e72; font-size: 13px;">Email</td>
                                                <td style="padding: 4px 0; color: #2d3436; font-size: 13px; font-weight: 600;">{{ $data['email_lien_lac'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 0; color: #636e72; font-size: 13px;">Điện thoại</td>
                                                <td style="padding: 4px 0; color: #2d3436; font-size: 13px; font-weight: 600;">{{ $data['so_dien_thoai'] }}</td>
                                            </tr>
                                            @if(!empty($data['dia_chi']))
                                            <tr>
                                                <td style="padding: 4px 0; color: #636e72; font-size: 13px;">Địa chỉ</td>
                                                <td style="padding: 4px 0; color: #2d3436; font-size: 13px; font-weight: 600;">{{ $data['dia_chi'] }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Status Banner -->
                    <tr>
                        <td style="padding: 0 30px 20px 30px;">
                            @if($data['phuong_thuc_raw'] === 'cash')
                            <table role="presentation" style="width: 100%; border-collapse: collapse; background: linear-gradient(135deg, #00b894 0%, #00cec9 100%); border-radius: 10px;">
                                <tr>
                                    <td style="padding: 14px; text-align: center;">
                                        <img src="https://img.icons8.com/3d-fluency/94/ok.png" alt="" style="width: 22px; height: 22px; vertical-align: middle; margin-right: 6px;">
                                        <span style="color: #ffffff; font-size: 14px; font-weight: 600; vertical-align: middle;">
                                            Đã xác nhận — Thanh toán khi đi tour
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            @else
                            <table role="presentation" style="width: 100%; border-collapse: collapse; background: linear-gradient(135deg, #fdcb6e 0%, #f39c12 100%); border-radius: 10px;">
                                <tr>
                                    <td style="padding: 14px; text-align: center;">
                                        <img src="https://img.icons8.com/3d-fluency/94/hourglass.png" alt="" style="width: 22px; height: 22px; vertical-align: middle; margin-right: 6px;">
                                        <span style="color: #ffffff; font-size: 14px; font-weight: 600; vertical-align: middle;">
                                            Chờ thanh toán — Vui lòng thanh toán trong 15 phút
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            @endif
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td style="padding: 0 30px 25px 30px; text-align: center;">
                            <a href="{{ $data['link_don_hang'] }}"
                                style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; font-size: 14px; font-weight: 600; border-radius: 50px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                Xem đơn hàng của tôi
                            </a>
                        </td>
                    </tr>

                    <!-- Travel Features Banner -->
                    <tr>
                        <td style="padding: 0 30px 25px 30px;">
                            <table role="presentation" style="width: 100%; border-collapse: collapse; overflow: hidden; border-radius: 12px;">
                                <tr>
                                    <td style="padding: 0; position: relative;">
                                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&h=120&fit=crop"
                                            alt="Beach" style="width: 100%; height: 120px; object-fit: cover; display: block; border-radius: 12px;">
                                        <table role="presentation" style="width: 100%; position: relative; margin-top: -120px;">
                                            <tr>
                                                <td style="background: rgba(0,0,0,0.55); padding: 20px; text-align: center; height: 80px; border-radius: 12px;">
                                                    <p style="color: #ffffff; font-size: 14px; margin: 0 0 6px 0; font-weight: 300; opacity: 0.9;">
                                                        Khám phá thêm nhiều tour hấp dẫn tại
                                                    </p>
                                                    <p style="color: #ffffff; font-size: 18px; margin: 0; font-weight: 700; letter-spacing: 1px;">
                                                        nhtravel.vercel.app
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Help Section -->
                    <tr>
                        <td style="padding: 0 30px 25px 30px;">
                            <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f8f9fa; border-radius: 10px;">
                                <tr>
                                    <td style="padding: 20px; text-align: center;">
                                        <img src="https://img.icons8.com/3d-fluency/94/headset.png" alt="" style="width: 36px; height: 36px; margin-bottom: 8px;">
                                        <p style="color: #2d3436; font-size: 14px; margin: 0 0 8px 0; font-weight: 600;">
                                            Cần hỗ trợ? Liên hệ ngay!
                                        </p>
                                        <p style="color: #636e72; font-size: 13px; margin: 0; line-height: 1.8;">
                                            Hotline: <strong>0369 636 310</strong><br>
                                            Email: <strong>support@nhtravel.com</strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #2d3436; padding: 25px 30px; text-align: center;">
                            <img src="https://img.icons8.com/3d-fluency/94/airplane.png" alt="" style="width: 32px; height: 32px; margin-bottom: 8px;">
                            <h3 style="color: #ffffff; font-size: 18px; margin: 0 0 6px 0; font-weight: 700; letter-spacing: 1px;">
                                NHTravel
                            </h3>
                            <p style="color: #b2bec3; font-size: 12px; margin: 0 0 15px 0;">
                                Đặt tour dễ dàng — Trải nghiệm hoàn hảo — Giá tốt mỗi ngày
                            </p>
                            <div style="border-top: 1px solid #636e72; padding-top: 15px;">
                                <p style="color: #95a5a6; font-size: 11px; margin: 0 0 6px 0;">
                                    Email gửi tự động, vui lòng không trả lời.
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
