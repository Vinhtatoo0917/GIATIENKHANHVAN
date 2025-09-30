<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đặt lại mật khẩu • Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --pink: #D9A1AC;
            --pink-2: #F6E6EA;
            --ink: #53363C;
            --muted: #7A4E56;
            --border: #EED6DC;
        }

        body {
            font-family: Inter, system-ui, Segoe UI, Roboto, Helvetica, Arial;
            color: var(--ink);
        }

        .soft-card {
            background: rgba(255, 255, 255, .72);
            backdrop-filter: blur(10px);
        }

        .gold-ring {
            position: relative;
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
            mask-composite: exclude;
            pointer-events: none;
        }

        .lift {
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(121, 76, 86, .12);
        }
    </style>
</head>

<body class="min-h-screen bg-[conic-gradient(at_120%_-20%,_#fff_0,_#fff_40%,_#FDF6F8_60%,_#fff_100%)]">
    <main class="max-w-xl mx-auto px-4 py-10">
        <a href="{{ route('dangnhapadmin') }}" class="inline-flex items-center gap-2 text-sm hover:underline"
            style="color:var(--muted)">
            ← Quay lại đăng nhập
        </a>

        <section class="mt-6 soft-card border rounded-3xl p-6 md:p-8 gold-ring" style="border-color:var(--border)">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-2xl grid place-items-center gold-ring" style="background:var(--pink)">🔑
                </div>
                <div>
                    <h1 class="serif text-2xl md:text-3xl font-bold">Xác nhận OTP & Đặt lại mật khẩu</h1>
                    <p class="text-sm mt-1" style="color:var(--muted)">
                        Nhập email, mã OTP, và mật khẩu mới để hoàn tất việc đặt lại.
                    </p>
                </div>
            </div>

            <form id="formReset" class="space-y-4" autocomplete="off">
                <div>
                    <label class="text-sm" style="color:var(--muted)">Email</label>
                    <input type="email" name="email" value="{{ $emailcaplaimatkhau ?? '' }}" readonly
                        class="mt-1 w-full px-3 py-2 rounded-xl border focus:outline-none"
                        style="border-color:var(--border)">
                </div>
                <div>
                    <label class="text-sm" style="color:var(--muted)">Mã OTP</label>
                    <input type="text" name="otp" id="otp" maxlength="6" required placeholder="Nhập mã OTP"
                        class="mt-1 w-full px-3 py-2 rounded-xl border focus:outline-none"
                        style="border-color:var(--border)">
                </div>
                <div>
                    <label class="text-sm" style="color:var(--muted)">Mật khẩu mới</label>
                    <input type="password" name="password" id="password" required placeholder="Mật khẩu mới"
                        class="mt-1 w-full px-3 py-2 rounded-xl border focus:outline-none"
                        style="border-color:var(--border)">
                </div>
                <div>
                    <label class="text-sm" style="color:var(--muted)">Xác nhận mật khẩu mới</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Nhập lại mật khẩu"
                        class="mt-1 w-full px-3 py-2 rounded-xl border focus:outline-none"
                        style="border-color:var(--border)">
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl shadow-sm lift"
                        style="background:var(--pink);color:#3d2a2e">Xác nhận</button>
                    <button type="reset" class="px-5 py-2.5 rounded-xl border"
                        style="border-color:var(--border)">Xoá</button>
                </div>
            </form>
        </section>
    </main>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.getElementById('formReset').addEventListener('submit', async (e) => {
            e.preventDefault();

            const otpinput = document.getElementById('otp').value;
            const matkhaum = document.getElementById('password').value;
            const matkhaunl = document.getElementById('password_confirmation').value;

            try {
                fetch('/Admin/caplaimatkhausuccess', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-TOKEN": csrf
                        },
                        body: JSON.stringify({
                            'otp': otpinput,
                            'matkhaumoi': matkhaum,
                            'matkhaunhaplai': matkhaunl
                        })
                    })
                    .then(Response => Response.json())
                    .then(async data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Thành công',
                                text: data.message,
                                icon: 'success',
                                timer: 1200,
                                showConfirmButton: false,
                                color: '#53363C',
                                background: '#FFFFFF',
                            });
                            await new Promise(r => setTimeout(r, 1500));
                            window.location.href = data.url;
                        } else {
                            Swal.fire({
                                title: 'Thất bại',
                                text: data.message,
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
                    title: 'Thất bại',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'Đóng',
                    confirmButtonColor: '#D9A1AC',
                    color: '#53363C',
                    background: '#FFFFFF',
                });
            }
        })
    </script>
</body>

</html>