@extends('Layouts.layouttranguser')

@section('content')
<!-- PRODUCT LIST -->
<section class="py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <!-- Tiêu đề + Nút sắp xếp -->
        <div class="flex items-center justify-between mb-8">
            <h2 class="serif text-3xl md:text-4xl font-bold">Danh sách sản phẩm</h2>
            <div class="mb-6 flex flex-wrap items-end gap-4">
                <!-- Lọc theo giá tiền -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">💰 Lọc theo giá tiền</label>
                    <select id="filterPrice"
                        class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none">
                        <option value="">-- Tất cả --</option>
                        <option value="3000000">≤ 3 triệu</option>
                        <option value="5000000">≤ 5 triệu</option>
                        <option value="10000000">≤ 10 triệu</option>
                        <option value="11000000">> 10 triệu</option>
                    </select>
                </div>

                <!-- Lọc theo màu sắc -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">🎨 Lọc theo màu sắc</label>
                    <select id="filterColor"
                        name="mau"
                        class="min-w-[220px] px-3 py-2 rounded-lg border border-gray-300
               focus:ring-2 focus:ring-[var(--pink)] focus:outline-none bg-white">
                        <option value="">-- Tất cả --</option>
                        @foreach($listmausac as $mau)
                        <option value="{{ $mau->id_mau }}">{{ $mau->ten_mau }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nút tìm kiếm -->
                <div class="self-end">
                    <button id="btnFilter"
                        class="px-5 py-2 rounded-xl bg-[var(--pink)] text-[#3d2a2e] font-semibold shadow hover:opacity-90 transition">
                        🔍 Tìm kiếm
                    </button>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div id="productList" class="grid md:grid-cols-3 gap-6">

            <!-- Card 1 -->
            @foreach($listsanpham as $item)
            <article data-anim class="relative rounded-2xl overflow-hidden border soft-card lift gold-ring"
                style="border-color:var(--border)">
                <button class="w-full aspect-[4/3] relative group" data-id="{{$item->IDGIATIEN}}" onclick="chitietsanpham(this)">
                    <img src="{{$item->LINKANHDAIDIEN}}"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
                </button>
                <div class="p-6">
                    <h3 class="text-lg font-semibold">{{$item->TENGIATIEN}}</h3>
                    <p class="text-sm mt-1" style="color:var(--muted)">
                        {{$item->MOTA}}
                    </p>
                    <div class="mt-3 flex items-baseline gap-2">
                        <div class="mt-3 flex items-baseline gap-1">
                            <span class="text-xl font-bold text-[var(--pink)]">
                                {{ number_format($item->GIATIEN / 1000000, 1) }} triệu
                            </span>
                            <span class="text-sm text-gray-500">/ gói</span>
                        </div>
                        <span class="text-xs opacity-70" style="color:var(--muted)">/ gói</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-10">
    <div
        class="max-w-7xl mx-auto px-4 md:px-6 flex flex-col md:flex-row items-center justify-between gap-4 text-sm">
        <span style="color:var(--muted)">© <span id="y"></span>Gia Tiên Khánh Vân</span>
        <div class="flex items-center gap-3" style="color:var(--muted)">
            <a href="{{route('trangchu')}}" class="hover:underline">Trang chủ</a>
            <a href="{{route('sanpham')}}" class="hover:underline">Sản phẩm</a>
        </div>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    document.getElementById('y').textContent = new Date().getFullYear();

    const btnFilter = document.getElementById('btnFilter');
    const filterPrice = document.getElementById('filterPrice');
    const filterColor = document.getElementById('filterColor');
    const productList = document.getElementById('productList');

    btnFilter.addEventListener('click', async () => {
        const mucgia = filterPrice.value;
        const mau = filterColor.value;

        Swal.fire({
            title: 'Đang lọc sản phẩm...',
            html: 'Vui lòng chờ trong giây lát',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
            color: '#53363C',
            background: '#FFFFFF'
        });

        try {
            const response = await fetch("{{ route('timkiemsanpham') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    mucgia: mucgia,
                    mau: mau
                })
            });

            const data = await response.json();
            Swal.close();

            if (!data.success) {
                Swal.fire('Lỗi', data.message || 'Không thể lọc sản phẩm.', 'error');
                return;
            }

            const ds = data.data;
            productList.innerHTML = '';

            if (ds.length === 0) {
                productList.innerHTML = `
                    <div class="col-span-full text-center text-gray-500 py-12">
                        Không tìm thấy sản phẩm phù hợp.
                    </div>`;
                return;
            }

            ds.forEach(item => {
                const priceTriệu = (item.GIATIEN / 1000000).toFixed(1);

                const card = document.createElement('article');
                card.className = "relative rounded-2xl overflow-hidden border soft-card lift gold-ring";
                card.style.borderColor = "var(--border)";
                card.innerHTML = `
                    <button data-id="${item.IDGIATIEN}" class="w-full aspect-[4/3] relative group">
                        <img src="${item.LINKANHDAIDIEN || '/img/no-image.jpg'}"
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
                    </button>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold">${item.TENGIATIEN}</h3>
                        <p class="text-sm mt-1" style="color:var(--muted)">
                            ${item.MOTA ?? ''}
                        </p>
                        <div class="mt-3 flex items-baseline gap-1">
                            <span class="text-xl font-bold text-[var(--pink)]">
                                ${priceTriệu} triệu
                            </span>
                            <span class="text-sm text-gray-500">/ gói</span>
                        </div>
                    </div>
                `;
                productList.appendChild(card);
            });

        } catch (error) {
            Swal.close();
            Swal.fire('Lỗi kết nối', 'Không thể kết nối tới server. Vui lòng thử lại.', 'error');
        }
    });

    function chitietsanpham(btn) {
        const id = btn.dataset.id;
        window.location.href = `/Giatien/chitietsanpham/${id}`;
    }
</script>
@endpush