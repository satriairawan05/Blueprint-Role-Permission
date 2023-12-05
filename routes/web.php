<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function(){
    // Role
    Route::resource('role', RoleController::class);
    Route::post('/role/{role}/permission', [RoleController::class, 'givePermission'])->name('role.permission.store');
    Route::delete('/role/{role}/permission/{permission}', [RoleController::class, 'revokePermission'])->name('role.permission.revoke');
    
    // Permission
    Route::resource('permission', PermissionController::class);
    Route::post('/permission/{permission}/role',[PermissionController::class, 'assignRole'])->name('permission.role.store');
    Route::delete('/permission/{permission}/role/{role}',[PermissionController::class, 'removeRole'])->name('permission.role.remove');
    
    // User
    Route::resource('user', AccountController::class);
    Route::post('user/{user}/role',[AccountController::class, 'role'])->name('user.role');
    Route::delete('user/{user}/role/{role}',[AccountController::class, 'removeRole'])->name('user.role.destroy');
    Route::post('user/{user}/permission',[AccountController::class, 'permission'])->name('user.permission');
    Route::delete('user/{user}/permission/{permission}',[AccountController::class, 'removePermission'])->name('user.permission.destroy');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
