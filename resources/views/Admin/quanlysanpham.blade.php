@extends('Layouts.layoutdashboard')

@section('content')
<section id="products" class="space-y-4">
    <div class="flex items-end justify-between">
        <div>
            <h2 class="serif text-2xl md:text-3xl font-bold">Sản phẩm gia tiên</h2>
            <p class="text-sm mt-1" style="color:var(--muted)">Bảng gia tiên</p>
        </div>
        <button class="px-4 py-2 rounded-xl shadow-sm lift" style="background:var(--pink);color:#3d2a2e"
            data-open="modal-add-sp">+ Thêm gói</button>
    </div>

    <div class="mb-6 flex flex-wrap items-end gap-4">
        <!-- Lọc theo giá tiền -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">💰 Lọc theo giá tiền</label>
            <select id="filterPrice"
                class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none">
                <option value="">-- Tất cả --</option>
                <option value="3">≤ 3 triệu</option>
                <option value="5">≤ 5 triệu</option>
                <option value="10">≤ 10 triệu</option>
                <option value="11">> 10 triệu</option>
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



    <!-- Grid danh sách sản phẩm -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($listsanpham as $item)
        <div class="soft-card border rounded-2xl overflow-hidden shadow hover:shadow-lg transition bg-white"
            style="border-color:var(--border)">
            <!-- Ảnh -->
            <div class="aspect-[4/3] bg-gray-100">
                <img src="{{ $item->LINKANHDAIDIEN }}" alt="{{ $item->TENGIATIEN }}"
                    class="w-full h-full object-cover">
            </div>

            <!-- Nội dung -->
            <div class="p-4">
                <h3 class="text-lg font-semibold">{{ $item->TENGIATIEN }}</h3>
                <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                    {{ $item->MOTA }}
                </p>
                <p class="mt-3 text-lg font-bold text-[var(--pink)]">
                    {{ number_format($item->GIATIEN/1000000, 1) }} triệu <span class="text-sm font-normal">/ gói</span>
                </p>

                <!-- Hành động -->
                <div class="flex gap-2 mt-4">
                    <button data-id="{{ $item->IDGIATIEN }}" onclick="openEditModal(this)" class="flex-1 px-3 py-2 rounded-lg border text-sm hover:bg-gray-50"
                        style="border-color:var(--border)">
                        ✏️ Sửa
                    </button>
                    <button data-id="{{ $item->IDGIATIEN }}" onclick="xoagiatien(this)" class="flex-1 px-3 py-2 rounded-lg border text-sm hover:bg-red-50 text-red-600"
                        style="border-color:var(--border)">
                        🗑️ Xoá
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<div class="divider"></div>


