<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('HomeView');
    })->name('dashboard');
});
Route::middleware(['auth'])->group(
    function () {
        Route::prefix('permissions')->as('permissions.')->group(function () {
            Route::get('', [PermissionController::class, 'index'])->name('index');
            Route::post('', [PermissionController::class, 'store'])->name('store');
            Route::put('/update/{id}', [PermissionController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [PermissionController::class, 'delete'])->name('delete');
        });
        Route::prefix('roles')->as('roles.')->group(function () {
            Route::get('', [RolesController::class, 'index'])->name('index');
            Route::post('', [RolesController::class, 'store'])->name('store');
            Route::put('/update/{id}', [RolesController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [RolesController::class, 'delete'])->name('delete');
        });

        Route::prefix('users')->as('users.')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('index');
            Route::post('', [UserController::class, 'store'])->name('store');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('setActive', [UserController::class, 'setActive'])->name('setActive');


            // Route::post('import',  [UserController::class, 'importUser'])->name('import');
            // Route::post('update-users',  [UserController::class, 'updateUsers'])->name('update-users');
            // Route::get('updateDemo', [UserController::class, 'updateDemo'])->name('update-demo');
        });

    }
);
