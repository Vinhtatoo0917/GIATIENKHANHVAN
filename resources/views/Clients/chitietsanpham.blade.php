@extends('Layouts.layouttranguser')

@section('content')
<style>
    :root {
        --pink: #D9A1AC;
        --pink-2: #F6E6EA;
        --ink: #53363C;
        --muted: #7A4E56;
        --border: #EED6DC;
    }

    body {
        font-family: Inter, sans-serif;
        color: var(--ink);
        background: #FFF8FA;
    }

    .serif {
        font-family: "Playfair Display", Georgia, serif;
    }

    .soft-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(8px);
    }

    .chip {
        border: 1px solid var(--border);
        padding: .35rem .6rem;
        border-radius: .7rem;
        font-size: .8rem;
    }

    .thumbs {
        display: flex;
        overflow-x: auto;
        gap: 12px;
        padding: 8px;
        scroll-behavior: smooth;
    }

    .thumbs::-webkit-scrollbar {
        display: none;
    }

    .thumb {
        flex: 0 0 auto;
        width: 120px;
        aspect-ratio: 4/3;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid var(--border);
        transition: transform .2s, border-color .2s;
    }

    .thumb:hover {
        transform: scale(1.05);
        border-color: var(--pink);
    }

    #lightbox img {
        transition: opacity .3s ease;
    }
</style>
<main class="max-w-7xl mx-auto px-4 md:px-6 py-12 grid lg:grid-cols-2 gap-10 items-start">

    <section>
        <div class="rounded-2xl overflow-hidden border soft-card" style="border-color:var(--border)">
            <div class="relative w-full aspect-[4/3] overflow-hidden">
                <img id="main-img" src=""
                    class="absolute inset-0 w-full h-full object-cover cursor-pointer transition-opacity duration-300"
                    onclick="openLightbox(currentIndex)" />
            </div>
        </div>

        <div class="relative mt-3 border rounded-2xl p-3 soft-card" style="border-color:var(--border)">
            <button onclick="scrollThumbs(-1)"
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white shadow rounded-full w-7 h-7 grid place-items-center">‹</button>
            <div class="thumbs" id="thumbs"></div>
            <button onclick="scrollThumbs(1)"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white shadow rounded-full w-7 h-7 grid place-items-center">›</button>
        </div>
    </section>

    <section>
        <h1 class="serif text-3xl md:text-4xl font-bold">{{$sanpham->TENGIATIEN}}</h1>

        <div class="mt-3 flex flex-wrap items-center gap-2">
            <span class="chip">
                Màu sắc:
                <b>
                    @foreach($danhsachmau as $index => $item)
                    {{ $item->ten_mau }}@if(!$loop->last), @endif
                    @endforeach
                </b>
            </span>
            <span class="chip">Hoa: <b>{{$sanpham->HOATUOI}}</b></span>
            <span class="chip">Cổng: <b>{{$sanpham->CONGGIATIEN}}</b></span>
            <span class="chip">Background: <b>{{$sanpham->BACKGOUNDCHUPHINHNGOAICONG}}</b></span>
        </div>

        <div class="mt-3 flex items-baseline gap-2">
            <div class="mt-3 flex items-baseline gap-1">
                <span class="text-xl font-bold text-[var(--pink)]">
                    {{ number_format($sanpham->GIATIEN / 1000000, 1) }} triệu
                </span>
            </div>
            <span class="text-xs opacity-70" style="color:var(--muted)">/ gói</span>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="#contact" class="px-4 py-2 rounded-xl shadow-sm"
                style="background:var(--pink);color:#3d2a2e">Liên hệ tư vấn</a>
            <button class="px-4 py-2 rounded-xl border" style="border-color:var(--border);color:var(--muted)"
                onclick="window.history.back()">← Quay lại</button>
        </div>

        <div class="mt-8 grid md:grid-cols-2 gap-6">
            <div class="rounded-2xl border soft-card p-5" style="border-color:var(--border)">
                <h3 class="font-semibold mb-3">Thông số</h3>
                <ul class="space-y-2 text-sm" style="color:var(--muted)">
                    <li>Số ghế: <b>{{$sanpham->SOGHE}}</b></li>
                    <li>Số bàn: <b>{{$sanpham->SOBAN}}</b></li>
                    <li>Sản phẩm đi kèm: <span>{{$sanpham->CACSANPHAMDIKEM}}</span></li>
                </ul>
            </div>
            <div class="rounded-2xl border soft-card p-5" style="border-color:var(--border)">
                <h3 class="font-semibold mb-3">Mô tả</h3>
                <p class="text-sm leading-relaxed" style="color:var(--muted)">
                    {{$sanpham->MOTA}}
                </p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="font-semibold mb-2">Màu sắc khả dụng</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($danhsachmau as $item)
                <button class="chip" data-idmau="{{$item->id_mau}}" onclick="sanphamtheomau(this)">{{$item->ten_mau}}</button>
                @endforeach
            </div>
        </div>
    </section>
