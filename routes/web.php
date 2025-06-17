<?php

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// routes/web.php

use App\Http\Controllers\TestController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Controllers\VideoUploadController;

Route::get('/upload', function () {
    return view('upload');
})->name('upload.page');

Route::post('/upload-video', [VideoUploadController::class, 'upload'])->name('video.upload');




Route::view('form','form');
Route::post('/upload-file',function(Request $request){
    $image_name=$request->file->getClientOriginalName();
    $path=$request->file->storeAs("/images",$image_name,'local');
    // store name of image 
        // storeAs("/path",imageName,'disk')
        // local =>for private files that i don't want any one access outside website
        // public=> store in storage and public that files it's okay that anyone can access like website logo
return $image_name;
})->name('upload_file');
Route::get('/delete-image',function(){
    // Storage::disk("public")->delete('images/assets_task_01js7j3prbeavtvf8yyfyy3ca5_img_0.webp');
    Storage::disk("localf")->delete('images/assets_task_01js7j3prbeavtvf8yyfyy3ca5_img_0.webp');
    return "done";
});

Route::get('image/{filename}', function ($filename) {
    // here can manage who can access files
        if (!Auth::check()) {
        return redirect()->route('login');
    }

    
    $path = storage_path('app/private/images/' . $filename);

    // التحقق مما إذا كان الملف موجودًا
    if (file_exists($path)) {
        return response()->file($path); // إرجاع الملف إذا كان موجودًا
    }

    return abort(404); // إرجاع 404 إذا كان الملف غير موجود
});

Route::get("/send-mail",[TestController::class,'sendMail'])->name('send.mail');
    

Route::get("/users",[TestController::class,'users'])->name('users.index');