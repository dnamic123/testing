<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ContactController;    
use App\Http\Controllers\Frontend\EventsController;
use App\Http\Controllers\Frontend\PricingController;
use App\Http\Controllers\Frontend\TrainersController;
use App\Http\Controllers\DataTablesController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VehicleController;

Route::get('/', function () {
    return view('welcome');
});


//admin routes
// 1]main dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//seprate dashboard page 
Route::get('/Dashboard', function () {
    return view('layouts.adminpages.Dashboard');
})->name('Dashboard');

//admin profile
//seprate dashboard page 
Route::get('/adminprofile', function () {
    return view('layouts.adminpages.adminprofile');
})->name('adminprofile');

//frontendquries
Route::get('/frontenquiries', [ContactController::class, 'showEnquiries'])->name('layouts.adminpages.frontenquiries');


//frontend routes

Route::get('/home', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);

Route::get('/contact', [ContactController::class, 'index']);
Route::post('contact/post', [ContactController::class, 'contact_post']);


Route::get('/courses', [CoursesController::class, 'index']);
Route::get('/events', [EventsController::class, 'index']);
Route::get('/pricing', [PricingController::class, 'index']);
Route::get('/trainers', [TrainersController::class, 'index']);





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});
//login logout

Route::get('logout', function () {
    auth()->logout();
    
    return to_route('login');
});

Route::get('login', function () {
    auth()->login();

    return to_route('dashboard');
});


require __DIR__ . '/auth.php';





//To Add New User
Route::get('addUser', function(){
    return view('layouts.adminpages.addUserNew');
});

//To employee page
Route::get('employee', function(){
    return view('layouts.adminpages.employee');
});

//To new Login
Route::get('login2', function(){
    return view('auth.login2');
});

// Add New User Form 
Route::match(['get', 'post'],'/add-user', [UserDataController::class, 'addNewUserData'])->name('add-user');


// Registered Users DataTable
Route::get('/registered-users', [UserDataController::class, 'handleRegisteredUsersData'])->name('registered-users');

// Route for viewing vehicles
Route::get('/users-vehicle-data', [UserDataController::class, 'handleUsersVehicleData'])->name('users-vehicle-data.view')
->defaults('action', 'view');

// Route for adding a vehicle
Route::match(['get', 'post'], '/add-new-vehicle/{add}', [UserDataController::class, 'handleUsersVehicleData'])->name('add-new-vehicle.add');

// Route for checking user ID existence
Route::post('/check-user-id', [UserDataController::class, 'checkUserId'])
    ->name('check-user-id');

// Route for editing a vehicle
Route::match(['get', 'post'], '/edit-vehicles-data/{edit}/{id}', [UserDataController::class, 'handleUsersVehicleData'])
    ->name('edit-vehicles-data.edit')
    ->where('id', '[0-9]+');

// Route for deleting a vehicle
Route::get('/users-vehicle-data/{delete}/{id}', [UserDataController::class, 'handleUsersVehicleData'])
    ->name('users-vehicle-data.delete')
    ->where('id', '[0-9]+');

// Route for view profile
Route::get('view-profile/{id}', [UserProfileController::class, 'viewProfile'])->where('id', '[0-9]+');