<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- Tailwind CDN for quick layout -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Elegant fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/Client/trangchu.css'])
</head>

<body class="min-h-screen bg-[conic-gradient(at_120%_-20%,_#fff_0,_#fff_40%,_#FDF6F8_60%,_#fff_100%)]">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 border-b/50 border-b soft-card" style="border-color:var(--border)">
        <div class="max-w-7xl mx-auto px-4 md:px-6 h-16 flex items-center justify-between">
            <a href="{{route('trangchu')}}" class="flex items-center gap-3">
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
                <a href="{{route('trangchu')}}" class="px-3 py-2 rounded-xl text-sm hover:bg-[var(--pink-2)]"
                    style="color:var(--muted)">Trang chủ</a>
                <a href="{{route('sanpham')}}" class="px-3 py-2 rounded-xl text-sm hover:bg-[var(--pink-2)]"
                    style="color:var(--muted)">Sản phẩm</a>
                <a href="#contact" class="hidden md:inline-flex px-4 py-2 rounded-xl text-sm font-medium shadow-sm"
                    style="background:var(--pink);color:#3d2a2e">Liên hệ</a>
            </nav>
        </div>
    </header>

    @yield('content')

    <!-- Back to top -->
    <button onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="fixed bottom-5 right-5 rounded-full shadow-lg px-4 py-3 text-sm lift"
        style="background:var(--pink);color:#3d2a2e" aria-label="Lên đầu trang">Lên đầu trang</button>

    @stack('scripts')
</body>

</html>