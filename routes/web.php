<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminFinanceController;
use App\Http\Controllers\AdminInvestmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\FarmerReportController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
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

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/projects', ProjectController::class);
    Route::resource('/users', UserController::class);
    Route::patch('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus');
    Route::delete('projects/{project}/media/{media}', [ProjectController::class, 'destroyMedia'])
        ->name('projects.media.destroy');
    Route::get('/reports', [AdminController::class, 'report'])->name('admin.reports.index');
    Route::get('/reports/{id}', [AdminController::class, 'show'])->name('admin.reports.show');
    Route::post('/reports/{id}/verify', [AdminController::class, 'verify'])->name('admin.reports.verify');
    Route::get('/finance', [AdminFinanceController::class, 'index'])->name('finance.index');
    Route::get('/finance/withdraw-requests', [AdminFinanceController::class, 'withdrawRequests'])->name('finance.withdraw.index');
    Route::post('/finance/withdraw/{id}/approve', [AdminFinanceController::class, 'approveWithdraw'])->name('finance.withdraw.approve');
    Route::post('/finance/withdraw/{id}/reject', [AdminFinanceController::class, 'rejectWithdraw'])->name('finance.withdraw.reject');
    Route::get('/investments', [AdminInvestmentController::class, 'index'])->name('admin.investments.index');
    Route::get('/investments/{id}/detail', [AdminInvestmentController::class, 'detail'])->name('admin.investments.detail');
    Route::post('/investments/{id}/confirm', [AdminInvestmentController::class, 'confirm'])->name('admin.investments.confirm');
    Route::post('/investments/{id}/cancel', [AdminInvestmentController::class, 'cancel'])->name('admin.investments.cancel');
});

// investor
Route::middleware(['auth', 'role:investor'])->prefix('investor')->group( function(){
    Route::get('/dashboard', [InvestorController::class, 'index'])->name('investor.dashboard');
    Route::prefix('investments')->name('investments.')->group(function(){
        Route::get('/projects', [InvestmentController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}', [InvestmentController::class, 'show'])->name('projects.show');
        Route::post('/projects/{project}/store', [InvestmentController::class, 'store'])->name('store');
        Route::get('/{investment}/pending', [InvestmentController::class, 'pending'])->name('pending');
        Route::get('/history', [InvestmentController::class, 'history'])->name('history');
        Route::post('/{investment}/cancel', [InvestmentController::class, 'cancel'])->name('cancel');
        Route::get('/{investment}/detail', [InvestmentController::class, 'detail'])->name('detail');
    });
    Route::get('/reports', [InvestorController::class, 'reportFarmer'])->name('investor.reports.index');
    Route::get('/reports/{id}', [InvestorController::class, 'showReport'])->name('investorReports.show');
    Route::get('/profile', [ProfileController::class, 'investorProfile'])->name('investor.profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('investor.profile.update');

});

Route::middleware(['auth', 'role:farmer'])->prefix('farmer')->group( function(){
    Route::get('/dashboard', [FarmerController::class, 'dashboard'])->name('farmer.dashboard');
    Route::resource('farmer/reports', FarmerReportController::class);
    Route::get('/projects/{id}', [FarmerController::class, 'showProject'])->name('farmer.projects.show');
    Route::get('/profile', [ProfileController::class, 'farmerProfile'])->name('farmer.profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('farmer.profile.update');

});