<!-- MODAL: THÊM SẢN PHẨM -->
<dialog id="modal-add-sp" class="max-w-3xl w-[92vw]">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border" style="border-color:var(--border)">
        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 bg-[var(--pink-2)]/40">
            <h3 class="text-lg font-semibold text-[#3d2a2e]">➕ Thêm sản phẩm (Gói Gia Tiên)</h3>
            <button data-close
                class="px-3 py-1 rounded-lg border text-sm hover:bg-[var(--pink-2)] transition"
                style="border-color:var(--border)">Đóng ✖</button>
        </div>

        <!-- Form -->
        <form id="form-add-sp" class="p-6 grid md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="text-sm" style="color:var(--muted)">Tên gói</label>
                <input name="TENGIATIEN" id="TENGIATIEN" type="text" required
                    class="mt-1 px-3 py-2 w-full rounded-xl border focus:ring-2 focus:ring-[var(--pink)] focus:outline-none"
                    style="border-color:var(--border)">
            </div>

            <!-- Màu sắc (multiple) -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-600">Màu sắc</label>
                <div class="max-h-40 overflow-y-auto grid grid-cols-2 md:grid-cols-3 gap-2 p-2 border rounded-xl">
                    @foreach($listmausac as $mau)
                    <label class="flex items-center gap-2 px-3 py-2 rounded-lg border hover:bg-[var(--pink-2)] cursor-pointer"
                        style="border-color:var(--border)">
                        <input type="checkbox" name="MAUSAC[]" value="{{ $mau->id_mau }}">
                        <span>{{ $mau->ten_mau }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="text-sm" style="color:var(--muted)">Giá tiền (VND)</label>
                <input name="GIATIEN" id="GIATIEN" type="number" min="0" step="1" required
                    placeholder="vd: 3900000"
                    class="mt-1 px-3 py-2 w-full rounded-xl border"
                    style="border-color:var(--border)">
            </div>

            <div>
                <label class="text-sm" style="color:var(--muted)">Số ghế</label>
                <input name="SOGHE" id="SOGHE" type="number" min="0" step="1" required
                    class="mt-1 px-3 py-2 w-full rounded-xl border"
                    style="border-color:var(--border)">
            </div>

            <div>
                <label class="text-sm" style="color:var(--muted)">Số bàn</label>
                <input name="SOBAN" id="SOBAN" type="number" min="0" step="1" required
                    class="mt-1 px-3 py-2 w-full rounded-xl border"
                    style="border-color:var(--border)">
            </div>

            <div>
                <label class="text-sm" style="color:var(--muted)">Cổng gia tiên</label>
                <select name="CONGGIATIEN" id="CONGGIATIEN"
                    class="mt-1 px-3 py-2 w-full rounded-xl border"
                    style="border-color:var(--border)">
                    <option value="Có">Có</option>
                    <option value="Không">Không</option>
                </select>
            </div>

            <div>
                <label class="text-sm" style="color:var(--muted)">Background chụp hình ngoài cổng</label>
                <select name="BACKGOUNDCHUPHINHNGOAICONG" id="BACKGOUNDCHUPHINHNGOAICONG"
                    class="mt-1 px-3 py-2 w-full rounded-xl border"
                    style="border-color:var(--border)">
                    <option value="Có">Có</option>
                    <option value="Không">Không</option>
                </select>
            </div>

            <div>
                <label class="text-sm" style="color:var(--muted)">Hoa tươi</label>
                <select name="HOATUOI" id="HOATUOI"
                    class="mt-1 px-3 py-2 w-full rounded-xl border"
                    style="border-color:var(--border)">
                    <option value="Có">Có</option>
                    <option value="Không">Không</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="text-sm" style="color:var(--muted)">Các sản phẩm đi kèm</label>
                <textarea name="CACSANPHAMDIKEM" rows="3" id="CACSANPHAMDIKEM"
                    class="mt-1 px-3 py-2 w-full rounded-xl border"
                    style="border-color:var(--border)"></textarea>
            </div>

            <div class="md:col-span-2">
                <label class="text-sm" style="color:var(--muted)">Mô tả</label>
                <textarea name="MOTA" rows="3" id="MOTA"
                    class="mt-1 px-3 py-2 w-full rounded-xl border"
                    style="border-color:var(--border)"></textarea>
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-medium" style="color:var(--muted)">Ảnh đại diện</label>
                <input type="file" id="thumbnailFile" name="THUMBNAIL" accept="image/*"
                    class="mt-2 block w-full text-sm text-gray-500 
                file:mr-4 file:py-2 file:px-4
                file:rounded-xl file:border-0
                file:text-sm file:font-semibold
                file:bg-[var(--pink)] file:text-[#3d2a2e]
                hover:file:opacity-90" />
                <div id="thumbnailPreview" class="mt-3">
                    <!-- preview sẽ hiện tại đây -->
                </div>
            </div>

            <!-- Upload nhiều ảnh -->
            <div class="md:col-span-2">
                <label class="text-sm font-medium" style="color:var(--muted)">Ảnh sản phẩm</label>
                <input type="file" id="giatienFiles" name="IMAGES[]" multiple
                    class="mt-2 block w-full text-sm text-gray-500 
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-xl file:border-0
                               file:text-sm file:font-semibold
                               file:bg-[var(--pink)] file:text-[#3d2a2e]
                               hover:file:opacity-90" />
                <div id="giatienPreviewWrap" class="mt-3 flex gap-3 flex-wrap"></div>
            </div>

            <!-- Actions -->
            <div class="md:col-span-2 flex justify-end gap-3">
                <button type="submit"
                    class="px-5 py-2 rounded-xl shadow-md bg-[var(--pink)] text-[#3d2a2e] font-medium hover:opacity-90 transition">
                    💾 Lưu
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- EDIT SP (cùng file với ADD) -->
<dialog id="modal-edit-sp" class="max-w-4xl w-[92vw]">
    <div class="bg-white/90 rounded-2xl shadow-xl overflow-hidden border border-[var(--border)]">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 bg-[var(--pink-2)]/40">
            <div>
                <h3 class="text-xl font-semibold text-[#3d2a2e]">✏️ Sửa gói Gia Tiên</h3>
                <p class="text-xs text-gray-500 mt-0.5">Chỉnh thông tin, màu sắc, hình ảnh</p>
            </div>
            <button data-close class="px-3 py-1 rounded-lg border text-sm hover:bg-[var(--pink-2)] transition"
                style="border-color:var(--border)">Đóng ✖</button>
        </div>

        <!-- Form -->
        <form id="form-edit-sp" class="p-8 grid md:grid-cols-2 gap-6">
            <input type="hidden" id="EDIT_ID" name="ID">

            <!-- Tên gói -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-600">Tên gói</label>
                <input name="TENGIATIEN" type="text" placeholder="Nhập tên gói..."
                    class="mt-2 px-4 py-3 w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none shadow-sm">
            </div>



            <!-- Màu sắc (multiple) -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-600">Màu sắc</label>
                <div class="max-h-40 overflow-y-auto grid grid-cols-2 md:grid-cols-3 gap-2 p-2 border rounded-xl">
                    @foreach($listmausac as $mau)
                    <label class="flex items-center gap-2 px-3 py-2 rounded-lg border hover:bg-[var(--pink-2)] cursor-pointer"
                        style="border-color:var(--border)">
                        <input type="checkbox" name="MAUSAC[]" value="{{ $mau->id_mau }}">
                        <span>{{ $mau->ten_mau }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Giá tiền (VND)</label>
                <input name="GIATIEN" type="number" placeholder="vd: 3900000"
                    class="mt-2 px-4 py-3 w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Số ghế</label>
                <input name="SOGHE" type="number" placeholder="vd: 50"
                    class="mt-2 px-4 py-3 w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Số bàn</label>
                <input name="SOBAN" type="number" placeholder="vd: 10"
                    class="mt-2 px-4 py-3 w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Cổng gia tiên</label>
                <select name="CONGGIATIEN"
                    class="mt-2 px-4 py-3 w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none shadow-sm">
                    <option value="Có">Có</option>
                    <option value="Không">Không</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Background chụp hình ngoài cổng</label>
                <select name="BACKGOUNDCHUPHINHNGOAICONG"
                    class="mt-2 px-4 py-3 w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none shadow-sm">
                    <option value="Có">Có</option>
                    <option value="Không">Không</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Hoa tươi</label>
                <select name="HOATUOI"
                    class="mt-2 px-4 py-3 w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none shadow-sm">
                    <option value="Có">Có</option>
                    <option value="Không">Không</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-600">Các sản phẩm đi kèm</label>
                <textarea name="CACSANPHAMDIKEM" rows="4" placeholder=""
                    class="mt-2 px-4 py-3 w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none shadow-sm"></textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-600">Mô tả</label>
                <textarea name="MOTA" rows="4" placeholder="Nhập mô tả..."
                    class="mt-2 px-4 py-3 w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none shadow-sm"></textarea>
            </div>



            <!-- Ảnh đại diện -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-600">Ảnh đại diện</label>
                <div class="flex items-center gap-6 mt-3">
                    <div class="w-40">
                        <p class="text-xs text-gray-500 mb-2">Ảnh hiện tại</p>
                        <div id="thumbCurrent" class="h-32 w-40 bg-gray-100 rounded-xl grid place-items-center text-gray-400 text-sm">Chưa có</div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-2">Ảnh mới</p>
                        <input type="file" name="THUMBNAIL" id="thumbnailInputEdit"
                            class="block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[var(--pink)] file:text-[#3d2a2e] hover:file:opacity-90">
                        <div id="thumbnailPreviewEdit" class="mt-3 hidden">
                            <img class="h-32 w-40 object-cover rounded-xl shadow">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ảnh sản phẩm nhiều -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-600">Ảnh sản phẩm</label>
                <div id="currentImages" class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-3">
                    <div class="col-span-full h-28 rounded-xl bg-gray-100 grid place-items-center text-gray-400 text-sm">
                        Chưa có ảnh
                    </div>
                </div>

                <input type="file" name="IMAGES[]" id="editFiles" multiple
                    class="mt-4 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[var(--pink)] file:text-[#3d2a2e] hover:file:opacity-90">
                <div id="editPreviewWrap" class="mt-3 flex gap-3 flex-wrap"></div>
            </div>

            <!-- Actions -->
            <div class="md:col-span-2 flex justify-end gap-4 pt-6 border-t">
                <button type="submit"
                    class="px-6 py-2 rounded-xl bg-[var(--pink)] text-[#3d2a2e] font-semibold shadow hover:opacity-90 transition">
                    💾 Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</dialog>

@endsection

@push('scripts')
<script>
    const thumbnailFile = document.getElementById('thumbnailFile');
    const thumbnailPreview = document.getElementById('thumbnailPreview');

    thumbnailFile?.addEventListener('change', () => {
        thumbnailPreview.innerHTML = '';
        const f = thumbnailFile.files?.[0];
        if (!f) return;
        const img = document.createElement('img');
        img.src = URL.createObjectURL(f);
        img.className = "rounded-xl border max-h-40";
        thumbnailPreview.appendChild(img);
    });

    const modaladdgiatien = document.getElementById('modal-add-sp');
    const formaddgiatien = document.getElementById('form-add-sp');
    formaddgiatien.addEventListener('submit', async (e) => {
        e.preventDefault();
        try {
            const dataform = new FormData(formaddgiatien);

            if (modaladdgiatien?.open) modaladdgiatien.close();

            Swal.fire({
                title: 'Đang thêm gia tiên !!!',
                html: 'Vui lòng chờ trong giây lát',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
                color: '#53363C',
                background: '#FFFFFF'
            });

            fetch("{{route('themgiatien')}}", {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": csrf
                    },
                    body: dataform
                })
                .then(Response => Response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            title: 'Thêm gói thành công!',
                            text: data.message,
                            icon: 'success',
                            timer: 1200,
                            showConfirmButton: false,
                            color: '#53363C',
                            background: '#FFFFFF',
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            title: 'Thêm gói thất bại !!!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'Đóng',
                            confirmButtonColor: '#D9A1AC',
                            color: '#53363C',
                            background: '#FFFFFF',
                        }).then(() => {
                            modaladdgiatien.showModal();
                        });
                    }
                })


        } catch (err) {
            Swal.close();
            Swal.fire({
                title: 'Lỗi không thêm sản phẩm vào được!!!',
                text: err,
                icon: 'error',
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#D9A1AC',
                color: '#53363C',
                background: '#FFFFFF',
            }).then(() => {
                modaladdgiatien.showModal();
            });
        }
    })

    // ===== Mở modal Edit & set ID (không load data) =====
    const dialogEditSp = document.getElementById('modal-edit-sp');
    const editIdInput = document.getElementById('EDIT_ID');

    function openEditModal(btn) {
        const idgiatien = btn?.dataset?.id || '';
        dialogEditSp.showModal();

        try {
            fetch("{{ route('laygiatien') }}", {
                    method: 'POST',
                    headers: {
                        'Content-type': "application/json",
                        "X-CSRF-TOKEN": csrf
                    },
                    body: JSON.stringify({
                        id: idgiatien
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const dulieu = data.datatrave;
                        const listMau = data.danhsachmau || [];

                        // Gán dữ liệu form
                        document.querySelector(('#form-edit-sp [name="ID"]')).value = dulieu.IDGIATIEN || '';
                        document.querySelector('#form-edit-sp [name="TENGIATIEN"]').value = dulieu.TENGIATIEN || '';
                        document.querySelector('#form-edit-sp [name="GIATIEN"]').value = dulieu.GIATIEN || '';
                        document.querySelector('#form-edit-sp [name="SOGHE"]').value = dulieu.SOGHE || '';
                        document.querySelector('#form-edit-sp [name="SOBAN"]').value = dulieu.SOBAN || '';
                        document.querySelector('#form-edit-sp [name="CONGGIATIEN"]').value = dulieu.CONGGIATIEN || 'Không';
                        document.querySelector('#form-edit-sp [name="BACKGOUNDCHUPHINHNGOAICONG"]').value = dulieu.BACKGOUNDCHUPHINHNGOAICONG || 'Không';
                        document.querySelector('#form-edit-sp [name="HOATUOI"]').value = dulieu.HOATUOI || 'Không';
                        document.querySelector('#form-edit-sp [name="CACSANPHAMDIKEM"]').value = dulieu.CACSANPHAMDIKEM || '';
                        document.querySelector('#form-edit-sp [name="MOTA"]').value = dulieu.MOTA || '';

                        // Ảnh đại diện
                        const thumbCurrent = document.getElementById('thumbCurrent');
                        if (dulieu.LINKANHDAIDIEN) {
                            thumbCurrent.innerHTML = `<img src="${dulieu.LINKANHDAIDIEN}" class="h-32 w-40 object-cover rounded-xl shadow">`;
                        } else {
                            thumbCurrent.innerHTML = `<div class="h-32 w-40 grid place-items-center text-gray-400 text-sm">Chưa có</div>`;
                        }

                        // Ảnh sản phẩm
                        const currentImages = document.getElementById('currentImages');
                        currentImages.innerHTML = '';
                        if (dulieu.DUONGDANANH) {
                            dulieu.DUONGDANANH.split('|').forEach(link => {
                                const div = document.createElement('div');
                                div.className = "relative group";
                                div.innerHTML = `
                                <img src="${link}" class="h-28 w-full object-cover rounded-lg shadow">
                                <button data-linkanhchitiet="${link}" data-id="${dulieu.IDGIATIEN}" onclick="xoatunganhtrongsanpham(this)" type="button" class="absolute top-1 right-1 bg-red-500 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                                    Xoá
                                </button>
                            `;
                                currentImages.appendChild(div);
                            });
                        } else {
                            currentImages.innerHTML = `<div class="col-span-full h-28 rounded-xl bg-gray-100 grid place-items-center text-gray-400 text-sm">Chưa có ảnh</div>`;
                        }

                        document.querySelectorAll('#form-edit-sp input[name="MAUSAC[]"]').forEach(cb => {
                            if (listMau.includes(parseInt(cb.value))) {
                                cb.checked = true;
                            } else {
                                cb.checked = false;
                            }
                        });
                    }
                });
        } catch (err) {
            console.log(err);
        }
    }

    function xoatunganhtrongsanpham(button) {
        const linkanhcanxoa = button.dataset.linkanhchitiet;
        const idgiatien = button.dataset.id;
        try {
            fetch("{{route('xoaanhchitiet')}}", {
                    method: 'POST',
                    headers: {
                        'Content-type': "application/json",
                        "X-CSRF-TOKEN": csrf
                    },
                    body: JSON.stringify({
                        idgiatien: idgiatien,
                        linkanhchitiet: linkanhcanxoa
                    })
                }).then(Response => Response.json())
                .then(data => {
                    if (data.success) {
                        const imageWrapper = button.closest(".relative");
                        if (imageWrapper) {
                            imageWrapper.remove();
                        }

                        const container = document.getElementById("currentImages");
                        if (container.children.length === 0) {
                            container.innerHTML = `<div class="col-span-full h-28 rounded-xl bg-gray-100 grid place-items-center text-gray-400 text-sm">
                        Chưa có ảnh
                    </div>`;
                        }

                    } else {
                        console.log("Lỗi không thể xoá ảnh");
                    }
                })
        } catch (err) {
            console.log('Xoá ảnh lỗi');
        }
    }

    const formeditgiaitien = document.getElementById('form-edit-sp');
    const modaledit = document.getElementById('modal-edit-sp');
    formeditgiaitien.addEventListener("submit", async (e) => {
        e.preventDefault();
        const dataform = new FormData(formeditgiaitien);
        try {
            if (modaledit?.open) modaledit.close();

            Swal.fire({
                title: 'Đang thêm gia tiên !!!',
                html: 'Vui lòng chờ trong giây lát',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
                color: '#53363C',
                background: '#FFFFFF'
            });

            fetch("{{route('updategiatien')}}", {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": csrf
                    },
                    body: dataform
                })
                .then(Response => Response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            title: 'Update gói thành công!',
                            text: data.message,
                            icon: 'success',
                            timer: 1200,
                            showConfirmButton: false,
                            color: '#53363C',
                            background: '#FFFFFF',
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            title: 'Update gói thất bại !!!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'Đóng',
                            confirmButtonColor: '#D9A1AC',
                            color: '#53363C',
                            background: '#FFFFFF',
                        })
                    }
                })
        } catch (err) {
            Swal.fire({
                title: 'Lỗi không Update sản phẩm được!!!',
                text: err,
                icon: 'error',
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#D9A1AC',
                color: '#53363C',
                background: '#FFFFFF',
            })
        }
    })

    function xoagiatien(button) {
        const id = button.dataset.id;
        try {
            Swal.fire({
                title: 'Bạn có chắc chắn xoá gia tiên này?',
                text: "Thao tác này sẽ thay đổi dữ liệu!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Huỷ',
                reverseButtons: true,
                buttonsStyling: true,
                confirmButtonColor: '#D9A1AC',
                cancelButtonColor: '#EED6DC',
                color: '#53363C',
                background: '#FFFFFF',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Đang xoá gia tiên',
                        html: 'Vui lòng chờ trong giây lát',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => Swal.showLoading(),
                        color: '#53363C',
                        background: '#FFFFFF'
                    });

                    fetch("{{route('deletegiatien')}}", {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrf
                            },
                            body: JSON.stringify({
                                id: id
                            })
                        }).then(response => response.json())
                        .then(data => {
                            Swal.close();
                            if (data.success) {
                                Swal.fire({
                                    title: 'Xoá gia tiên thành công',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 1200,
                                    showConfirmButton: false,
                                    color: '#53363C',
                                    background: '#FFFFFF',
                                }).then(() => {
                                    window.location.reload();
                                })
                            } else {
                                Swal.fire({
                                    title: 'Xoá gia tiên không được :_))',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'Đóng',
                                    confirmButtonColor: '#D9A1AC',
                                    color: '#53363C',
                                    background: '#FFFFFF',
                                })
                            }
                        })
                }
            })
        } catch (err) {
            Swal.close();
            Swal.fire({
                title: 'Lỗi không xoá được',
                text: err,
                icon: 'error',
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#D9A1AC',
                color: '#53363C',
                background: '#FFFFFF',
            })
        }
    }

    const thumbnailInputEdit = document.getElementById('thumbnailInputEdit');
    const thumbnailPreviewEdit = document.getElementById('thumbnailPreviewEdit');

    thumbnailInputEdit?.addEventListener('change', () => {
        const file = thumbnailInputEdit.files?.[0];
        if (file) {
            const img = thumbnailPreviewEdit.querySelector("img");
            img.src = URL.createObjectURL(file);
            thumbnailPreviewEdit.classList.remove("hidden");
        } else {
            thumbnailPreviewEdit.classList.add("hidden");
        }
    });
</script>
@endpush