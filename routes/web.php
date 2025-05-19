<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarCategoryController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'main'])->name('main');
// Main Halaman

// Halaman Profile
Route::middleware('auth')->group(function () {
    Route::get('/booking/{id}', [MainController::class, 'book'])->name('booking');
    Route::post('/booking/{id}', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/{id}', [BookingController::class, 'store'])->name('booking.store');
    // Route untuk Profile
    Route::get('user/profile', [MainController::class, 'profile'])->name('profile');
    // Route untuk memperbarui nama pengguna
    Route::post('/profile/update-name', [ProfileController::class, 'updateName'])->name('profile.updateName');
    // Route untuk mengupdate nomor telepon dan KTP
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    // Route untuk mengupdate tanggal lahir
    Route::post('/profile/update-dob', [ProfileController::class, 'updateDob'])->name('profile.updateDob');
    // Route untuk mengupdate jenis kelamin
    Route::post('/profile/update-gender', [ProfileController::class, 'updateGender'])->name('profile.updateGender');
    // Route untuk mengupdate email
    Route::post('/profile/update-email-request', [ProfileController::class, 'sendEmailConfirmation'])->name('profile.updateEmailRequest');
    Route::get('/profile/confirm-email/{token}', [ProfileController::class, 'confirmEmail'])->name('profile.confirmEmail');
    // Route untuk merubah password
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    // Route untuk merubah foto profile
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.upload_photo');
});

// Route untuk login dengan Google
Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Route untuk login manual
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Route untuk registrasi manual
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Route untuk menampilkan form pembaruan profil (untuk pengguna yang login dengan Google)
Route::get('/profile/update', [ProfileController::class, 'showProfileUpdateForm'])->name('profile.update');

// Route untuk mengupdate nomor telepon dan KTP
Route::post('/profile/update', [ProfileController::class, 'updateProfile']);

// Route untuk dashboard admin (hanya untuk admin atau super admin)
Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    // Route untuk halaman dashboard index
    Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    //Route untuk halaman kategori mobil
    Route::get('/dashboard/kategori-mobil', [CarCategoryController::class, 'kategoriDashboard'])->name('kategori-mobil.dashboard');
    // route untuk untuk menampilkan data kategori mobil
    Route::post('/dashboard/kategori-mobil', [CarCategoryController::class, 'store'])->name('car_categories.store');
    // Route untuk update kategori mobil
    Route::put('/dashboard/kategori-mobil/{carCategory}', [CarCategoryController::class, 'update'])->name('car_categories.update');
    // route untuk untuk menghapus data ketegori
    Route::delete('/dashboard/kategori-mobil/{carCategory}', [CarCategoryController::class, 'destroy'])->name('car_categories.destroy');
    //Route untuk halaman kategori mobil
    Route::get('/dashboard/data-mobil', [CarController::class, 'datamobilDashboard'])->name('data-mobil.dashboard');

    Route::post('/dashboard/data-mobil', [CarController::class, 'store'])->name('cars.store');

    Route::post('/dashboard/data-mobil', [CarController::class, 'store'])->name('cars.store');

    Route::put('/dashboard/data-mobil/{car}', [CarController::class, 'update'])->name('cars.update');

    Route::delete('/dashboard/data-mobil/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    //Route untuk halaman booking mobil
    Route::get('/dashboard/data-car-berjalan', [BookingController::class, 'index'])->name('data-car-berjalan');
    Route::get('/dashboard/data-booking', [BookingController::class, 'databookingDashboard'])->name('data-booking.dashboard');
    Route::post('/admin/bookings/{id}/approve', [BookingController::class, 'approve'])->name('admin.bookings.approve');
    Route::post('/admin/bookings/{id}/reject', [BookingController::class, 'reject'])->name('admin.bookings.reject');

    Route::get('/dashboard/users', [UserController::class, 'usersDashboard'])->name('users.dashboard');

    Route::get('/dashboard/users/create', [UserController::class, 'create'])->name('users.create');

    Route::post('/dashboard/users', [UserController::class, 'store'])->name('users.store');

    Route::get('/dashboard/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::put('/dashboard/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::delete('/dashboard/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/dashboard/users/{id}/change-status', [UserController::class, 'changeStatus'])->name('users.changeStatus');

    // Route untuk menampilkan data admin
    Route::get('/dashboard/admin', [AdminController::class, 'dataAdminDashboard'])->name('data-admin.dashboard');
    // Route untuk menambahkan admin
    Route::post('/dashboard/admin/store', [AdminController::class, 'store'])->name('users.store');
    // Route untuk mengupdate admin
    Route::put('/dashboard/admin/{id}', [AdminController::class, 'update'])->name('users.update');
    // Route untuk menghapus admin
    Route::delete('/dashboard/admin/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    // Route untuk mengubah status (ban/unban) admin
    Route::post('/dashboard/admin/{id}/change-status', [AdminController::class, 'changeStatus'])->name('users.changeStatus');
});

// Route untuk logout   
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
