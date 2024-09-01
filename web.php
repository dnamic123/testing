<?php


use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Frontend\ContactController;  
use App\Http\Controllers\Admin\AdminHomeController;  
use App\Http\Controllers\Admin\AdminLoginController;  
use App\Http\Middleware\GuestAdminMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;


//frontend routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/courses', [HomeController::class, 'courses']);
Route::get('/events', [HomeController::class, 'events']);
Route::get('/pricing', [HomeController::class, 'pricing']);
Route::get('/trainers', [HomeController::class, 'trainers']);
Route::post('contact/post', [ContactController::class, 'contact_post']);


//Admin's Login & Dashboard Routes
Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware([GuestAdminMiddleware::class])->group(function(){
        Route::get('/login', [AdminLoginController::class, 'index']);
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login');
    });

    Route::middleware(['auth', AdminMiddleware::class])->group(function(){
        Route::get('/dashboard', [AdminHomeController::class, 'index'])->name('dashboard');
    });
});


Auth::routes();
// Hello This is my new changes

//User's Dashboard
Route::get('/dashboard', [HomeController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware(UserMiddleware::class);

    
//User's Profile Page Routes
Route::prefix('profile')->name('profile.')->group(function(){  
    Route::get('/view', [ProfileController::class, 'index']);
    Route::post('/update', [ProfileController::class, 'update'])->name('update');
});
