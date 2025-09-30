@extends('Layouts.layoutdashboard')

@section('content')
<!-- COLORS -->
<section id="colors" class="space-y-4">
    <div class="flex items-end justify-between">
        <div>
            <h2 class="serif text-2xl md:text-3xl font-bold">Quản lý màu sắc</h2>
            <p class="text-sm mt-1" style="color:var(--muted)">Danh sách màu sắc có thể sử dụng cho sản
                phẩm</p>
        </div>
        <button class="px-4 py-2 rounded-xl shadow-sm lift" style="background:var(--pink);color:#3d2a2e"
            data-open="modal-add-color">+ Thêm màu</button>
    </div>

    <div class="overflow-auto rounded-2xl border soft-card" style="border-color:var(--border)">
        <table class="min-w-[400px] w-full text-sm">
            <thead class="bg-[var(--pink-2)]/60">
                <tr>
                    <th class="text-left px-4 py-3">STT</th>
                    <th class="text-left px-4 py-3">Tên màu</th>
                    <th class="text-right px-4 py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                <!-- Demo -->
                @foreach($listmausac as $item)
                <tr class="border-t" style="border-color:var(--border)">
                    <td class="px-4 py-3">{{ $i }}</td>
                    <td class="px-4 py-3">{{$item->ten_mau}}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <button onclick="editcolor(this)" data-id="{{ $item->id_mau }}" data-name="{{ $item->ten_mau }}" class="px-3 py-1 rounded-lg border"
                            style="border-color:var(--border)">Sửa</button>
                        <button data-id="{{ $item->id_mau }}" onclick="xoamau(this)" class="px-3 py-1 rounded-lg border"
                            style="border-color:var(--border)">Xoá</button>
                    </td>
                </tr>
                @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 flex justify-between items-center px-4 py-3 border-t" style="border-color:var(--border)">
            <div class="text-sm text-gray-500">
                Hiển thị
                <span class="font-medium">{{ $listmausac->firstItem() }}</span>
                đến
                <span class="font-medium">{{ $listmausac->lastItem() }}</span>
                trong
                <span class="font-medium">{{ $listmausac->total() }}</span>
                kết quả
            </div>

            <div class="flex items-center space-x-1">
                @if ($listmausac->onFirstPage())
                <span class="px-3 py-1 rounded-lg border text-gray-400">‹</span>
                @else
                <a href="{{ $listmausac->previousPageUrl() }}"
                    class="px-3 py-1 rounded-lg border hover:bg-[var(--pink-2)] transition">‹</a>
                @endif

                @foreach ($listmausac->getUrlRange(1, $listmausac->lastPage()) as $page => $url)
                @if ($page == $listmausac->currentPage())
                <span class="px-3 py-1 rounded-lg border bg-[var(--pink)] text-[#3d2a2e] font-semibold">{{ $page }}</span>
                @else
                <a href="{{ $url }}"
                    class="px-3 py-1 rounded-lg border hover:bg-[var(--pink-2)] transition">{{ $page }}</a>
                @endif
                @endforeach

                @if ($listmausac->hasMorePages())
                <a href="{{ $listmausac->nextPageUrl() }}"
                    class="px-3 py-1 rounded-lg border hover:bg-[var(--pink-2)] transition">›</a>
                @else
                <span class="px-3 py-1 rounded-lg border text-gray-400">›</span>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- ADD COLOR -->
<dialog id="modal-add-color" class="max-w-md w-[92vw]">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-[var(--border)]">
        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 bg-[var(--pink-2)]/40">
            <h4 class="text-lg font-semibold text-[#3d2a2e]">➕ Thêm màu mới</h4>
            <button data-close
                class="px-3 py-1 rounded-lg border text-sm hover:bg-[var(--pink-2)] transition"
                style="border-color:var(--border)">
                Đóng ✖
            </button>
        </div>

        <!-- Form -->
        <form id="form-add-color" class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--muted)">Tên màu</label>
                <input name="TENMAU" type="text" placeholder="Ví dụ: Xanh pastel"
                    class="px-3 py-2 w-full rounded-xl border focus:ring-2 focus:ring-[var(--pink)] focus:outline-none"
                    style="border-color:var(--border)">
            </div>

            <!-- Actions -->
            <div class="flex justify-end items-center gap-3">
                <button type="reset"
                    class="px-4 py-2 rounded-xl border hover:bg-gray-100 transition"
                    style="border-color:var(--border)">Reset</button>

                <button type="submit"
                    class="px-5 py-2 rounded-xl shadow-md bg-[var(--pink)] text-[#3d2a2e] font-medium hover:opacity-90 transition">
                    💾 Lưu
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- EDIT COLOR -->
<dialog id="modal-edit-color" class="max-w-md w-[92vw]">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-[var(--border)]">
        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 bg-[var(--pink-2)]/40">
            <div class="flex items-center gap-2">
                <span class="text-xl">🎨</span>
                <h4 class="text-lg font-semibold text-[#3d2a2e]">Sửa màu sắc</h4>
            </div>
            <button
                data-close
                class="px-3 py-1 rounded-lg border text-sm hover:bg-[var(--pink-2)] transition"
                style="border-color:var(--border)">Đóng ✖</button>
        </div>

        <!-- Body -->
        <form id="form-edit-color" class="p-6 space-y-5">
            <input type="hidden" name="ID_MAU" id="editColorId">
            <div class="space-y-1.5">
                <label class="block text-sm font-medium" style="color:var(--muted)">Tên màu</label>
                <input
                    id="editColorName"
                    name="TENMAU"
                    type="text"
                    class="px-3 py-2 w-full rounded-xl border focus:ring-2 focus:ring-[var(--pink)] focus:outline-none"
                    style="border-color:var(--border)"
                    placeholder="Ví dụ: Xanh pastel">
                <p class="text-xs text-gray-500">Đặt tên rõ ràng để dễ tìm khi gán cho sản phẩm.</p>
            </div>

            <!-- Actions -->
            <div class="flex justify-end items-center gap-3 pt-2">
                <button
                    type="button"
                    data-close
                    class="px-4 py-2 rounded-xl border hover:bg-gray-100 transition"
                    style="border-color:var(--border)">Huỷ</button>

                <button
                    type="submit"
                    class="px-5 py-2 rounded-xl shadow-md bg-[var(--pink)] text-[#3d2a2e] font-medium hover:opacity-90 transition">💾 Lưu thay đổi</button>
            </div>
        </form>
    </div>
