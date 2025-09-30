<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quên mật khẩu • Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --pink: #D9A1AC;
            --pink-2: #F6E6EA;
            --ink: #53363C;
            --muted: #7A4E56;
            --border: #EED6DC;
            --gold: #B58A5A;
            --gold-2: #E9D9C2
        }

        body {
            font-family: Inter, system-ui, Segoe UI, Roboto, Helvetica, Arial;
            color: var(--ink)
        }

        .soft-card {
            background: rgba(255, 255, 255, .72);
            backdrop-filter: blur(10px)
        }

        .gold-ring {
            position: relative
        }

        .gold-ring:before {
            content: "";
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, #EAD6C1, rgba(217, 161, 172, .7));
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude
        }

        .lift {
            transition: transform .3s ease, box-shadow .3s ease
        }

        .lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(121, 76, 86, .12)
        }

        .hero-blob {
            filter: blur(70px);
            opacity: .6
        }

        .hero-blob {
            pointer-events: none;
            /* không chặn click */
            z-index: -1;
            /* đẩy ra sau layout */
        }

        /* viền vàng dùng ::before có thể che lên nội dung bên trong, tắt bắt sự kiện */
        .gold-ring:before {
            pointer-events: none;
        }

        /* (tuỳ chọn) đảm bảo khu vực nội dung ở trên các blob */
        main,
        section,
        .soft-card {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body class="min-h-screen bg-[conic-gradient(at_120%_-20%,_#fff_0,_#fff_40%,_#FDF6F8_60%,_#fff_100%)]">

    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full hero-blob" style="background:var(--pink)"></div>
    <div class="absolute -bottom-24 -right-24 w-[28rem] h-[28rem] rounded-full hero-blob"
        style="background:var(--pink-2)"></div>

    <main class="relative max-w-xl mx-auto px-4 md:px-0 py-10">
        <a href="{{ route('dangnhapadmin') }}" class="inline-flex items-center gap-2 text-sm hover:underline"
            style="color:var(--muted)">
            ← Quay lại đăng nhập
        </a>

        <section class="mt-6 soft-card border rounded-3xl p-6 md:p-8 gold-ring" style="border-color:var(--border)">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl grid place-items-center gold-ring" style="background:var(--pink)">🔐
                </div>
                <div>
                    <h1 class="serif text-2xl md:text-3xl font-bold">Quên mật khẩu</h1>
                    <p class="text-sm mt-1" style="color:var(--muted)">Nhập email để nhận mã xác nhận (OTP) và đặt lại
                        mật khẩu.</p>
                </div>
            </div>

            <!-- Bước 1: yêu cầu gửi OTP -->
            <form id="step1" class="mt-6 space-y-4" autocomplete="off">
                <div>
                    <label class="text-sm" style="color:var(--muted)">Email đăng nhập</label>
                    <input name="email" type="email" required placeholder="you@example.com"
                        class="mt-1 w-full px-3 py-2 rounded-xl border focus:outline-none"
                        style="border-color:var(--border)" />
                </div>
                <!-- placeholder captcha (nếu cần) -->
                {{-- tải script (tiếng Việt) --}}
                {!! NoCaptcha::renderJs('vi') !!}

                {{-- chỗ hiển thị captcha --}}
                {!! NoCaptcha::display() !!}

                @error('g-recaptcha-response')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl shadow-sm lift"
                        style="background:var(--pink);color:#3d2a2e">Gửi mã</button>
                    <button type="reset" class="px-5 py-2.5 rounded-xl border"
                        style="border-color:var(--border)">Xoá</button>
                </div>
            </form>
        </section>

        <p class="mt-6 text-center text-sm" style="color:var(--muted)">© <span id="y"></span> Gia Tiên Khánh Vân</p>
    </main>

    <script>
        document.getElementById('y').textContent = new Date().getFullYear();

        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const step1 = document.getElementById('step1');

        step1.addEventListener('submit', async (e) => {
            e.preventDefault();
            const emailresponse = new FormData(step1).get('email');
            if (!emailresponse) return;
            const tokencapcha = document.querySelector('[name="g-recaptcha-response"]')?.value;

            Swal.fire({
                title: 'Gửi mã xác nhận…',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
                color: '#53363C',
                background: '#FFFFFF',
            });

            try {
                await new Promise(r => setTimeout(r, 900));
                fetch('/Admin/quenmatkhauotp', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-TOKEN": csrf
                        },
                        body: JSON.stringify({
                            email: emailresponse,
                            'g-recaptcha-response': tokencapcha
                        })
                    })
                    .then(Response => Response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Đã gửi mã!',
                                text: 'Vui lòng kiểm tra email của bạn.',
                                icon: 'success',
                                timer: 1200,
                                showConfirmButton: false,
                                color: '#53363C',
                                background: '#FFFFFF',
                            });
                            window.location.href = data.url;
                        } else {
                            Swal.fire({
                                title: 'Gửi mã thất bại',
                                text: 'Vui lòng thử lại.',
                                icon: 'error',
                                confirmButtonText: 'Đóng',
                                confirmButtonColor: '#D9A1AC',
                                color: '#53363C',
                                background: '#FFFFFF',
                            });
                        }
                    })
            } catch (e) {
                Swal.fire({
                    title: 'Gửi mã thất bại',
                    text: 'Vui lòng thử lại.',
                    icon: 'error',
                    confirmButtonText: 'Đóng',
                    confirmButtonColor: '#D9A1AC',
                    color: '#53363C',
                    background: '#FFFFFF',
                });
            }
        });
    </script>
</body>

</html>