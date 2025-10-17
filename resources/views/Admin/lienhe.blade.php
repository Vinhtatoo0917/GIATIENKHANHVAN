@extends('Layouts.layoutdashboard')

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
        font-family: Inter, system-ui, sans-serif;
        background: #FFF8FA;
        color: var(--ink);
    }

    .soft-card {
        background: rgba(255, 255, 255, .8);
        backdrop-filter: blur(10px);
    }

    dialog::backdrop {
        background: rgba(0, 0, 0, .3);
        backdrop-filter: blur(3px);
    }

    .lift {
        transition: all 0.3s ease;
    }

    .lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(121, 76, 86, .15);
    }
</style>
<!-- HEADER -->
<header class="sticky top-0 bg-white/90 border-b soft-card" style="border-color: var(--border)">
    <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
        <h1 class="serif text-xl font-semibold">Gia Tiên Khánh Vân – Quản lý liên hệ</h1>
        <button onclick="openModal()"
            class="px-5 py-2 rounded-xl bg-[var(--pink)] text-[#3d2a2e] font-semibold shadow hover:opacity-90 transition">
            ✏️ Cập nhật
        </button>
    </div>
</header>

<!-- MAIN -->
<main class="max-w-6xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-4">📞 Thông tin liên hệ hiện tại</h2>

    @if($thongtinlienhe)
    <div class="soft-card border rounded-2xl p-6 lift" style="border-color: var(--border)">
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-sm text-gray-500 mb-1">Số điện thoại</h3>
                <p class="text-lg font-semibold" id="valuesdt">{{ $thongtinlienhe->SDT }}</p>
            </div>
            <div>
                <h3 class="text-sm text-gray-500 mb-1">Link Facebook</h3>
                <a href="{{ $thongtinlienhe->LINKFACEBOOK }}" id="valuelinkfacebook" target="_blank"
                    class="text-[var(--pink)] hover:underline break-all">
                    {{ $thongtinlienhe->LINKFACEBOOK }}
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="p-6 text-center border rounded-2xl text-gray-500" style="border-color: var(--border)">
        😢 Hiện chưa có thông tin liên hệ nào trong hệ thống.
    </div>
    @endif
</main>

<!-- MODAL -->
<dialog id="modal-lienhe" class="max-w-lg w-[92vw] rounded-2xl p-0">
    <div class="soft-card border rounded-2xl shadow-xl" style="border-color: var(--border)">
        <div class="flex items-center justify-between px-6 py-4 bg-[var(--pink-2)]/60">
            <h3 class="text-lg font-semibold text-[#3d2a2e]">✏️ Cập nhật liên hệ</h3>
            <button onclick="closeModal()"
                class="px-3 py-1 rounded-lg border text-sm hover:bg-[var(--pink-2)] transition"
                style="border-color:var(--border)">Đóng ✖</button>
        </div>
        <form id="formLienHe" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Số điện thoại</label>
                <input type="text" id="sdt" placeholder="Nhập số điện thoại..."
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Link Facebook</label>
                <input type="text" id="facebook" placeholder="Nhập đường dẫn Facebook..."
                    class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[var(--pink)] focus:outline-none" />
            </div>
            <div class="text-right">
                <button type="button" onclick="saveInfo()"
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
    const idlh = "{{ $thongtinlienhe->ID }}";
    const sdtEl = document.getElementById('valuesdt');
    const fbEl = document.getElementById('valuelinkfacebook');
    const inputSdt = document.getElementById('sdt');
    const inputFb = document.getElementById('facebook');
    const modal = document.getElementById('modal-lienhe');

    function openModal() {
        inputSdt.value = sdtEl ? sdtEl.textContent.trim() : '';
        inputFb.value = fbEl ? fbEl.textContent.trim() : '';
        modal.showModal();
    }

    function closeModal() {
        modal.close();
    }

    function saveInfo() {
        if (!inputSdt.value.trim() || !inputFb.value.trim()) {
            Swal.fire({
                title: 'Lỗi',
                text: 'Hãy nhập dữ liệu đừng để trống',
                icon: 'warning',
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#D9A1AC',
                color: '#53363C',
                background: '#FFFFFF',
            })
        }
        try {
            closeModal();
            Swal.fire({
                title: 'Đang cập nhập',
                html: 'Vui lòng chờ trong giây lát',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
                color: '#53363C',
                background: '#FFFFFF'
            });

            fetch("{{ route('capnhapthongtinlienhe')}}", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf
                    },
                    body: JSON.stringify({
                        id: idlh,
                        sdt: inputSdt.value.trim(),
                        linkfacebook: inputFb.value.trim()
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            title: 'Cập nhập liên hệ thành công !!!',
                            text: data.message,
                            icon: 'success',
                            timer: 1800,
                            showConfirmButton: false,
                            color: '#53363C',
                            background: '#FFFFFF',
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            title: 'Cập nhập liên hệ lỗi !!!',
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
    }
</script>
@endpush