</dialog>

@endsection

@push('scripts')
<script>
    const dialogaddcolor = document.getElementById('modal-add-color');
    const dialogeditcolor = document.getElementById('modal-edit-color');
    const formEditColor = document.getElementById('form-edit-color');
    const editColorIdInput = document.getElementById('editColorId');
    const editColorNameInp = document.getElementById('editColorName');

    document.getElementById('form-add-color').addEventListener('submit', async (e) => {
        e.preventDefault();
        const tenmau = document.querySelector('#form-add-color input[name="TENMAU"]').value;

        if (!tenmau.trim()) {
            Swal.fire("Chưa nhập tên màu!", "", "warning");
            return;
        }

        try {
            if (dialogaddcolor?.open) dialogaddcolor.close();

            Swal.fire({
                title: 'Đang thêm màu',
                html: 'Vui lòng chờ trong giây lát',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
                color: '#53363C',
                background: '#FFFFFF'
            });

            fetch("{{ route('themmau') }}", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf
                    },
                    body: JSON.stringify({
                        namemausac: tenmau
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            title: 'thêm màu thành công',
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
                            title: 'Thêm màu lỗi',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'Đóng',
                            confirmButtonColor: '#D9A1AC',
                            color: '#53363C',
                            background: '#FFFFFF',
                        }).then(() => {
                            dialogaddcolor.showModal();
                        });
                    }
                })

        } catch (err) {
            Swal.close();
            Swal.fire({
                title: 'Lỗi không cập nhập được',
                text: err,
                icon: 'error',
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#D9A1AC',
                color: '#53363C',
                background: '#FFFFFF',
            }).then(() => {
                dialogaddcolor.showModal();
            });
        }
    })

    function editcolor(button) {
        const idmau = button.dataset.id;
        const tenmau = button.dataset.name;
        editColorIdInput.value = idmau;
        editColorNameInp.value = tenmau;
        dialogeditcolor.showModal();
    }

    formEditColor.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!editColorNameInp.value.trim()) {
            Swal.fire({
                title: 'Lỗi',
                text: 'Hãy nhập tên màu',
                icon: 'warning',
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#D9A1AC',
                color: '#53363C',
                background: '#FFFFFF',
            })
        }
        try {
            if (dialogeditcolor?.open) dialogeditcolor.close();

            Swal.fire({
                title: 'Đang sửa màu',
                html: 'Vui lòng chờ trong giây lát',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
                color: '#53363C',
                background: '#FFFFFF'
            });

            fetch("{{ route('suamau')}}", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf
                    },
                    body: JSON.stringify({
                        id: editColorIdInput.value,
                        name: editColorNameInp.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            title: 'Sửa màu thành công',
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
                            title: 'Sửa màu lỗi',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'Đóng',
                            confirmButtonColor: '#D9A1AC',
                            color: '#53363C',
                            background: '#FFFFFF',
                        }).then(() => {
                            dialogeditcolor.showModal();
                        });
                    }
                })
        } catch (err) {
            Swal.close();
            Swal.fire({
                title: 'Lỗi không cập nhập được',
                text: err,
                icon: 'error',
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#D9A1AC',
                color: '#53363C',
                background: '#FFFFFF',
            }).then(() => {
                dialogeditcolor.showModal();
            });
        }
    })

    function xoamau(button) {
        const id = button.dataset.id;
        try {
            Swal.fire({
                title: 'Bạn có chắc chắn xoá màu này?',
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
                        title: 'Đang xoá màu',
                        html: 'Vui lòng chờ trong giây lát',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => Swal.showLoading(),
                        color: '#53363C',
                        background: '#FFFFFF'
                    });

                    fetch("{{route('xoamau')}}", {
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
                                    title: 'Xoá màu thành công',
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
                                    title: 'Xoá màu không được :_))',
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
</script>
@endpush