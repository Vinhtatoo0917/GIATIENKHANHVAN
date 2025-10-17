<?php

namespace App\Http\Controllers;

use Hamcrest\Core\HasToString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Tinify\Tinify;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Exception;
use GuzzleHttp\Psr7\Response;

use function PHPUnit\Framework\isEmpty;
use function Tinify\validate;

class Admincontroller extends Controller
{
    public function chuyenchuoiantoan(string $s)
    {
        $max = 5000;
        if (class_exists('\Normalizer')) {
            $s = \Normalizer::normalize($s, \Normalizer::FORM_C) ?? $s;
        }
        $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $s);
        $s = preg_replace('/[\x{061C}\x{200E}\x{200F}\x{202A}-\x{202E}\x{2066}-\x{2069}]/u', '', $s);
        $s = strip_tags($s);
        if (Str::length($s) > $max) {
            $s = Str::limit($s, $max, '');
        }
        $s = trim(preg_replace('/[ \t]+/u', ' ', $s));
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }

    public function dangnhap(Request $request) {
        $title = "Đăng nhập";
        return view('Admin.dangnhap', compact('title'));
    }

    public function xulydangnhap(Request $request) {
        $data = $request->validate([
            'usernameresponse' => 'required|string|min:3|max:100',
            'passwordresponse' => 'required|string|min:8|max:30',
            'rememberresponse' => 'sometimes|boolean',
        ]);

        $remember = (bool) ($data['rememberresponse'] ?? false);

        $user = DB::selectOne('SELECT * FROM admin WHERE EMAIL = ? LIMIT 1', [$data['usernameresponse']]);

        if ($user && Hash::check($data['passwordresponse'], $user->MATKHAU)) {
            $request->session()->put('admin_id', $user->ID);

            if ($remember) {
                $token = hash('sha256', Str::random(60));
                DB::update('UPDATE admin SET COOKIEDANGNHAP = ? WHERE ID = ?', [$token, $user->ID]);
                Cookie::queue('remember_admin', $token, 60 * 24); // 1 ngày
            }

            return response()->json(['success' => true, 'redirect_url' => route('dashboard')]);
        }
        return response()->json(['success' => false, 'message' => 'Sai tài khoản hoặc mật khẩu'], 401);
    }

    public function dashboard(Request $request) {
        $adminid = session('admin_id');
        $admin = DB::selectOne('SELECT NAME FROM admin WHERE ID = ?', [$adminid]);
        $nameadmin = $admin->NAME;
        return view('Admin.dashboard', compact('nameadmin'));
    }

    public function testconsole() {
        $matkhau = 'Vinh0917641090@';
        $matkhau = Hash::make($matkhau);
        return view('testconsole', compact('matkhau'));
    }

    public function dangxuat(Request $request) {
        $request->session()->flush();
        Cookie::queue(Cookie::forget('remember_admin'));
        return response()->json([
            'success' => true,
            'message' => 'Đăng xuất thành công',
            'redirect_url' => route('dangnhapadmin'),
        ]);
    }

    public function quenmatkhau() {
        return view('/Admin/quenmatkhau');
    }

    public function quenmatkhauotp(Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $otp = rand(100000, 999999);
        session(['otp' => Hash::make($otp), 'timeliveotp'=>now()->addMinute(5)]);
        $request->session()->put('emailcaplaicapmat', $data['email']);

        Mail::to($data['email'])->send(new OtpMail($otp));
        return response()->json([
            'success' => true,
            'url' => route('checkotpcapmatkhau_METHOD_GET')
        ]);
    }

    public function checkotpcapmatkhau_METHOD_GET() {
        $emailcaplaimatkhau = session('emailcaplaicapmat');
        return view('/Admin/checkotpcapmatkhau', compact('emailcaplaimatkhau'));
    }

    public function quanlyanhdautrang() {

        $adminid = session('admin_id');
        $admin = DB::selectOne('SELECT NAME FROM admin WHERE ID = ?', [$adminid]);
        $nameadmin = $admin->NAME;

        $listanhdautrang = DB::select('SELECT * FROM anhdautrangchu');
        return view('Admin.quanlyanhdautrang', compact('nameadmin','listanhdautrang'));
    }

    public function quanlymausac() {
        $adminid = session('admin_id');
        $admin = DB::selectOne('SELECT NAME FROM admin WHERE ID = ?', [$adminid]);
        $nameadmin = $admin->NAME;
        $listmausac = DB::table('mau_sac')
            ->orderBy('id_mau', 'asc')
            ->paginate(5);
        return view('Admin.quanlymausac', compact('nameadmin', 'listmausac'));
    }

    public function quanlysanpham() {
        $adminid = session('admin_id');
        $admin = DB::selectOne('SELECT NAME FROM admin WHERE ID = ?', [$adminid]);
        $nameadmin = $admin->NAME;
        $listsanpham = DB::table('giatien')
                    ->orderBy('IDGIATIEN', 'asc')
                    ->paginate(10);
        $listmausac = DB::select('SELECT * FROM mau_sac');
        return view('Admin.quanlysanpham', compact('nameadmin', 'listsanpham', 'listmausac'));
    }

    public function checkotpcapmatkhau_METHOD_POST(Request $request) {
        $data = $request->validate([
            'otp'            => 'required',
            'matkhaumoi'     => 'required|string|min:8|max:30',
            'matkhaunhaplai' => 'required|string|min:8|max:30',
        ]);

        if(!Hash::check($data['otp'], session('otp'))) {
            return response()->json([
                'success' => false,
                'message' => 'Mã otp sai'
            ]);
        }

        if (now()->greaterThan(session('timeliveotp'))) {
            $request->session()->forget(['otp', 'timeliveotp']);
            return response()->json([
                'success' => false,
                'message' => 'Mã OTP đã hết hạn!',
                'url'     => route('quenmatkhau'),
            ]);
        }

        if ($data['matkhaumoi'] !== $data['matkhaunhaplai']) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu nhập lại không khớp',
            ]);
        }

        $password = $this->chuyenchuoiantoan($data['matkhaumoi']);
        $hashed   = Hash::make($password);

        $updated = DB::table('admin')
            ->where('EMAIL', session('emailcaplaicapmat'))
            ->update(['MATKHAU' => $hashed]);

        if ($updated) {
            $request->session()->flush();
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật mật khẩu thành công',
                'url'     => route('dangnhapadmin'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Có lỗi khi cập nhật mật khẩu',
        ]);
        
    }

    public function uploadcloudinary(Request $request) {
        try {
            $idAnh = $request->input('id');
            $tepAnh = $request->file('file');

            if (!$tepAnh) {
                return response()->json(['success' => false, 'message' => 'Chưa chọn ảnh!']);
            }

            \Tinify\setKey(env('TINIFY_API_KEY'));
            $duongDanTam = $tepAnh->getRealPath();
            $anhNhoHon = \Tinify\fromFile($duongDanTam);

            $duongDanTamToiUu = sys_get_temp_dir() . '/' . uniqid() . '.png';
            $anhNhoHon->toFile($duongDanTamToiUu);

            $ketQuaUpload = (new UploadApi())->upload($duongDanTamToiUu, [
                "folder" => "anh_dau_trang",
                "resource_type" => "image",
                "format" => "png"
            ]);

            $duongDanCloudinary = $ketQuaUpload['secure_url'];

            DB::update("UPDATE anhdautrangchu SET DUONGDAN = ? WHERE ID = ?", [$duongDanCloudinary, $idAnh]);

            return response()->json([
                'success' => true,
                'message' => 'Sửa ảnh thành công!'
            ]);
        }
        catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ]);
        }
    }

    public function addcolor(Request $request) {
        $data = $request->validate([
            'namemausac' => 'required|string',
        ]);
        $tenmau = $this->chuyenchuoiantoan($data['namemausac']);
        $check = DB::selectOne('SELECT * FROM mau_sac WHERE ten_mau	= ?',[$tenmau]);
        if($check !== null) {
            return Response()->json([
                'success'=>false,
                'message'=>'Đã có màu này rồi!!!'
            ]);
        }
        else {
            DB::insert('INSERT INTO mau_sac (ten_mau) VALUE (?)',[$tenmau]);
            return Response()->json([
                'success' => true,
                'message' => 'Thêm màu thành công!!!'
            ]);
        }
    }

    public function editcolor(Request $request) {    
        try {
            $id = $this->chuyenchuoiantoan($request->input('id'));
            $name = $this->chuyenchuoiantoan($request->input('name'));
            $check = DB::selectOne('SELECT * FROM mau_sac WHERE ten_mau = ?', [$name]);
            if($check) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đã có màu này rồi đổi lại tên khác đi !!!'
                ]);
            }
            DB::update('UPDATE mau_sac SET ten_mau = ? WHERE id_mau = ?', [$name, $id]);
            return response()->json([
                'success' => true,
                'message' => 'Cập nhập thành công!!!'
            ]);
        }
        catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi từ sever!!!'
            ]);
        }
    }

    public function deletemau(Request $request) {
        $id = $this->chuyenchuoiantoan($request->input('id'));
        try {
            db::delete('DELETE FROM mau_sac WHERE id_mau = ?', [$id]);
            return response()->json([
                'success'=>true,
                'message'=>'Xoá màu thành công!!!'
            ]);
        }
        catch(Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>'Xoá màu lỗi!!!'
            ]);
        }
    }
    
    public function addgiatien(Request $request) {
        try {
            $tengiatien = $this->chuyenchuoiantoan($request->input('TENGIATIEN'));
            $giatien = $request->input('GIATIEN');
            $soghe = $request->input('SOGHE');
            $soban = $request->input('SOBAN');
            $conggiatien = $this->chuyenchuoiantoan($request->input('CONGGIATIEN'));
            $BACKGOUNDCHUPHINHNGOAICONG = $this->chuyenchuoiantoan($request->input('BACKGOUNDCHUPHINHNGOAICONG'));
            $HOATUOI = $this->chuyenchuoiantoan($request->input('HOATUOI'));
            $CACSANPHAMDIKEM = $this->chuyenchuoiantoan($request->input('CACSANPHAMDIKEM'));
            $MOTA = $this->chuyenchuoiantoan($request->input('MOTA'));
            $listAnh = $request->file('IMAGES');
            $links = [];
            $linkanhdaidien = "";

            $anhdaidien = $request->file('THUMBNAIL');
            if ($anhdaidien) {
                \Tinify\setKey(env('TINIFY_API_KEY'));
                $duongDanTam = $anhdaidien->getRealPath();
                $anhNhoHon = \Tinify\fromFile($duongDanTam);

                $duongDanTamToiUu = sys_get_temp_dir() . '/' . uniqid() . '.png';
                $anhNhoHon->toFile($duongDanTamToiUu);

                $ketQuaUpload = (new UploadApi())->upload($duongDanTamToiUu, [
                    "folder" => "san_pham",
                    "resource_type" => "image",
                    "format" => "png"
                ]);

                $linkanhdaidien = $ketQuaUpload['secure_url'];
            }

            if ($listAnh && count($listAnh) > 0) {
                foreach ($listAnh as $anh) {
                    // ===== Nén với TinyPNG (nếu có) =====
                    \Tinify\setKey(env('TINIFY_API_KEY'));
                    $duongDanTam = $anh->getRealPath();
                    $anhNhoHon = \Tinify\fromFile($duongDanTam);

                    $duongDanTamToiUu = sys_get_temp_dir() . '/' . uniqid() . '.png';
                    $anhNhoHon->toFile($duongDanTamToiUu);

                    // ===== Upload Cloudinary =====
                    $ketQuaUpload = (new UploadApi())->upload($duongDanTamToiUu, [
                        "folder" => "san_pham",
                        "resource_type" => "image",
                        "format" => "png"
                    ]);

                    // ===== Lấy link ảnh =====
                    $duongDanCloudinary = $ketQuaUpload['secure_url'];
                    $links[] = $duongDanCloudinary;
                }
            }

            $chuoiAnh = implode('|', $links);

            $giatienid = DB::table('giatien')->insertGetId([
                'TENGIATIEN' => $tengiatien,
                'GIATIEN' => $giatien,
                'SOGHE' => $soghe,
                'SOBAN' => $soban,
                'CONGGIATIEN' => $conggiatien,
                'BACKGOUNDCHUPHINHNGOAICONG' => $BACKGOUNDCHUPHINHNGOAICONG,
                'HOATUOI' => $HOATUOI,
                'CACSANPHAMDIKEM' => $CACSANPHAMDIKEM,
                'MOTA' => $MOTA,
                'DUONGDANANH' => $chuoiAnh,
                'LINKANHDAIDIEN' => $linkanhdaidien
            ]);

            $mausac = $request->input('MAUSAC', []);
            foreach($mausac as $mau) {
                $check = DB::selectOne('SELECT * FROM gia_tien_mau_sac WHERE IDGIATIEN = ? AND id_mau = ?', [$giatienid, $mau]);
                if(!$check) {
                   DB::insert('INSERT INTO gia_tien_mau_sac (IDGIATIEN, id_mau) VALUES (?, ?)', [$giatienid, $mau]); 
                }
            }

            return response()->json([
                'success'=>true,
                'message'=>'Thêm gói thành công!!!'
            ]);

        }
        catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi bên phía sever'
            ]);
        }
    }

    public function getgiatien(Request $request) {
        $id = $this->chuyenchuoiantoan($request->input('id'));
        try {
            $giatiencantim = DB::selectOne("SELECT * FROM giatien WHERE IDGIATIEN = ?", [$id]);
            if($giatiencantim) {
                $idmausac = DB::select('SELECT id_mau FROM gia_tien_mau_sac WHERE IDGIATIEN = ?', [$id]);

                $listMau = array_map(fn($row) => (int) $row->id_mau, $idmausac);
                return response()->json([
                    'success'=>true,
                    'datatrave'=>$giatiencantim,
                    'danhsachmau'=> $listMau
                ]);
            }

            return response()->json([
                'success' => false,
                'message'=>'Không tìm thấy gia tiên'
            ]);
        }
        catch(Exception $e) {   
            return response()->json([
                'success'=>false,
                'message'=>'Lỗi sever'
            ]);
        }
    }

    public function xoaanhchitiet(Request $request) {
        try {
            $linkanhcanxoa = $this->chuyenchuoiantoan($request->input('linkanhchitiet'));
            $id = $this->chuyenchuoiantoan($request->input('idgiatien'));

            $giatien = DB::selectOne('SELECT * FROM giatien WHERE IDGIATIEN = ?', [$id]);
            if (!$giatien) {
                return response()->json([
                    'success' => false
                ]);
            }
            $duongdananhhientraitrongdb = $giatien->DUONGDANANH;
            $all_links = array_filter(explode('|', $duongdananhhientraitrongdb));

            if (!in_array($linkanhcanxoa, $all_links)) {
                return response()->json([
                    'success' => false
                ]);
            }

            $updated_links = array_diff($all_links, [$linkanhcanxoa]);
            $new_image_string = implode('|', $updated_links);
            DB::update('UPDATE giatien SET DUONGDANANH = ? WHERE IDGIATIEN = ?',[$new_image_string, $id]);
            return response()->json([
                'success' => true
            ]);
        }
        catch(Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function updategiatien(Request $request) {
        try {
            $id = $request->input('ID');
            $giatien = DB::table('giatien')->where('IDGIATIEN', $id)->first();
            if (!$giatien) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy sản phẩm!'
                ]);
            }

            $dataUpdate = [
                'TENGIATIEN' => $request->input('TENGIATIEN'),
                'GIATIEN' => $request->input('GIATIEN'),
                'SOGHE' => $request->input('SOGHE'),
                'SOBAN' => $request->input('SOBAN'),
                'CONGGIATIEN' => $request->input('CONGGIATIEN'),
                'BACKGOUNDCHUPHINHNGOAICONG' => $request->input('BACKGOUNDCHUPHINHNGOAICONG'),
                'HOATUOI' => $request->input('HOATUOI'),
                'CACSANPHAMDIKEM' => $request->input('CACSANPHAMDIKEM'),
                'MOTA' => $request->input('MOTA'),
            ];

            if ($request->hasFile('THUMBNAIL')) {
                $anh = $request->file('THUMBNAIL');

                \Tinify\setKey(env('TINIFY_API_KEY'));
                $duongDanTam = $anh->getRealPath();
                $anhNhoHon = \Tinify\fromFile($duongDanTam);
                $duongDanTamToiUu = sys_get_temp_dir() . '/' . uniqid() . '.png';
                $anhNhoHon->toFile($duongDanTamToiUu);

                $ketQuaUpload = (new UploadApi())->upload($duongDanTamToiUu, [
                    "folder" => "san_pham",
                    "resource_type" => "image",
                    "format" => "png"
                ]);
                $dataUpdate['LINKANHDAIDIEN'] = $ketQuaUpload['secure_url'];
            }

            $linksMoi = [];
            if ($request->hasFile('IMAGES')) {
                foreach ($request->file('IMAGES') as $anh) {
                    \Tinify\setKey(env('TINIFY_API_KEY'));
                    $duongDanTam = $anh->getRealPath();
                    $anhNhoHon = \Tinify\fromFile($duongDanTam);
                    $duongDanTamToiUu = sys_get_temp_dir() . '/' . uniqid() . '.png';
                    $anhNhoHon->toFile($duongDanTamToiUu);

                    $ketQuaUpload = (new UploadApi())->upload($duongDanTamToiUu, [
                        "folder" => "san_pham",
                        "resource_type" => "image",
                        "format" => "png"
                    ]);
                    $linksMoi[] = $ketQuaUpload['secure_url'];
                }
            }

            if (count($linksMoi) > 0) {
                $anhCu = $giatien->DUONGDANANH ?? '';
                $allLinks = array_filter(explode('|', $anhCu));
                $allLinks = array_merge($allLinks, $linksMoi);
                $dataUpdate['DUONGDANANH'] = implode('|', $allLinks);
            }

            DB::table('giatien')->where('IDGIATIEN', $id)->update($dataUpdate);

            $mausacChon = $request->input('MAUSAC', []);
            DB::table('gia_tien_mau_sac')->where('IDGIATIEN', $id)->delete();
            foreach ($mausacChon as $mau) {
                DB::table('gia_tien_mau_sac')->insert([
                    'IDGIATIEN' => $id,
                    'id_mau' => $mau
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật sản phẩm thành công!'
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi server: ' . $e->getMessage()
            ]);
        }
    }

    public function deletegiatien(Request $request) {
        try {
            $id = $request->input('id');
            if (!$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy id'
                ]);
            }
            $id = $this->chuyenchuoiantoan($id);
            $check = DB::delete('DELETE FROM giatien WHERE IDGIATIEN = ?', [$id]);
            if ($check) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xoá gia tiên thành công!!!'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Lỗi gì đó không xoá gia tiên được !!!'
            ]);
        }
        catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi gì đó không xoá gia tiên được !!!'
            ]);
        }
    }

    public function timkiemsanpham(Request $request) {
        try {
            $mucgia = $request->input('mucgia');
            $mau = $request->input('mau');

            $query = DB::table('giatien');
            if (!empty($mucgia)) {
                switch ($mucgia) {
                    case 3000000:
                        $query->where('GIATIEN', '<=', 3000000);
                        break;
                    case 5000000:
                        $query->where('GIATIEN', '<=', 5000000);
                        break;
                    case 10000000:
                        $query->where('GIATIEN', '<=', 10000000);
                        break;
                    case 11000000:
                        $query->where('GIATIEN', '>', 10000000);
                        break;
                }
            }

            if (!empty($mau) && $mau !== 'all') {
                $query->join('gia_tien_mau_sac', 'giatien.IDGIATIEN', '=', 'gia_tien_mau_sac.IDGIATIEN')
                    ->where('gia_tien_mau_sac.id_mau', '=', $mau)
                    ->select('giatien.*');
            }

            $ketqua = $query->get();
            return response()->json([
                'success' => true,
                'data' => $ketqua
            ]);
        }
        catch(Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>'Lỗi bên phía sever !!!'
            ]);
        }
    }

    public function quanlylienhe() {
        $adminid = session('admin_id');
        $admin = DB::selectOne('SELECT NAME FROM admin WHERE ID = ?', [$adminid]);
        $nameadmin = $admin->NAME;
        $thongtinlienhe = DB::selectOne('SELECT * FROM thongtinlienhetrangchu LIMIT 1');
        return view('Admin.lienhe', compact('nameadmin', 'thongtinlienhe'));
    }

    public function capnhapthongtinlienhe(Request $request) {
        try {
            $sdt = $request->input('sdt');
            $linkfacebook = $request->input('linkfacebook');
            $id = $request->input('id');
            DB::update('UPDATE thongtinlienhetrangchu SET SDT = ?, LINKFACEBOOK = ? WHERE ID = ?', [$sdt, $linkfacebook, $id]);
            return Response([
                'success' => true,
                'message' => "Cập nhập thành công"
            ]);
        }
        catch(Exception $e) {
            return Response([
                'success' => false,
                'message' => "Cập nhập không thành công, Lỗi " . $e->getMessage()
            ]);
        }
    }

}
