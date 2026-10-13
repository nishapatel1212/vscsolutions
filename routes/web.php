<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SafetyCheckReportController;
use App\Http\Controllers\ServiceJobController;
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

// Route::middleware(['auth'])->group(function () {
// });
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// safetyCheck page
Route::prefix('safetycheck')->group(function () {
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

// safetyCheck page
Route::prefix('quote')->group(function () {
    Route::get('/index', [QuoteController::class, 'index'])->name('quote.index');
    Route::get('/create', [QuoteController::class, 'create'])->name('quote.create');
    Route::post('/store', [QuoteController::class, 'store'])->name('quote.store');
    Route::get('/{id}/edit', [QuoteController::class, 'edit'])->name('quote.edit');
    Route::put('/{id}', [QuoteController::class, 'update'])->name('quote.update');
    Route::get('/{id}', [QuoteController::class, 'show'])->name('quote.show');
    Route::get('/{id}/pdf', [QuoteController::class, 'downloadPdf'])->name('quote.pdf');

    Route::get('/{id}/make-invoice', [QuoteController::class, 'makeInvoice'])->name('quote.makeInvoice');
    Route::get('/{id}/invoice/edit', [QuoteController::class, 'editInvoice'])->name('quote.editInvoice');
    Route::put('/{id}/invoice', [QuoteController::class, 'updateInvoice'])->name('quote.updateInvoice');
    Route::get('/{id}/invoice', [QuoteController::class, 'showInvoice'])->name('quote.showInvoice');

    Route::post('/quotes/ai-draft', [QuoteController::class, 'aiDraft'])->name('quote.aiDraft');
});

Route::prefix('customer')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('customer.show');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
});

Route::prefix('jobs')->group(function () {
    Route::get('/', [ServiceJobController::class, 'index'])->name('jobs.index');
    Route::get('/create', [ServiceJobController::class, 'create'])->name('jobs.create');
    Route::post('/store', [ServiceJobController::class, 'store'])->name('jobs.store');
    Route::get('/{id}/edit', [ServiceJobController::class, 'edit'])->name('jobs.edit');
    Route::put('/{id}', [ServiceJobController::class, 'update'])->name('jobs.update');
    Route::delete('/{id}', [ServiceJobController::class, 'destroy'])->name('jobs.destroy');
});

Route::prefix('leads')->group(function () {
    Route::get('/', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/{id}', [LeadController::class, 'show'])->name('leads.show');
    Route::post('/{id}/status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
    Route::post('/{id}/convert', [LeadController::class, 'convert'])->name('leads.convert');
    Route::delete('/{id}', [LeadController::class, 'destroy'])->name('leads.destroy');
});

// chat page
Route::prefix('chatbot')->group(function () {
    Route::get('/index', [ChatController::class, 'index'])->name('chatbot.index');
    Route::post('/chat', [ChatController::class, 'chat'])->name('chatbot.talk');
});

Route::post('/quotes/check-price', [QuoteController::class, 'checkPrice'])->name('quote.checkPrice');



require __DIR__ . '/auth.php';
