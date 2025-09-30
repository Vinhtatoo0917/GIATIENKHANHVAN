<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đăng nhập Admin – Gia Tiên Khánh Vân</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet" />
    @vite('resources/css/Admin/dangnhap.css')
</head>

<body class="min-h-screen bg-app">
    <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full blur-[80px] opacity-60 blob"
        style="background:var(--pink)"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full blur-[80px] opacity-70 blob"
        style="background:var(--pink-2)"></div>

    <main class="relative z-10 min-h-screen grid place-items-center p-4">
        <section class="w-full max-w-md soft card rounded-3xl p-6 md:p-8 gold-ring">
            <header class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-2xl grid place-items-center gold-ring" style="background:var(--pink)">💮
                </div>
                <div>
                    <div class="serif text-2xl leading-6">Gia Tiên Decor</div>
                    <div class="text-[11px] tracking-[.18em] uppercase" style="color:var(--muted)">Admin Login</div>
                </div>
            </header>

            <form id="loginForm" class="grid gap-4">
                @csrf
                <div>
                    <label class="text-sm font-medium">Email hoặc Số điện thoại</label>
                    <input id="username" class="mt-1 w-full field rounded-xl px-3 py-2"
                        placeholder="vd: admin@example.com" autocomplete="username" required />
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium">Mật khẩu</label>
                        <button type="button" id="togglePass" class="text-xs hover:underline"
                            style="color:var(--muted)">Hiện</button>
                    </div>
                    <div class="mt-1 relative">
                        <input id="password" type="password" class="w-full field rounded-xl px-3 py-2 pr-10"
                            placeholder="••••••••" autocomplete="current-password" required />
                        <svg id="capsIcon" xmlns="http://www.w3.org/2000/svg"
                            class="absolute right-3 top-2.5 w-5 h-5 opacity-0 transition" viewBox="0 0 24 24"
                            fill="none" stroke="#C58B94" stroke-width="2">
                            <path d="M4 12l8-8 8 8" />
                            <path d="M12 20V4" />
                        </svg>
                    </div>
                    <div id="error" class="hidden mt-2 text-sm px-3 py-2 rounded-lg"
                        style="color:#8a1c30; background:#fde7ec; border:1px solid #f7c6d1"></div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="inline-flex items-center gap-2">
                        <input id="remember" type="checkbox" class="accent-[var(--pink)]" /> Ghi nhớ đăng nhập
                    </label>
                    <a href="{{ route('quenmatkhau')}}" class="hover:underline" style="color:var(--muted)">Quên mật khẩu?</a>
                </div>
                <button id="btnLogin" class="btn btn-primary mt-1">
                    <span class="lbl">Đăng nhập</span>
                    <span class="spin hidden ml-2 inline-block w-4 h-4 border-2 border-current border-t-transparent rounded-full animate-spin align-[-2px]"></span>
                </button>
            </form>

            <div class="mt-6 text-xs text-center" style="color:var(--muted)">
                Gợi ý demo: <span class="badge">admin@example.com</span> / <span class="badge">123456</span>
            </div>

            <footer class="mt-6 text-center text-xs" style="color:var(--muted)">© <span id="y"></span> Gia Tiên Decor
            </footer>
        </section>
    </main>

    <script>
        const username = document.getElementById('username');
        const password = document.getElementById('password');
        const errorBox = document.getElementById('error');
        const btnlogin = document.getElementById('btnLogin');
        const remember = document.getElementById('remember');
        const lbl = btnlogin.querySelector('.lbl');
        const spin = btnlogin.querySelector('.spin');

        document.getElementById('togglePass').onclick = () => {
            password.type = password.type === 'password' ? 'text' : 'password';
            document.getElementById('togglePass').textContent = password.type === 'password' ? 'Hiện' : 'Ẩn';
        };

        function sleep(ms) {
            return new Promise(r => setTimeout(r, ms));
        }

        function showBtnLoading(on = true) {
            if (on) {
                btnlogin.disabled = true;
                lbl.textContent = 'Đang đăng nhập...';
                spin.classList.remove('hidden');
            } else {
                btnlogin.disabled = false;
                lbl.textContent = 'Đăng nhập';
                spin.classList.add('hidden');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', async (e) => {

            const token = document.querySelector('input[name="_token"]').value;
            e.preventDefault();
            errorBox.textContent = "";

            let usernameresponse = username.value.trim();
            let passwordresponse = password.value.trim();
            let rememberresponse = remember.checked;

            if (!username || !password) {
                errorBox.textContent = "Vui lòng nhập đầy đủ tài khoản và mật khẩu.";
                return;
            }

            if (password.length < 8 || password.length > 30) {
                errorBox.textContent = "Mật khẩu của bạn không được nhỏ 8 kí tự và lớn hơn 30 kí tự !!!";
                return;
            }

            showBtnLoading(true);

            await sleep(1500);

            try {
                const response = await fetch("/Admin/dangnhap", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({
                        usernameresponse,
                        passwordresponse,
                        rememberresponse
                    })
                });

                const data = await response.json();

                if (data.success) {
                    window.location.href = data.redirect_url || "/";
                } else {
                    errorBox.textContent = result.message || "Sai tài khoản hoặc mật khẩu.";
                    errorBox.style.display = "block";
                    showBtnLoading(false);
                }
            } catch (err) {
                errorBox.textContent = "Sai tài khoản hoặc mật khẩu.";
                errorBox.style.display = "block";
                showBtnLoading(false);
                console.error(err);
            };
        });
    </script>
</body>

</html>