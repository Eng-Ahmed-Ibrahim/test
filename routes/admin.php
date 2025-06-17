<?php
// routes/admin.php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;

// Route::middleware([EnsureTokenIsValid::class])->group(function(){

//     Route::get('/', function () {
//         return view('welcome');
//     });
    
//     Route::get("/home",function(){
//         return "Home";
//     })
//     ;
// });

Route::get('/',function(){
    return "Admin";
});