<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Trangchucontroller extends Controller
{
    public function Index() {
        $title = "Trang chủ";
        $listanh = DB::select('SELECT NAME,DUONGDAN FROM anhdautrangchu');
        return view('Trangchu', compact('title', 'listanh'));
    }
}
