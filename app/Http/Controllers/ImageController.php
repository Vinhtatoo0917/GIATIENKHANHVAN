<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,png,jpeg|max:5120', // max 5MB
            'id'   => 'required|integer'
        ]);

        $uploadedFileUrl = Cloudinary::upload($request->file('file')->getRealPath(), [
            'folder' => 'anhdautrang'
        ])->getSecurePath();
        
        DB::table('anhdautrang')
            ->where('ID', $request->id)
            ->update(['DUONGDAN' => $uploadedFileUrl]);

        return response()->json([
            'success' => true,
            'url' => $uploadedFileUrl
        ]);
    }
}
