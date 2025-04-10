<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\WhitehouseController;
use App\Http\Controllers\UnitImportController;
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
    return view('login');
});
Route::get('/welcome', [AuthController::class, 'welcome'])->name('welcome');
Route::get('/login/load', [AuthController::class, 'LoadLogin'])->name('Login-page');
Route::post('/login/post', [AuthController::class, 'Login'])->name('Login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
  
// SHOWROOM ROUTES
Route::get('/units/showroom', [ShowroomController::class, 'index'])->name('units.showroom');
Route::get('/units/create', [ShowroomController::class, 'create'])->name('units.create');
Route::post('/units/store', [ShowroomController::class, 'store'])->name('units.store');
Route::get('/showroom/edit/{rec_id}', [ShowroomController::class, 'edit'])->name('edit-unit');
Route::get('/showroom/view',[ShowroomController::class,'view'])->name('view-units');
Route::put('/showroom/update/{rec_id}', [ShowroomController::class, 'update'])->name('update-unit');
Route::get('/units/showroom', [ShowroomController::class, 'index'])->name('units.showroom');
// USER MANAGEMENT ROUTES
Route::resource('users', UserController::class);
Route::get('/users/{id}', [UserController::class, 'show'])->middleware('auth')->name('users.show');
Route::post('/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
// WHITEHOUSE ROUTES
Route::get('/whitehouse/dashboard', [WhitehouseController::class, 'index'])->name('whitehouse-dash');
Route::get('/whitehouse/view', [WhitehouseController::class, 'view'])->name('view.whitehouse');
Route::put('/whitehouse/edit/{rec_id}', [WhitehouseController::class, 'update'])->name('update.whitehouse');
Route::get('/whitehouse/edit/{rec_id}', [WhitehouseController::class, 'edit'])->name('edit.whitehouse');
Route::post('/update-units', [WhitehouseController::class, 'updateUnits']);
Route::post('/file-attachments/store/{rec_id}', [WhitehouseController::class, 'storeFileAttachment'])->name('file-attachments.store');


// DASHBOARD
Route::get('/getChartData', [AnalyticsController::class, 'getChartData']);
Route::get('/dashboard', [AnalyticsController::class, 'dashboard'])->name('dashboard.analytics');



// UNIT IMPORT ROUTES
Route::get('/units/import', [UnitImportController::class,'showUploadForm'])->name('import.form');
Route::post('/units/import-excel', [UnitImportController::class,'importExcel'])->name('import');

// Admin Routes
Route::middleware(['admin'])->prefix('admin')->group(function () {

});

// User (View Role) Routes
// Route::middleware(['view'])->prefix('user')->group(function () {
//     Route::get('/index', function () {
//         return view('user.index');
//     })->name('user.index');
// });