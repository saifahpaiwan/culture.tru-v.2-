<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SummernoteUploadImageController extends Controller
{
    public function summernoteUploadImageEndpoint(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_ext = strtolower($file->getClientOriginalExtension());

            // ตรวจสอบว่าเป็นรูปภาพ
            if (!in_array($file_ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                return response()->json(['error' => 'Invalid image format.'], 400);
            }

            $file_gen = hexdec(uniqid());
            $filename = $file_gen . '.' . $file_ext;
            $destinationPath = public_path('images/summernote/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // ย่อขนาดภาพให้ไม่เกิน 1280px (กว้างหรือสูง) และบีบอัด
            $image = Image::make($file)
                ->resize(1280, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize(); // ไม่ขยายภาพเล็ก
                })
                ->save($destinationPath . $filename, 75); // ค่าความคมชัด (0–100)

            return asset('images/summernote/' . $filename);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    public function deleteImageEndpoint(Request $request)
    {
        $imageUrl = $request->input('file');

        $asset = asset('');
        $explodeFile = explode($asset, $imageUrl);  

        if (isset($explodeFile[1])) {
            @unlink($explodeFile[1]);
            return response()->json(['status' => 'deleted', 'name' => $explodeFile[1]]);
        }

        return response()->json(['error' => 'file not found'], 404);
    }
}
