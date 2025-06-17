<?php

// app/Http/Controllers/VideoUploadController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Resumable.js يرسل معلومات القطعة في هذه الحقول:
        $resumableIdentifier = $request->resumableIdentifier; // معرف الملف
        $resumableFilename = $request->resumableFilename; // اسم الملف
        $resumableChunkNumber = (int)$request->resumableChunkNumber; // رقم القطعة
        $resumableTotalChunks = (int)$request->resumableTotalChunks; // إجمالي عدد القطع

        $uploadDir = storage_path('app/uploads/' . $resumableIdentifier);
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // حفظ القطعة المرفوعة مؤقتاً في مجلد
        $chunkFile = $uploadDir . '/chunk' . $resumableChunkNumber;
        $request->file('file')->move($uploadDir, 'chunk' . $resumableChunkNumber);

        // بعد رفع آخر قطعة، نجمع القطع مع بعض
        if ($this->allChunksUploaded($uploadDir, $resumableTotalChunks)) {
            $finalPath = storage_path('app/uploads/') . '/' . $resumableFilename;
            $out = fopen($finalPath, 'wb');

            for ($i = 1; $i <= $resumableTotalChunks; $i++) {
                $chunk = fopen($uploadDir . '/chunk' . $i, 'rb');
                stream_copy_to_stream($chunk, $out);
                fclose($chunk);
            }

            fclose($out);

            // تنظيف الملفات المؤقتة
            $this->deleteDir($uploadDir);

            return response()->json(['success' => true, 'message' => 'تم رفع وتجميع الفيديو']);
        }

        // إرجاع رد بدون دمج إذا باقي قطع
        return response()->json(['success' => true, 'message' => 'تم رفع قطعة']);
    }

    private function allChunksUploaded($dir, $totalChunks)
    {
        for ($i = 1; $i <= $totalChunks; $i++) {
            if (!file_exists($dir . '/chunk' . $i)) {
                return false;
            }
        }
        return true;
    }

    private function deleteDir($dir)
    {
        if (!is_dir($dir)) return;
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            unlink($dir . '/' . $file);
        }
        rmdir($dir);
    }
}
