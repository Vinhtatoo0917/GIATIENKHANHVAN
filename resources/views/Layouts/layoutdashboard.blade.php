<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard • Gia Tiên Khánh Vân</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/Admin/dashboard.css'])
</head>

<body class="min-h-screen bg-[conic-gradient(at_120%_-20%,_#fff_0,_#fff_40%,_#FDF6F8_60%,_#fff_100%)] text-gray-800">

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-[260px_1fr]">
        <!-- Sidebar -->
        <aside class="border-r md:sticky md:top-0 md:h-screen p-6 border bg-white/80 backdrop-blur">
            <div class="flex items-center gap-3 px-1">
                <div class="w-11 h-11 rounded-2xl grid place-items-center text-xl font-bold shadow-inner"
                    style="background:var(--pink)">💒</div>
                <div>
                    <div class="serif text-lg leading-5 font-semibold">Gia Tiên Khánh Vân</div>
                    <div class="text-[11px] tracking-[.18em] uppercase" style="color:var(--muted)">
                        ADMIN {{ $nameadmin }}
                    </div>
                </div>
            </div>
            <nav class="mt-8 space-y-2">
                <button onclick="window.location.href='{{route('dashboard')}}'" class="menu-btn w-full flex items-center gap-3 px-3 py-2 rounded-xl transition hover:bg-[var(--pink-2)]">
                    📊 <span>Dashboard</span>
                </button>
                <button onclick="window.location.href='{{route('quanlygiatien') }}'" class="menu-btn w-full flex items-center gap-3 px-3 py-2 rounded-xl transition hover:bg-[var(--pink-2)]">
                    🪞 <span>Sản phẩm</span>
                </button>
                <button
                    onclick="window.location.href='{{ route('quanlyanhdautrang') }}'"
                    class="menu-btn w-full flex items-center gap-3 px-3 py-2 rounded-xl transition hover:bg-[var(--pink-2)]">
                    🖼️ <span>Ảnh</span>
                </button>
                <button onclick="window.location.href='{{ route('quanlymausac') }}'" class="menu-btn w-full flex items-center gap-3 px-3 py-2 rounded-xl transition hover:bg-[var(--pink-2)]">
                    🎨 <span>Màu sắc</span>
                </button>
                <button onclick="showSection(event, 'contacts')" class="menu-btn w-full flex items-center gap-3 px-3 py-2 rounded-xl transition hover:bg-[var(--pink-2)]">
                    📇 <span>Liên hệ</span>
                </button>
            </nav>
        </aside>

        <!-- Main -->
        <main class="min-h-screen p-6 space-y-10 bg-white/60">
            @yield('content')
        </main>
    </div>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        function showSection(e, id) {
            document.querySelectorAll(".section").forEach(el => el.classList.add("hidden"));
            document.getElementById(id).classList.remove("hidden");

            document.querySelectorAll(".menu-btn").forEach(btn => btn.classList.remove("bg-[var(--pink-2)]", "font-semibold"));
            e.currentTarget.classList.add("bg-[var(--pink-2)]", "font-semibold");
        }

        // ===== Modal helpers =====
        document.querySelectorAll('[data-open]').forEach(b => b.addEventListener('click', () => document.getElementById(b.dataset.open).showModal()));
        document.querySelectorAll('[data-close]').forEach(b => b.addEventListener('click', () => b.closest('dialog').close()));

        function toast(msg) {
            const t = document.getElementById('toast');
            t.firstElementChild.textContent = msg;
            t.classList.remove('hidden');
            setTimeout(() => t.classList.add('hidden'), 1200);
        }

        // ===== Preview nhiều ảnh (add) =====
        const giatienFiles = document.getElementById('giatienFiles');
        const giatienPreviewWrap = document.getElementById('giatienPreviewWrap');
        giatienFiles?.addEventListener('change', () => {
            giatienPreviewWrap.innerHTML = '';
            [...giatienFiles.files].forEach(f => {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(f);
                img.className = "rounded-xl border";
                giatienPreviewWrap.appendChild(img);
            });
        });

        // ===== Preview nhiều ảnh (edit) =====
        const editFiles = document.getElementById('editFiles');
        const editPreviewWrap = document.getElementById('editPreviewWrap');
        editFiles?.addEventListener('change', () => {
            editPreviewWrap.innerHTML = '';
            [...editFiles.files].forEach(f => {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(f);
                img.className = "rounded-xl border";
                editPreviewWrap.appendChild(img);
            });
        });

        // ===== Preview ảnh sửa Gallery (1 ảnh) =====
        const editImageInput = document.getElementById('editImageInput');
        const editImagePreview = document.getElementById('editImagePreview');
        editImageInput?.addEventListener('change', () => {
            const f = editImageInput.files?.[0];
            if (!f) {
                editImagePreview.classList.add('hidden');
                return;
            }
            const img = editImagePreview.querySelector('img');
            img.src = URL.createObjectURL(f);
            editImagePreview.classList.remove('hidden');
        });
    </script>

    @stack('scripts')
</body>

</html>