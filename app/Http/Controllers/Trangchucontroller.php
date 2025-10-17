<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Trangchucontroller extends Controller
{
    public function Index() {
        $title = "Trang chủ";
        $listanh = DB::select('SELECT NAME,DUONGDAN FROM anhdautrangchu');
        $thongtinlienhe = DB::selectOne('SELECT * FROM thongtinlienhetrangchu LIMIT 1');
        $listsanpham = DB::select('SELECT IDGIATIEN,TENGIATIEN,MOTA,GIATIEN,LINKANHDAIDIEN FROM giatien LIMIT 3');
        return view('Clients.Trangchu', compact('title', 'listanh', 'listsanpham', 'thongtinlienhe'));
    }

    public function sanpham() {
        $title = "Sản phẩm";
        $listmausac = DB::select('SELECT * FROM mau_sac');
        $listsanpham = DB::select('SELECT IDGIATIEN,TENGIATIEN,MOTA,GIATIEN,LINKANHDAIDIEN FROM giatien');
        return view('Clients.sanpham', compact('title','listsanpham', 'listmausac'));
    }

    public function chitietsanpham($id) {
        $title = "Chi tiết sản phẩm";
        $sanpham = DB::select('SELECT * FROM giatien WHERE IDGIATIEN = ?', [$id])[0];

        if (!$sanpham) {
            abort(404, 'Không tìm thấy sản phẩm');
        }

        $danhsachmau = DB::select('SELECT ms.id_mau, ms.ten_mau FROM gia_tien_mau_sac gtms JOIN mau_sac ms ON gtms.id_mau = ms.id_mau WHERE gtms.IDGIATIEN = ?', [$id]);
        return view('Clients.chitietsanpham', compact('title','sanpham', 'danhsachmau'));
    }

    public function sanphamtheomau($idmau) {
        $title = "Sản phẩm";
        $listmausac = DB::select('SELECT * FROM mau_sac');
        $listsanpham = DB::select('SELECT gt.* FROM giatien gt JOIN gia_tien_mau_sac gtms ON gt.IDGIATIEN = gtms.IDGIATIEN WHERE gtms.id_mau = ?', [$idmau]);
        return view('Clients.sanphamtheomau', compact('title', 'listmausac', 'listsanpham'));
    }
}
