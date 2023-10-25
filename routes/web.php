<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/calculate-price', [DashboardController::class, 'calculate_price'])->name('dashboard.calculate_price');
Route::post('/transaksi-sampah/add', [DashboardController::class, 'add_transaksi_sampah'])->name('dashboard.transaksi_sampah.add');

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function($router) {
    $router->get('login', [AuthController::class, 'login'])->name('auth.login');
    $router->post('login', [AuthController::class, 'do_login'])->name('auth.do_login');
});
$router->get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function($router) {
    $router->get('/', [AdminController::class, 'index'])->name('admin.index');
    $router->get('/master-jenis-sampah', [AdminController::class, 'master_jenis_sampah'])->name('admin.master_jenis_sampah');
    $router->post('/master-jenis-sampah', [AdminController::class, 'add_master_jenis_sampah'])->name('admin.master_jenis_sampah.add');
    $router->get('/master-jenis-sampah/{id}/delete', [AdminController::class, 'delete_master_jenis_sampah'])->name('admin.master_jenis_sampah.delete');
});