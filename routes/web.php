<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);

})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// This is for Permissions
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])
    ->name('permissions.edit');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

// This is For Roles
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');



Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}/roles', [UserController::class, 'edit'])->name('users.roles.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

// This is for Articles

Route::resource('articles', ArticleController::class);

//This is for Employees

Route::resource('employees', EmployeeController::class);


// For application

Route::get('/application', [ApplicationController::class, 'index']);
Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');

});


// Public route
Route::get('/apply', [ApplicationController::class, 'create']);
Route::post('/apply', [ApplicationController::class, 'store']);


Route::get('/check-pdf', function () {
    $pdf = PDF::loadHTML('<h1 style="color: blue;">Success! Snappy is working.</h1>');
    // return $pdf->download('hello-world.pdf');
    return $pdf->inline();
});

require __DIR__.'/settings.php';
