<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\SaleDeedController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\Finance\ReceiptsController;

use App\Http\Controllers\AgreementPaymentController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\FeedbackController;



/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::view('/', 'home')->name('home');
Route::view('/feedback', 'feedback')->name('feedback');
Route::post('/submit-request',[FeedbackController::class,'storeRequest']);
Route::post('/submit-feedback',[FeedbackController::class,'storeFeedback']);
/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/agreements/{agreement}/receipt', 
    [AgreementPaymentController::class, 'view']
)->name('agreements.receipt.view');

Route::get('/agreements/{agreement}/receipt/download', 
    [AgreementPaymentController::class, 'download']
)->name('agreements.receipt.download');

/*
|--------------------------------------------------------------------------
| COMMON AUTHENTICATED ROUTES (ADMIN + SALES)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /* PLOTS */
    Route::get('/plots', [PlotController::class, 'index'])->name('plots.index');
    Route::get('/plots/{id}', [PlotController::class, 'show'])->name('plots.show');

    /* BOOKING */
    Route::get('/plots/{id}/booking', [PlotController::class, 'booking'])->name('plot.booking');
    Route::post('/plots/{id}/booking', [PlotController::class, 'storeBooking'])->name('plot.booking.store');

    /* BOOKINGS */
    Route::get('/bookings', [PlotController::class, 'bookingIndex'])->name('bookings.index');
    Route::get('/bookings/{id}', [PlotController::class, 'bookingShow'])->name('bookings.show');

    /* BOOKING RECEIPT */
    Route::get('/bookings/{id}/receipt', [PlotController::class, 'bookingReceipt'])
        ->name('bookings.receipt');
    Route::get('/bookings/{id}/receipt/download', [PlotController::class, 'downloadReceipt'])
        ->name('bookings.receipt.download');

    /* AGREEMENTS */
    Route::get('/agreements/due', [AgreementController::class, 'dueList'])
        ->name('agreements.due');

    Route::get('/agreements/{booking}/create', [AgreementController::class, 'create'])
        ->name('agreements.create');

    Route::post('/agreements/{booking}', [AgreementController::class, 'store'])
        ->name('agreements.store');

    Route::get('/agreements/{agreement}', [AgreementController::class, 'show'])
        ->name('agreements.view');

    Route::get('/agreements/{agreement}/pdf', [AgreementController::class, 'downloadPdf'])
        ->name('agreements.pdf');

    Route::get('/agreements/{agreement}/word', [AgreementController::class, 'downloadWord'])
        ->name('agreements.word');

    /* SALE DEEDS */
    Route::get('/sale-deeds', [SaleDeedController::class, 'index'])
        ->name('sale-deeds.index');

    Route::get('/sale-deeds/create/{agreement}', [SaleDeedController::class, 'create'])
        ->name('sale-deeds.create');

    Route::post('/sale-deeds/store/{agreement}', [SaleDeedController::class, 'store'])
        ->name('sale-deeds.store');

    Route::get('/sale-deeds/view/{saleDeed}', [SaleDeedController::class, 'show'])
        ->name('sale-deeds.show');

    Route::get('/sale-deeds/download-word/{saleDeed}', [SaleDeedController::class, 'downloadWord'])
        ->name('sale-deeds.download.word');


    Route::get('/sale-payment/plot', [PaymentController::class, 'plotForm'])
        ->name('payments.plot');

    Route::post('/sale-payment/fetch', [PaymentController::class, 'fetchBooking'])
        ->name('payments.fetch');

    Route::post('/sale-payment/store/{booking}', [PaymentController::class, 'store'])
        ->name('payments.store');

    Route::get('/sale-payment/receipt/{payment}', [PaymentController::class, 'receipt'])
        ->name('payments.receipt');

    Route::get('/sale-payment/receipt/view/{payment}', [PaymentController::class, 'receiptView'])
        ->name('payments.receipt.view');

    Route::get('/sale-payment/receipt/download/{payment}', [PaymentController::class, 'receiptDownload'])
        ->name('payments.receipt.download');

});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'adminonly'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /* ADMIN DASHBOARD */
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])
            ->name('dashboard');

        /* FINANCE */
        Route::get('/finance/receipts',[ReceiptsController::class, 'index'])
            ->name('finance.receipts');
        Route::get('/finance', [FinanceController::class, 'index'])
            ->name('finance');
        /* FINANCE RECEIPTS (ADMIN) */
        Route::get('/finance/receipts', [ReceiptsController::class, 'index'])
            ->name('finance.receipts');

        Route::get('/finance/receipts/{receipt}/view', [ReceiptsController::class, 'view'])
            ->name('finance.receipts.view');

        Route::get('/finance/receipts/{receipt}/pdf', [ReceiptsController::class, 'pdf'])
            ->name('finance.receipts.pdf');

            
        Route::post('/finance/download', [FinanceController::class, 'download'])
            ->name('finance.download');
        Route::get('/admin/dashboard',[FeedbackController::class,'dashboard']);
        /* USERS */
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{id}/update', [AdminUserController::class, 'update'])->name('users.update');
        Route::get('/users/{id}/delete', [AdminUserController::class, 'destroy'])->name('users.delete');

        /* PLOTS CRUD */
        Route::get('/plots', [PlotController::class, 'index'])->name('plots.index');
        Route::get('/plots/create', [PlotController::class, 'create'])->name('plots.create');
        Route::post('/plots', [PlotController::class, 'store'])->name('plots.store');
        Route::get('/plots/{id}/edit', [PlotController::class, 'edit'])->name('plots.edit');
        Route::put('/plots/{id}', [PlotController::class, 'update'])->name('plots.update');
        Route::delete('/plots/{id}', [PlotController::class, 'destroy'])->name('plots.destroy');

        Route::post('/plots/{id}/extend', [PlotController::class, 'extendAgreement'])
            ->name('plots.extend');

        Route::get('/plots/trash', [PlotController::class, 'trash'])->name('plots.trash');
        Route::post('/plots/{id}/restore', [PlotController::class, 'restore'])->name('plots.restore');
        Route::delete('/plots/{id}/force-delete', [PlotController::class, 'forceDelete'])
            ->name('plots.forceDelete');



        /* EXPENDITURE */
    Route::get('/expenditure', [FinanceController::class, 'expenditure'])
        ->name('expenditure');

    Route::post('/expenditure/category', [FinanceController::class, 'storeCategory'])
        ->name('expenditure.category.store');

    Route::post('/expenditure/expense', [FinanceController::class, 'storeExpense'])
        ->name('expenditure.expense.store');

    Route::get('/expenditure/download/excel', [FinanceController::class, 'downloadExpensesExcel'])
        ->name('expenditure.download.excel');

    Route::get('/expenditure/download/csv', [FinanceController::class, 'downloadCsv'])
        ->name('expenditure.download.csv');

    
    Route::get('/requests-feedback',[FeedbackController::class,'showTables'])
    ->name('requests.feedback');


});

/*
|--------------------------------------------------------------------------
| SALES ONLY ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'salesonly'])
    ->prefix('sales')
    ->name('sales.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'salesDashboard'])
            ->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| QUICK TEST
|--------------------------------------------------------------------------
*/
Route::get('/test', function () {
    return 'Laravel routing OK';
});
