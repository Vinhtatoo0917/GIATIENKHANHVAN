@extends('Layouts.layoutdashboard')

@section('content')
<!-- GALLERY -->
<section id="gallery" class="space-y-4">
    <div>
        <h2 class="serif text-2xl md:text-3xl font-bold">Ảnh trang chủ</h2>
        <p class="text-sm mt-1" style="color:var(--muted)">Danh sách ảnh đầu trang</p>
    </div>

    <div id="gallery-grid" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @forelse($listanhdautrang as $item)
        <div class="soft-card border rounded-2xl overflow-hidden lift"
            style="border-color:var(--border)">
            <div class="relative aspect-[4/3] bg-gray-200">
                <img src="{{ $item->DUONGDAN }}" alt="{{ $item->NAME }}"
                    class="absolute inset-0 w-full h-full object-cover" />
            </div>
            <div class="p-3 text-sm flex items-center justify-between">
                <span class="truncate max-w-[70%]" style="color:var(--muted)">{{ $item->NAME }}</span>
                <button class="px-2 py-1 rounded-lg border text-xs" style="border-color:var(--border)"
                    data-open="modal-edit-image" onclick="clickeditanhdautrang(this)"
                    data-id="{{ $item->ID }}">Sửa</button>
            </div>
        </div>
        @empty
        <div class="col-span-full text-sm" style="color:var(--muted)">Chưa có ảnh nào.</div>
        @endforelse
    </div>
</section>

<div class="divider"></div>

<!-- EDIT IMAGE -->
<dialog id="modal-edit-image" class="max-w-lg w-[92vw] rounded-2xl shadow-2xl backdrop:bg-black/40">
    <div class="soft-card border rounded-2xl p-6 md:p-8 bg-white" style="border-color:var(--border)">

        <!-- Header -->
        <div class="flex items-center justify-between pb-3 border-b" style="border-color:var(--border)">
            <h4 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                ✨ Sửa ảnh trang chủ
            </h4>
            <button class="px-3 py-1 rounded-lg border text-sm hover:bg-gray-100 transition"
                data-close style="border-color:var(--border)">✖</button>
        </div>

        <!-- Form -->
        <form class="mt-6 space-y-6" id="form-edit-image">
            <input type="hidden" id="editImageId" name="id">

            <!-- Upload -->
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--muted)">Chọn ảnh mới</label>
                <input id="editImageInput" type="file" accept="image/*"
                    class="mt-1 w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-pink-300 focus:outline-none transition"
                    style="border-color:var(--border)">
            </div>

            <!-- Preview -->
            <div id="editImagePreview" class="hidden">
                <img class="rounded-xl border max-h-60 w-full object-cover shadow-sm"
                    style="border-color:var(--border)">
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-3 border-t" style="border-color:var(--border)">
                <button type="reset"
                    class="px-4 py-2 rounded-xl border text-gray-600 hover:bg-gray-100 transition"
                    style="border-color:var(--border)">Reset</button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl shadow-md bg-gradient-to-r from-pink-200 to-pink-400 text-[#3d2a2e] font-semibold hover:scale-105 transition">
                    💾 Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</dialog>
@endsection

@push('scripts')
<script>
    const dialogEdit = document.getElementById('modal-edit-image');

    function clickeditanhdautrang(button) {
        formup = document.getElementById('form-edit-image');
        inputid = formup.querySelector('input[type="hidden"]');
        inputid.value = button.dataset.id;
    }

    document.getElementById('form-edit-image').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = document.getElementById('form-edit-image');
        const tepanh = document.getElementById('editImageInput').files[0];
        const id = form.querySelector('input[type="hidden"]').value;

        if (!tepanh) {
            Swal.fire("Chưa chọn ảnh!", "", "warning");
            return;
        }

        const formData = new FormData();
        formData.append("file", tepanh);
        formData.append("id", id);

        try {

            if (dialogEdit?.open) dialogEdit.close();

            Swal.fire({
                title: 'Đang cập nhật ảnh…',
                html: 'Vui lòng chờ trong giây lát',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
                color: '#53363C',
                background: '#FFFFFF'
            });

            fetch("{{ route('upload.cloudinary') }}", {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": csrf
                    },
                    body: formData
                })
                .then(Response => Response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            title: 'upload ảnh thành công',
                            text: data.message,
                            icon: 'success',
                            timer: 1200,
                            showConfirmButton: false,
                            color: '#53363C',
                            background: '#FFFFFF',
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Upload ảnh lỗi',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'Đóng',
                            confirmButtonColor: '#D9A1AC',
                            color: '#53363C',
                            background: '#FFFFFF',
                        }).then(() => {
                            dialogEdit.showModal();
                        });
                    }
                })
        } catch (error) {
            Swal.close();
            Swal.fire({
                title: 'Lỗi không cập nhập được',
                text: error,
                icon: 'error',
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#D9A1AC',
                color: '#53363C',
                background: '#FFFFFF',
            }).then(() => {
                dialogEdit.showModal();
            });
        }
    })
</script>
@endpush