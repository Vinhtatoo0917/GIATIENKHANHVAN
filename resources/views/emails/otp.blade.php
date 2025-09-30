@php
// các biến nên truyền từ Mailable:
// $otp (string|int), $expiresMinutes (int), $brandName (string), $supportEmail (string|null)
$brandName = $brandName ?? 'Gia Tiên Khánh Vân';
$expiresMinutes = $expiresMinutes ?? 5;
$supportEmail = $supportEmail ?? null;
@endphp
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mã xác nhận OTP</title>
    <style>
        /* Email-safe: tránh class phức tạp, ưu tiên inline + thuộc tính cũ cho Outlook */
        body {
            margin: 0;
            padding: 0;
            background: #FDF6F8;
            color: #53363C;
        }

        table {
            border-collapse: collapse;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #EED6DC;
            box-shadow: 0 8px 28px rgba(121, 76, 86, .15);
        }

        .muted {
            color: #7A4E56;
            font-size: 14px;
            line-height: 1.6;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #E9D9C2, transparent);
        }

        .code-box {
            background: #FFFFFF;
            border-radius: 14px;
            border: 2px dashed #D9A1AC;
        }

        .code {
            letter-spacing: 8px;
            font-size: 28px;
            font-weight: 700;
            color: #53363C;
            font-family: Arial, Helvetica, sans-serif;
        }

        .footer {
            font-size: 12px;
            color: #7A4E56;
        }

        /* Dark mode hints (một số client tôn trọng) */
        @media (prefers-color-scheme: dark) {
            body {
                background: #1b1b1b;
                color: #e8e6e3;
            }

            .card {
                background: #222;
                border-color: #3a2b2f;
                box-shadow: none;
            }

            .muted,
            .footer {
                color: #c9b9bc;
            }

            .code-box {
                background: #1e1e1e;
                border-color: #b77c8a;
            }

            .code {
                color: #fff;
            }

            .divider {
                background: linear-gradient(90deg, transparent, #6e5a40, transparent);
            }
        }
    </style>
    <!--[if mso]>
    <style type="text/css">
      * { font-family: Arial, Helvetica, sans-serif !important; }
    </style>
  <![endif]-->
</head>

<body>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="height:28px;">&nbsp;</td>
        </tr>

        <tr>
            <td align="center" style="text-align:center;">
                <table role="presentation" class="container" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding:0 16px;" align="center">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="card" style="padding:28px;">
                                <tr>
                                    <td align="center" style="text-align:center;">
                                        <!-- Icon -->
                                        <div style="margin-bottom:14px;">
                                            <span style="display:inline-block;width:50px;height:50px;border-radius:16px;
                                   background:#D9A1AC;text-align:center;line-height:50px;font-size:24px;">🔐</span>
                                        </div>

                                        <!-- Title -->
                                        <h1 style="margin:0 0 8px 0;
                               font-family:'Playfair Display', Georgia, serif, Arial;
                               font-size:24px; font-weight:700; color:#53363C;">
                                            Mã xác nhận OTP
                                        </h1>

                                        <!-- Subtitle -->
                                        <p class="muted" style="margin:0 0 16px 0;">
                                            Mã có hiệu lực trong <strong>{{ $expiresMinutes }} phút</strong>. Vui lòng nhập ngay để tiếp tục.
                                        </p>

                                        <!-- Divider -->
                                        <div class="divider" style="margin:16px 0;"></div>

                                        <!-- OTP Box -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="code-box" style="margin:8px 0;">
                                            <tr>
                                                <td align="center" style="padding:18px 12px; text-align:center;">
                                                    <div class="code">{{ $otp }}</div>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Note -->
                                        <p class="muted" style="margin:16px 0 0;">
                                            Nếu bạn không yêu cầu thao tác này, hãy bỏ qua email.
                                            Vì an toàn, <strong>đừng chia sẻ</strong> mã với bất kỳ ai.
                                        </p>

                                        @if($supportEmail)
                                        <div class="divider" style="margin:18px 0;"></div>
                                        <p class="muted" style="margin:0;">
                                            Cần hỗ trợ? Liên hệ:
                                            <a href="mailto:{{ $supportEmail }}" style="color:#B58A5A; text-decoration:none;">
                                                {{ $supportEmail }}
                                            </a>
                                        </p>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <!-- Footer -->
                            <div class="footer" style="text-align:center; margin-top:10px;">
                                © {{ date('Y') }} {{ $brandName }}. All rights reserved.
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="height:28px;">&nbsp;</td>
        </tr>
    </table>
</body>

</html>