</main>

<!-- LIGHTBOX -->
<div id="lightbox"
    class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 transition-all duration-300">
    <button onclick="closeLightbox()" class="absolute top-5 right-5 text-white text-3xl">✕</button>
    <button onclick="prevImage()" class="absolute left-5 text-white text-4xl px-3">‹</button>
    <img id="lightbox-img" src="" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg opacity-0">
    <button onclick="nextImage()" class="absolute right-5 text-white text-4xl px-3">›</button>
</div>

<footer class="py-10 text-sm text-center" style="color:var(--muted)">
    © <span id="y"></span> Gia Tiên Khánh Vân • Hotline: 09xx xxx xxx
</footer>
@endsection

@push('scripts')
<script>
    document.getElementById('y').textContent = new Date().getFullYear();
    const duongDanAnh = "{{ $sanpham->DUONGDANANH }}";
    const images = duongDanAnh.split('|').map(s => s.trim()).filter(Boolean);

    const main = document.getElementById("main-img");
    main.src = images[0];

    const thumbsContainer = document.getElementById("thumbs");
    let currentIndex = 0;

    images.forEach((src, i) => {
        const div = document.createElement("div");
        div.className = "thumb";
        div.innerHTML = `<img src="${src}" class="w-full h-full object-cover">`;
        div.onclick = () => setMain(i);
        thumbsContainer.appendChild(div);
    });

    function setMain(i) {
        currentIndex = i;
        const main = document.getElementById("main-img");
        main.style.opacity = 0;
        setTimeout(() => {
            main.src = images[i];
            main.onload = () => main.style.opacity = 1;
        }, 150);
    }

    function scrollThumbs(dir) {
        thumbsContainer.scrollBy({
            left: dir * 150,
            behavior: "smooth"
        });
    }

    function openLightbox(i) {
        currentIndex = i;
        const box = document.getElementById("lightbox");
        const img = document.getElementById("lightbox-img");
        img.src = images[i];
        box.classList.remove("hidden");
        box.classList.add("flex");
        setTimeout(() => img.style.opacity = 1, 100);
    }

    function closeLightbox() {
        const box = document.getElementById("lightbox");
        box.classList.add("hidden");
        box.classList.remove("flex");
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        updateLightbox();
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateLightbox();
    }

    function updateLightbox() {
        const img = document.getElementById("lightbox-img");
        img.style.opacity = 0;
        setTimeout(() => {
            img.src = images[currentIndex];
            img.onload = () => img.style.opacity = 1;
        }, 150);
    }

    document.addEventListener("keydown", e => {
        if (e.key === "ArrowRight") nextImage();
        if (e.key === "ArrowLeft") prevImage();
        if (e.key === "Escape") closeLightbox();
    });

    function sanphamtheomau(btn) {
        const idmau = btn.dataset.idmau;
        window.location.href = `/Giatien/sanphamtheomau/${idmau}`;
    }
</script>
@endpush