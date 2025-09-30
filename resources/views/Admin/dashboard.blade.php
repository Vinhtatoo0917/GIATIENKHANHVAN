@extends('Layouts.layoutdashboard')

@section('content')
<section id="dashboard-info" class="section soft-card border rounded-2xl p-6 shadow-sm">
    <h1 class="text-3xl font-bold text-gray-900">Bảng điều khiển</h1>
    <p class="mt-2 text-gray-600 text-lg">Chào mừng <span class="font-semibold text-pink-700">{{ $nameadmin }}</span> đến trang quản trị 🎉</p>
</section>
@endsection