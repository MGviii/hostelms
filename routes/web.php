<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\RoomRequestController;
use App\Http\Middleware\StudentMiddleware;

// Authentication Routes
Auth::routes();

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Blocks Management Routes
    Route::get('/admin/blocks', [AdminController::class, 'blocksIndex'])->name('admin.blocks.index');
    Route::get('/admin/blocks/create', [AdminController::class, 'blocksCreate'])->name('admin.blocks.create');
    Route::post('/admin/blocks', [AdminController::class, 'blocksStore'])->name('admin.blocks.store');
    Route::get('/admin/blocks/{block}/edit', [AdminController::class, 'blocksEdit'])->name('admin.blocks.edit');
    Route::put('/admin/blocks/{block}', [AdminController::class, 'blocksUpdate'])->name('admin.blocks.update');
    Route::delete('/admin/blocks/{block}', [AdminController::class, 'blocksDestroy'])->name('admin.blocks.destroy');

    // Rooms Management Routes
    Route::get('/admin/rooms', [AdminController::class, 'roomsIndex'])->name('admin.rooms.index');
    Route::get('/admin/rooms/create', [AdminController::class, 'roomsCreate'])->name('admin.rooms.create');
    Route::post('/admin/rooms', [AdminController::class, 'roomsStore'])->name('admin.rooms.store');
    Route::get('/admin/rooms/{room}/edit', [AdminController::class, 'roomsEdit'])->name('admin.rooms.edit');
    Route::put('/admin/rooms/{room}', [AdminController::class, 'roomsUpdate'])->name('admin.rooms.update');
    Route::delete('/admin/rooms/{room}', [AdminController::class, 'roomsDestroy'])->name('admin.rooms.destroy');

    // Room Allocations Management Routes
    Route::get('/admin/allocations', [AdminController::class, 'allocationsIndex'])->name('admin.allocations.index');
    Route::get('/admin/allocations/create', [AdminController::class, 'allocationsCreate'])->name('admin.allocations.create');
    Route::post('/admin/allocations', [AdminController::class, 'allocationsStore'])->name('admin.allocations.store');
    Route::get('/admin/allocations/{allocation}/edit', [AdminController::class, 'allocationsEdit'])->name('admin.allocations.edit');
    Route::put('/admin/allocations/{allocation}', [AdminController::class, 'allocationsUpdate'])->name('admin.allocations.update');
    Route::delete('/admin/allocations/{allocation}', [AdminController::class, 'allocationsDestroy'])->name('admin.allocations.destroy');

    // Room Requests Management Routes
    Route::get('/admin/requests', [AdminController::class, 'requestsIndex'])->name('admin.requests.index');
    Route::post('/admin/requests/{request}/approve', [AdminController::class, 'requestsApprove'])->name('admin.requests.approve');
    Route::post('/admin/requests/{request}/reject', [AdminController::class, 'requestsReject'])->name('admin.requests.reject');
});

// Student Routes
Route::middleware(['auth', StudentMiddleware::class])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');

    // Room Request Routes
    Route::get('/student/requests', [RoomRequestController::class, 'index'])->name('student.requests.index');
    Route::get('/student/requests/create', [RoomRequestController::class, 'create'])->name('student.requests.create');
    Route::post('/student/requests', [RoomRequestController::class, 'store'])->name('student.requests.store');
    Route::get('/student/requests/{request}', [RoomRequestController::class, 'show'])->name('student.requests.show');
    Route::delete('/student/requests/{request}', [RoomRequestController::class, 'cancel'])->name('student.requests.cancel');
});
