<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\JobTypeKeywordController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuotePriceItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SafetyCheckReportController;
use App\Http\Controllers\ServiceJobController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SmsTemplateController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // safetyCheck page
    Route::prefix('safetycheck')->middleware('permission:manage-safety-checks')->group(function () {
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

    // quotes & invoices
    Route::prefix('quote')->middleware('permission:manage-quotes')->group(function () {
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

    Route::post('/quotes/check-price', [QuoteController::class, 'checkPrice'])->name('quote.checkPrice')->middleware('permission:manage-quotes');

    Route::prefix('customer')->middleware('permission:manage-customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
        Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/{id}', [CustomerController::class, 'show'])->name('customer.show');
        Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    });

    Route::prefix('certificates')->middleware('permission:manage-certificates')->group(function () {
        Route::get('/', [CertificateController::class, 'index'])->name('certificates.index');
        Route::get('/create', [CertificateController::class, 'create'])->name('certificates.create');
        Route::post('/store', [CertificateController::class, 'store'])->name('certificates.store');
        Route::get('/{id}/edit', [CertificateController::class, 'edit'])->name('certificates.edit');
        Route::put('/{id}', [CertificateController::class, 'update'])->name('certificates.update');
        Route::delete('/{id}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
        Route::get('/{id}/pdf', [CertificateController::class, 'downloadPdf'])->name('certificates.pdf');
    });

    Route::prefix('jobs')->middleware('permission:manage-jobs')->group(function () {
        Route::get('/', [ServiceJobController::class, 'index'])->name('jobs.index');
        Route::get('/calendar', [ServiceJobController::class, 'calendar'])->name('jobs.calendar');
        Route::get('/calendar-events', [ServiceJobController::class, 'calendarEvents'])->name('jobs.calendarEvents');
        Route::patch('/{id}/reschedule', [ServiceJobController::class, 'reschedule'])->name('jobs.reschedule');
        Route::get('/create', [ServiceJobController::class, 'create'])->name('jobs.create');
        Route::post('/store', [ServiceJobController::class, 'store'])->name('jobs.store');
        Route::get('/{id}/edit', [ServiceJobController::class, 'edit'])->name('jobs.edit');
        Route::put('/{id}', [ServiceJobController::class, 'update'])->name('jobs.update');
        Route::delete('/{id}', [ServiceJobController::class, 'destroy'])->name('jobs.destroy');
    });

    Route::prefix('leads')->middleware('permission:manage-leads')->group(function () {
        Route::get('/', [LeadController::class, 'index'])->name('leads.index');
        Route::get('/{id}', [LeadController::class, 'show'])->name('leads.show');
        Route::post('/{id}/status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
        Route::post('/{id}/convert', [LeadController::class, 'convert'])->name('leads.convert');
        Route::delete('/{id}', [LeadController::class, 'destroy'])->name('leads.destroy');
    });

    // chat page
    Route::prefix('chatbot')->middleware('permission:use-chatbot')->group(function () {
        Route::get('/index', [ChatController::class, 'index'])->name('chatbot.index');
        Route::post('/chat', [ChatController::class, 'chat'])->name('chatbot.talk');
    });

    Route::prefix('audit-logs')->middleware('permission:view-audit-logs')->group(function () {
        Route::get('/', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });

    Route::prefix('users')->middleware('permission:manage-users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('roles')->middleware('permission:manage-roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    Route::prefix('email-templates')->middleware('permission:manage-email-templates')->group(function () {
        Route::get('/', [EmailTemplateController::class, 'index'])->name('email-templates.index');
        Route::get('/create', [EmailTemplateController::class, 'create'])->name('email-templates.create');
        Route::post('/store', [EmailTemplateController::class, 'store'])->name('email-templates.store');
        Route::get('/{id}/edit', [EmailTemplateController::class, 'edit'])->name('email-templates.edit');
        Route::put('/{id}', [EmailTemplateController::class, 'update'])->name('email-templates.update');
        Route::delete('/{id}', [EmailTemplateController::class, 'destroy'])->name('email-templates.destroy');
        Route::get('/{id}/send', [EmailTemplateController::class, 'showSend'])->name('email-templates.showSend');
        Route::post('/{id}/send', [EmailTemplateController::class, 'send'])->name('email-templates.send');
        Route::get('/{id}/log', [EmailTemplateController::class, 'sendLog'])->name('email-templates.log');
    });

    Route::prefix('sms-templates')->middleware('permission:manage-sms-templates')->group(function () {
        Route::get('/', [SmsTemplateController::class, 'index'])->name('sms-templates.index');
        Route::get('/create', [SmsTemplateController::class, 'create'])->name('sms-templates.create');
        Route::post('/store', [SmsTemplateController::class, 'store'])->name('sms-templates.store');
        Route::get('/{id}/edit', [SmsTemplateController::class, 'edit'])->name('sms-templates.edit');
        Route::put('/{id}', [SmsTemplateController::class, 'update'])->name('sms-templates.update');
        Route::delete('/{id}', [SmsTemplateController::class, 'destroy'])->name('sms-templates.destroy');
        Route::get('/{id}/send', [SmsTemplateController::class, 'showSend'])->name('sms-templates.showSend');
        Route::post('/{id}/send', [SmsTemplateController::class, 'send'])->name('sms-templates.send');
        Route::get('/{id}/log', [SmsTemplateController::class, 'sendLog'])->name('sms-templates.log');
    });

    Route::prefix('settings')->middleware('permission:manage-settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');

        Route::get('/company-profile', [CompanyProfileController::class, 'edit'])->name('settings.company-profile.edit');
        Route::put('/company-profile', [CompanyProfileController::class, 'update'])->name('settings.company-profile.update');

        Route::get('/job-keywords', [JobTypeKeywordController::class, 'index'])->name('settings.job-keywords.index');
        Route::post('/job-keywords', [JobTypeKeywordController::class, 'store'])->name('settings.job-keywords.store');
        Route::put('/job-keywords/{id}', [JobTypeKeywordController::class, 'update'])->name('settings.job-keywords.update');
        Route::delete('/job-keywords/{id}', [JobTypeKeywordController::class, 'destroy'])->name('settings.job-keywords.destroy');

        Route::get('/price-list', [QuotePriceItemController::class, 'index'])->name('settings.price-list.index');
        Route::post('/price-list', [QuotePriceItemController::class, 'store'])->name('settings.price-list.store');
        Route::put('/price-list/{id}', [QuotePriceItemController::class, 'update'])->name('settings.price-list.update');
        Route::delete('/price-list/{id}', [QuotePriceItemController::class, 'destroy'])->name('settings.price-list.destroy');
    });

    Route::prefix('permissions')->middleware('permission:manage-roles')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/{id}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

});

require __DIR__ . '/auth.php';
