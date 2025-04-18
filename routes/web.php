<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitAttachmentController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\UnitsIndexController;
use App\Http\Controllers\UnitImportController;
use Illuminate\Http\Request;
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
Route::get('/units/showroom', [UnitsController::class, 'index'])->name('units.showroom');
Route::get('/units/create', [UnitsController::class, 'create'])->name('units.create');
Route::post('/units/store', [UnitsController::class, 'store'])->name('units.store');
Route::get('/showroom/edit/{unit_id}', [UnitsController::class, 'edit'])->name('edit-unit');
Route::get('/showroom/view',[UnitsController::class,'view'])->name('view-units');
Route::put('/showroom/update/{unit_id}', [UnitsController::class, 'update'])->name('update-unit');
Route::get('/units/showroom', [UnitsController::class, 'index'])->name('units.showroom');
// USER MANAGEMENT ROUTES
Route::resource('users', UserController::class);
Route::post('/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
// WHITEHOUSE ROUTES
Route::get('/whitehouse/dashboard', [UnitsIndexController::class, 'index'])->name('whitehouse-dash');
Route::get('/whitehouse/view', [UnitsIndexController::class, 'view'])->name('view.whitehouse');
Route::put('/whitehouse/edit/{unit_id}', [UnitsIndexController::class, 'update'])->name('update.whitehouse');
Route::get('/whitehouse/edit/{unit_id}', [UnitsIndexController::class, 'edit'])->name('edit.units');
Route::post('/update-units', [UnitsIndexController::class, 'updateUnits']);
// Route::post('/file-attachments/store/{unit_id}', [UnitsIndexController::class, 'storeFileAttachment'])->name('file-attachments.store');


// DASHBOARD
Route::get('/getChartData', [AnalyticsController::class, 'getChartData']);
Route::get('/dashboard', [AnalyticsController::class, 'dashboard'])->name('dashboard.analytics');

// REMARKS
Route::get('/units/{unit_id}/remarks', [UnitsController::class, 'remarks'])->name('units.remarks');
Route::post('/remarks/{remark_id}/edit', [UnitsController::class, 'editRemark'])->name('remarks.edit');
Route::post('/remarks/{remark_id}/delete', [UnitsController::class, 'deleteRemark'])->name('remarks.delete');

Route::post('/units/{unit_id}/add-remark', [UnitsController::class, 'addRemark'])->name('units.addRemark');
Route::get('/units/{unit_id}/fetch-remarks', [UnitsController::class, 'fetchRemarks'])->name('units.fetchRemarks');

Route::get('/php-settings', function () {
    return [
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'max_file_uploads' => ini_get('max_file_uploads'),
    ];
});

Route::prefix('unit.attach')->group(function () {
    Route::get('/unit/{unit_id}/attachments', [UnitsController::class, 'show'])->name('unit.attachments');
    Route::post('/unit/{unit_id}/attachments/upload', [UnitsController::class, 'upload'])->name('attachments.upload');
    Route::get('/attachments/download/{id}', [UnitsController::class, 'download'])->name('attachments.download');
    Route::delete('/attachments/{id}/delete', [UnitsController::class, 'delete'])->name('attachments.delete');

});
// Route::post('/test-upload', function (Request $request) {
//     // Check if the file exists
//     if (!$request->hasFile('attachment')) {
//         return back()->with('error', 'File not detected. Please try again.');
//     }

//     // Retrieve the uploaded file
//     $file = $request->file('attachment');

//     // Validate the file (2MB limit and specific MIME types)
//     $request->validate([
//         'attachment' => 'required|mimes:jpg,png,pdf|max:2048', // Adjust types as needed
//     ]);

//     // Store the file in 'attachments' folder under the 'public' disk
//     $filePath = $file->store('attachments', 'public');

//     // Log for debugging (optional)
//     \Log::info('File uploaded successfully:', [
//         'original_name' => $file->getClientOriginalName(),
//         'file_path' => $filePath,
//     ]);

//     // Return to the same page with a success message
//     return back()->with('success', 'File uploaded successfully to: ' . $filePath);
// });





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