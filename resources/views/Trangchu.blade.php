<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }}</title>

    <!-- Tailwind CDN for quick layout -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Elegant fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/Client/trangchu.css'])
</head>

<body class="min-h-screen bg-[conic-gradient(at_120%_-20%,_#fff_0,_#fff_40%,_#FDF6F8_60%,_#fff_100%)]">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 border-b/50 border-b soft-card" style="border-color:var(--border)">
        <div class="max-w-7xl mx-auto px-4 md:px-6 h-16 flex items-center justify-between">
            <a href="#home" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl grid place-items-center gold-ring" style="background:var(--pink)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="#5D3A41" stroke-width="2">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                </div>
                <div>
                    <div class="serif text-xl leading-5">Gia Tiên Khánh Vân</div>
                    <div class="text-[11px] tracking-[.18em] uppercase" style="color:var(--muted)">Wedding • Ancestral
                        Ceremony</div>
                </div>
            </a>
            <nav class="flex items-center gap-2 md:gap-4">
                <a href="#home" class="px-3 py-2 rounded-xl text-sm hover:bg-[var(--pink-2)]"
                    style="color:var(--muted)">Trang chủ</a>
                <a href="#products" class="px-3 py-2 rounded-xl text-sm hover:bg-[var(--pink-2)]"
                    style="color:var(--muted)">Sản phẩm</a>
                <a href="#contact" class="hidden md:inline-flex px-4 py-2 rounded-xl text-sm font-medium shadow-sm"
                    style="background:var(--pink);color:#3d2a2e">Liên hệ</a>
            </nav>
        </div>
    </header>

    <!-- HERO -->
    <section id="home" class="relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full hero-blob" style="background:var(--pink)"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full hero-blob" style="background:var(--pink-2)">
        </div>

        <div class="max-w-7xl mx-auto px-4 md:px-6 py-16 md:py-24 grid md:grid-cols-2 gap-10 items-center">
            <div data-anim style="--d:.05s">
                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-medium border soft-card"
                    style="background:#F8EEF1;color:var(--muted);border-color:var(--border)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M5 3l4 9-4 9 7-9-7-9h14" />
                    </svg>
                    Dịch vụ trang trí gia tiên
                </span>
                <h1 class="mt-4 serif text-4xl md:text-6xl font-bold leading-tight">
                    Ngày vui trọn vẹn
                    <span class="block gold-text">đậm chất truyền thống</span>
                </h1>
                <p class="mt-5 text-base md:text-lg max-w-xl" style="color:var(--muted)">
                    Phong cách đa dạng, kết hợp tinh tế giữa truyền thống và hiện đại
                </p>
                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <a href="#products" class="px-5 py-3 rounded-xl text-base font-medium shadow-sm lift"
                        style="background:var(--pink);color:#3d2a2e">Xem gói dịch vụ</a>
                    <a href="#contact" class="px-5 py-3 rounded-xl text-base font-medium border lift"
                        style="border-color:var(--border);color:var(--muted)">
                        <span class="inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path
                                    d="M22 16.92V21a2 2 0 0 1-2.18 2A19.72 19.72 0 0 1 3 6.18 2 2 0 0 1 5 4h4.09A2 2 0 0 1 11 5.72l1 2.27a2 2 0 0 1-.45 2.18l-1.27 1.27a16 16 0 0 0 6.36 6.36l1.27-1.27a2 2 0 0 1 2.18-.45l2.27 1A2 2 0 0 1 22 16.92z" />
                            </svg>
                            Tư vấn nhanh
                        </span>
                    </a>
                </div>
                <div class="mt-7 grid sm:grid-cols-2 gap-3 text-sm" style="color:var(--muted)">
                    <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full"
                            style="background:var(--gold)"></span> Hoa tươi/hoa lụa cao cấp</div>
                    <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full"
                            style="background:var(--gold)"></span> Thiết kế theo không gian nhà</div>
                    <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full"
                            style="background:var(--gold)"></span> Đúng giờ – gọn gàng – sạch</div>
                    <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full"
                            style="background:var(--gold)"></span> Hợp đồng minh bạch</div>
                </div>
            </div>
            <div data-anim style="--d:.12s">
                <div class="relative">
                    <div class="absolute -inset-1 rounded-3xl opacity-60"
                        style="background:linear-gradient(90deg, var(--pink-2), var(--pink));filter:blur(22px)"></div>
                    <div class="relative soft-card rounded-3xl p-5 border shadow-sm gold-ring"
                        style="border-color:var(--border)">
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($listanh as $item)
                            <div class="relative aspect-[4/3] rounded-2xl border overflow-hidden"
                                style="border-color:var(--border);background:#000">
                                <div class="absolute inset-0 bg-center bg-cover" style="background-image:url('{{ $item->DUONGDAN }}')"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-black/10 to-transparent"></div>
                                <div class="absolute bottom-3 left-3 right-3">
                                    <span
                                        class="block text-center px-3 py-1.5 text-xs md:text-sm font-medium rounded-xl soft-card break-words leading-snug"
                                        style="color:var(--ink);background:rgba(255,255,255,.82)">
                                        {{$item->NAME}}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <div class="divider max-w-7xl mx-auto"></div>

    <!-- FEATURES (elegant) -->
    <section class="py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 md:px-6 grid md:grid-cols-3 gap-6">
            <article data-anim class="soft-card rounded-2xl p-6 border lift" style="border-color:var(--border)">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 rounded-xl" style="background:var(--pink-2)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="#7A4E56" stroke-width="2">
                            <path d="M8 21h8M12 17v4M7 8l5-5 5 5M5 10h14l-1 10H6L5 10z" />
                        </svg>
                    </div>
                    <h4 class="text-base font-semibold" style="color:var(--ink)">Phong cách tinh tế</h4>
                </div>
                <p class="text-sm leading-relaxed" style="color:var(--muted)">Trang trí cân đối, chọn chất liệu sang trọng, phối hợp nhiều tông màu nhã nhặn để tạo không gian hài hòa và ấm cúng.</p>
            </article>
            <article data-anim style="--d:.06s" class="soft-card rounded-2xl p-6 border lift"
                style="border-color:var(--border)">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 rounded-xl" style="background:var(--pink-2)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="#7A4E56" stroke-width="2">
                            <path d="M20 6a2 2 0 0 1-2 2H6a2 2 0 1 1 0-4h12a2 2 0 0 1 2 2z" />
                            <path d="M4 8v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8" />
                        </svg>
                    </div>
                    <h4 class="text-base font-semibold" style="color:var(--ink)">Truyền thống & hiện đại</h4>
                </div>
                <p class="text-sm leading-relaxed" style="color:var(--muted)">Giữ trọn lễ nghi, thêm điểm nhấn hiện đại
                    để ảnh cưới lên hình đẹp.</p>
            </article>
            <article data-anim style="--d:.12s" class="soft-card rounded-2xl p-6 border lift"
                style="border-color:var(--border)">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 rounded-xl" style="background:var(--pink-2)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="#7A4E56" stroke-width="2">
                            <path d="M3 12h18M3 6h10M3 18h10" />
                        </svg>
                    </div>
                    <h4 class="text-base font-semibold" style="color:var(--ink)">Setup nhanh – gọn</h4>
                </div>
                <p class="text-sm leading-relaxed" style="color:var(--muted)">Đến sớm, hoàn tất đúng giờ vàng</p>
            </article>
        </div>
    </section>

    <!-- PRODUCTS -->
    <section id="products" class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 md:px-6 flex items-end justify-between mb-6 md:mb-8">
            <div>
                <h2 class="serif text-3xl md:text-4xl font-bold">Gói sản phẩm</h2>
                <p class="text-sm md:text-base mt-2" style="color:var(--muted)">Chọn gói phù hợp – có thể tùy biến theo
                    nhu cầu và không gian.</p>
            </div>
            <a href="#contact" class="px-4 py-2 rounded-xl text-sm font-medium shadow-sm lift"
                style="background:var(--pink);color:#3d2a2e">Nhận bảng giá</a>
        </div>

        <div class="max-w-7xl mx-auto px-4 md:px-6 grid md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <article data-anim class="relative rounded-2xl overflow-hidden border soft-card lift gold-ring"
                style="border-color:var(--border)">
                <span class="ribbon">Phổ biến</span>
                <button class="w-full aspect-[4/3] relative group" onclick="alert('Xem chi tiết Gói Gia Tiên Cơ Bản')">
                    <img src="backgroundchuphinh.jpg" alt="Gói Gia Tiên Cơ Bản"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
                </button>
                <div class="p-6">
                    <h3 class="text-lg font-semibold">Gói Gia Tiên Cơ Bản</h3>
                    <p class="text-sm mt-1" style="color:var(--muted)">
                        Phông nền + bàn thờ gia tiên + bàn ghế phủ nơ, hoa lụa.
                    </p>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-2xl serif">3.9 triệu</span>
                        <span class="text-xs opacity-70" style="color:var(--muted)">/ gói</span>
                    </div>
                </div>
            </article>

            <!-- Card 2 -->
            <article data-anim style="--d:.06s" class="relative rounded-2xl overflow-hidden border soft-card lift gold-ring"
                style="border-color:var(--border)">
                <span class="ribbon">Hoa tươi</span>
                <button class="w-full aspect-[4/3] relative group" onclick="alert('Xem chi tiết Gói Hoa Tươi Nâng Cao')">
                    <img src="bangiatien2ho.jpg" alt="Gói Hoa Tươi Nâng Cao"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
                </button>
                <div class="p-6">
                    <h3 class="text-lg font-semibold">Gói Hoa Tươi Nâng Cao</h3>
                    <p class="text-sm mt-1" style="color:var(--muted)">
                        Trang trí hoa tươi chọn lọc, phông nền tinh tế, bàn ghế đồng bộ.
                    </p>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-2xl serif">6.9 triệu</span>
                        <span class="text-xs opacity-70" style="color:var(--muted)">/ gói</span>
                    </div>
                </div>
            </article>

            <!-- Card 3 -->
            <article data-anim style="--d:.12s" class="relative rounded-2xl overflow-hidden border soft-card lift gold-ring"
                style="border-color:var(--border)">
                <span class="ribbon">Cao cấp</span>
                <button class="w-full aspect-[4/3] relative group" onclick="alert('Xem chi tiết Gói Trọn Gói Cao Cấp')">
                    <img src="backgroundchuphinh.jpg" alt="Gói Trọn Gói Cao Cấp"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
                </button>
                <div class="p-6">
                    <h3 class="text-lg font-semibold">Gói Trọn Gói Cao Cấp</h3>
                    <p class="text-sm mt-1" style="color:var(--muted)">
                        Gia tiên + cổng hoa + bàn hai họ đồng bộ, tư vấn phối cảnh riêng.
                    </p>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-2xl serif">9.9 triệu+</span>
                        <span class="text-xs opacity-70" style="color:var(--muted)">/ gói</span>
                    </div>
                </div>
            </article>

        </div>
    </section>

    <!-- NOTES / FAQ -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 md:px-6 rounded-3xl border soft-card p-6 md:p-8 gold-ring"
            style="border-color:var(--border)">
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <h4 class="font-semibold">Sản phẩm gia tiên</h4>
                    <p class="text-sm mt-1" style="color:var(--muted)">
                        Trang trí gia tiên chuẩn lễ nghi, hoa và phụ kiện đầy đủ.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold">background</h4>
                    <p class="text-sm mt-1" style="color:var(--muted)">
                        phông nền chụp hình sang trọng trong nhà.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold">Bàn gia tiên & cổng</h4>
                    <p class="text-sm mt-1" style="color:var(--muted)">
                        Trang trí bàn gia tiên hai họ cân đối, cổng hoa gia tiên hiện đại hoặc truyền thống.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="contact" class="py-16">
        <div class="max-w-7xl mx-auto px-4 md:px-6 text-center rounded-3xl border soft-card p-8 md:p-12 gold-ring"
            style="border-color:var(--border);background:linear-gradient(90deg, #fff, var(--pink-2))">
            <div class="text-xs tracking-[.28em] uppercase" style="color:var(--muted)">Liên hệ tư vấn</div>
            <h3 class="serif text-3xl md:text-4xl font-bold mt-3">Đặt lịch & nhận báo giá chi tiết</h3>
            <p class="mt-3 text-sm md:text-base max-w-2xl mx-auto" style="color:var(--muted)">Gọi điện hoặc nhắn
                Zalo/Facebook. Chúng tôi sẽ gợi ý phối cảnh theo không gian nhà bạn.</p>
            <div class="mt-7 flex flex-wrap gap-3 justify-center">
                <a class="px-5 py-3 rounded-xl shadow-sm lift" style="background:var(--pink);color:#3d2a2e">📞 09xx xxx
                    xxx</a>
                <a class="px-5 py-3 rounded-xl border lift"
                    style="border-color:var(--border);color:var(--muted)">Facebook Page</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-10">
        <div
            class="max-w-7xl mx-auto px-4 md:px-6 flex flex-col md:flex-row items-center justify-between gap-4 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl grid place-items-center" style="background:var(--pink)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                        stroke="#5D3A41" stroke-width="2">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                </div>
                <span style="color:var(--muted)">Gia Tiên Khánh Vân</span>
            </div>
            <div class="flex items-center gap-3" style="color:var(--muted)">
                <a href="#home" class="hover:underline">Trang chủ</a>
                <a href="#products" class="hover:underline">Sản phẩm</a>
            </div>
        </div>
    </footer>

    <!-- Back to top -->
    <button onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="fixed bottom-5 right-5 rounded-full shadow-lg px-4 py-3 text-sm lift"
        style="background:var(--pink);color:#3d2a2e" aria-label="Lên đầu trang">Lên đầu trang</button>

    <script>
        document.getElementById('y').textContent = new Date().getFullYear();
        // reveal on scroll
        const io = new IntersectionObserver((es) => es.forEach(e => {
            if (e.isIntersecting) {
                e.target.style.opacity = 1;
            }
        }), {
            threshold: .12
        });
        document.querySelectorAll('[data-anim]').forEach(el => io.observe(el));
    </script>
</body>

</html>