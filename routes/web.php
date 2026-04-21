<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SafetyCheckReportController;
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
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // chat page
    Route::prefix('chatbot')->group(function () {
        Route::get('/index', [ChatController::class, 'index'])->name('chatbot.index');
        Route::post('/chat', [ChatController::class, 'chat'])->name('chatbot.talk');
    });
});

Route::get('/dashboard', function () {
    return view('admin_panel.dashboard');
})->middleware('auth');

// safetyCheck page
Route::middleware(['auth'])->prefix('safetycheck')->group(function () {
    Route::get('/index', [SafetyCheckReportController::class, 'index'])->name('safetycheckreport.index');
    Route::get('/create', [SafetyCheckReportController::class, 'create'])->name('safetycheckreport.create');
    Route::post('/store', [SafetyCheckReportController::class, 'store'])->name('safetycheckreport.store');
    Route::get('/edit/{id}', [SafetyCheckReportController::class, 'edit'])->name('safetycheckreport.edit');
    Route::post('/update', [SafetyCheckReportController::class, 'update'])->name('safetycheckreport.update');
    Route::post('/destroy/{id}', [SafetyCheckReportController::class, 'destroy'])->name('safetycheckreport.destroy');
    Route::get('safetcheck-reports/{id}/pdf', [SafetyCheckReportController::class, 'downloadPdf'])->name('safetycheckreport.pdf');
    Route::post('/inspection-items', [SafetyCheckReportController::class, 'addInspectionItem'])->name('inspection-items.store');
    Route::post('visual-inspection-items/store', [SafetyCheckReportController::class, 'addVisualInspectionItem'])->name('visual-inspection-items.store');
    Route::post('polarity-testing-items/store', [SafetyCheckReportController::class, 'addPolarityTestingItem'])->name('polarity-testing-items.store');
    Route::post('earth-testing-items/store', [SafetyCheckReportController::class, 'addEarthTestingItem'])->name('earth-testing-items.store');
});

require __DIR__ . '/auth.php';
