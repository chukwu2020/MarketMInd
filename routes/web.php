<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

use App\Models\Plan;

use App\Http\Controllers\{
    AdminController,
    DepositController,
    HomeController,
    InvestmentController,
    PlanController,
    ProfileController,
    UserController,
    WalletController,
    UserCardController,
    Auth\LoginController,
    Auth\ResetPasswordController,
    Auth\ForgotPasswordController,
    MessageController,
    UserAuthController,
    UserKycController,
    WithdrawalController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', function () {
    $plans = Plan::orderBy('created_at', 'DESC')->get();
    return view('welcome', compact('plans'));
});

// Auth scaffolding
Auth::routes();

// Custom Auth pages under 'auth' prefix
Route::prefix('auth')->group(function () {
    Route::get('/signup', [UserController::class, 'signup'])->name('signup');
    // Route::post('/create', [UserController::class, 'create_user'])->name('user.create');
    Route::get('/planlists', [UserController::class, 'plans_header'])->name('plans.header');
    Route::get('/about-us', [UserController::class, 'About_Us'])->name('about.us');
    Route::get('/OurServices', [UserController::class, 'services'])->name('our.services');
    Route::get('/ContactUs', [UserController::class, 'contactus'])->name('contact.us');

    // contact us form submission
    Route::post('/contact/send', [UserController::class, 'send'])->name('user.contact.send');
});

// --- Language ---
Route::post('/set-language', function (Request $request) {
    session(['locale' => $request->lang]);
    return response()->json(['status' => 'ok']);
});

// --- Certificate Overlay ---
Route::post('/certificate-shown', function (Request $request) {
    $count = session('overlayCountToday', 0);
    if ($count < 2) {
        session(['overlayCountToday' => $count + 1]);
    }
    return response()->json(['success' => true]);
});

Route::post('/certificate-shown', function () {
    session()->forget('certShowAt');
    return response()->json(['success' => true]);
})->middleware('auth');

// --- Authentication Routes (login) ---
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// --- Password Reset & OTP Routes ---
Route::get('password/reset', function () {
    return redirect()->route('password.otp.request');
})->name('password.request');

// OTP password reset routes
Route::get('password/forgot', [ForgotPasswordController::class, 'showOtpRequestForm'])->name('password.otp.request');

// Redirect default password reset URL to OTP request


Route::post('password/otp-send', [ForgotPasswordController::class, 'sendOtp'])->name('password.otp.send');
Route::get('password/otp-verify', [ForgotPasswordController::class, 'showOtpVerifyForm'])->name('password.otp.verify.form');
Route::post('password/otp-verify', [ForgotPasswordController::class, 'verifyOtpAndReset'])->name('password.otp.verify');
Route::get('/password/verify-otp', fn() => view('auth.passwords.otp_verify'))->name('password.otp.form');

// --- Other public routes related to OTP verification ---
Route::get('/verify-otp/{token}', [UserController::class, 'showVerifyOtpForm'])->name('verify.otp');
Route::post('/verify-otp', [UserController::class, 'submitOtp'])->name('otp.submit');
Route::post('/resend-otp', [UserController::class, 'resendOtp'])->name('otp.resend');

// --- Notifications ---
Route::get('/user/notifications', fn() => view('dashboard.user.notifications'))
    ->middleware(['auth', 'verified'])
    ->name('user.notifications');

// --- User creation ---
Route::post('/create-user', [UserController::class, 'createUser'])->name('user.create');

// --- Take profit ---
Route::post('/user/take-profit', [UserController::class, 'takeProfit'])->middleware('auth');

// --- Middleware-protected routes ---
Route::middleware(['auth'])->group(function () {

    // Home and Signout
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/signout', [HomeController::class, 'signout'])->name('signout');

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'userProfile'])->name('profile.show');
        Route::put('/', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

    // Investment & Withdrawal shared routes
    Route::post('/user/investments/{id}/withdraw', [InvestmentController::class, 'withdraw'])->name('investments.withdraw');
    Route::post('/investments/{id}/take-profit', [InvestmentController::class, 'takeProfit'])->name('investments.takeProfit');

    // Dismiss banner
    Route::post('/dismiss-banner', function () {
        session(['dismissed_zero_investment_banner' => true]);
        return response()->json(['success' => true]);
    })->name('user.dismiss-banner');

    // Withdraw from balance
    Route::post('/dashboard/withdraw', [WithdrawalController::class, 'withdrawFromBalance'])->name('user.balance.withdraw');

    // Investments list
    Route::get('/investments', [InvestmentController::class, 'index'])->name('user.investments');
    Route::get('/withdrawn-investments', [InvestmentController::class, 'withdrawnInvestments'])->name('user.withdrawn.investments');

    // --- User routes under /user prefix ---
    Route::prefix('user')->group(function () {

        // Dashboard
        Route::get('/dashboard', [UserController::class, 'user_dashboard'])->name('user_dashboard');

        // Deposit routes
        Route::controller(DepositController::class)->group(function () {
            Route::get('/deposit', 'userDeposit')->name('user.deposit');
            Route::post('/make-deposit', 'userMakeDeposit')->name('user.make-deposit');
            Route::get('/confirm-deposit', 'confirmDeposit')->name('deposit.confirm');
            Route::post('/submit-deposit', 'submitDeposit')->name('deposit.submit');
            Route::get('/deposit-history', 'depositHistory')->name('user.deposit-history');
        });

        // Reinvestment
        Route::post('/initiate-reinvestment', [UserController::class, 'initiateReinvestment'])->name('initiate.reinvestment');

        // Plans
        Route::get('/planlist', [PlanController::class, 'plan_dashboard'])->name('plan.dashboard');

        // Withdrawals
        Route::get('/withdraw/form', [WithdrawalController::class, 'showWithdrawForm'])->name('user.withdraw.form');
        Route::post('/withdraw/request', [WithdrawalController::class, 'submitWithdrawRequest'])->name('balance.withdraw.request');
        Route::get('/withdrawals/list', [WithdrawalController::class, 'withdrawalList'])->name('user.withdrawals.list');

        Route::prefix('withdrawals')->controller(WithdrawalController::class)->group(function () {
            Route::get('/', 'index')->name('withdrawals.index');
            Route::post('/generate-card', 'generateCard')->name('withdrawals.generateCard');
            Route::get('/view-card', 'viewCard')->name('withdrawals.view-card');
        });
    });

    // --- Admin Routes ---
    Route::prefix('admin')->middleware('isAdmin')->group(function () {

        // Admin dashboard & withdrawals reject
        Route::get('/dashboard', [AdminController::class, 'admin_dashboard'])->name('admin_dashboard');
        Route::post('/withdrawals/{id}/reject', [AdminController::class, 'rejectBalanceWithdrawal'])->name('admin.withdraw.reject');

        // Admin messages
        Route::get('/messages', [AdminController::class, 'index'])->name('admin.messages.index');
        Route::delete('/messages/{message}', [AdminController::class, 'destroy'])->name('admin.messages.destroy');

        // Admin profile routes with auth middleware
        Route::middleware(['auth'])->group(function () {
            Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
            Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
        });
    });

    // Plans management
    Route::prefix('plans')->group(function () {
        Route::get('/', [PlanController::class, 'planList'])->name('plan.list');
        Route::get('/create', [PlanController::class, 'addPlan'])->name('create_plan');
        Route::post('/store', [PlanController::class, 'store'])->name('plans.store');
        Route::get('/edit/{id}', [PlanController::class, 'editPlan'])->name('plan.edit');
        Route::post('/update/{id}', [PlanController::class, 'updatePlan'])->name('plan.update');
        Route::get('/delete/{id}', [PlanController::class, 'deletePlan'])->name('plan.delete');
    });

    // Wallets management
    Route::prefix('wallets')->group(function () {
        Route::get('/', [WalletController::class, 'index'])->name('wallet.index');
        Route::get('/create', [WalletController::class, 'addWallet'])->name('create_wallet');
        Route::post('/store', [WalletController::class, 'storeWallet'])->name('wallet.create');
        Route::delete('/{id}', [WalletController::class, 'destroy'])->name('wallet.delete');
    });

    // Users management
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'userIndex'])->name('user.index');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('user.edit');
        Route::put('/{id}/update-balance', [AdminController::class, 'updateBalance'])->name('admin.users.updateBalance');
        Route::delete('/{id}', [AdminController::class, 'userDestroy'])->name('user.destroy');
    });

    // Deposits management
    Route::prefix('deposits')->controller(AdminController::class)->group(function () {
        Route::get('/pending', 'pendingDeposits')->name('admin.deposits.pending');
        Route::get('/approved', 'approvedDeposits')->name('admin.deposits.approved');
        Route::post('/approve/{id}', 'approveDeposit')->name('admin.approve.deposit');
    });

    // Withdrawals management
    Route::prefix('withdrawals')->group(function () {
        Route::get('/pending', [AdminController::class, 'adminViewWithdrawals'])->name('withdrawals.pending');
        Route::get('/approved', [AdminController::class, 'showApprovedWithdrawals'])->name('admin.withdrawals.approved');
        Route::post('/{id}/approve', [AdminController::class, 'approveBalanceWithdrawal'])->name('admin.approve.withdrawal');
        Route::delete('/{id}', [AdminController::class, 'withdrawaldestroy'])->name('withdraw.delete');
    });

    // --- User Document Verification ---
    Route::middleware(['verified'])->group(function () {
        Route::get('/user/kyc', [UserKycController::class, 'create'])->name('user.kyc.upload');
        Route::post('/user/kyc', [UserKycController::class, 'store'])->name('user.kyc.submit');
    });

    // Dismiss KYC alert
    Route::post('/id-verification/alert-dismiss', [UserController::class, 'dismissAlert'])
        ->name('user.kyc.dismiss-alert');

    // Admin KYC management
    Route::prefix('admin')->middleware(['isAdmin'])->group(function () {
        Route::get('kyc', [AdminController::class, 'kycindex'])->name('admin.kyc.index');
        Route::patch('kyc/{id}/approve', [AdminController::class, 'approve'])->name('admin.kyc.approve');
        Route::patch('kyc/{id}/reject', [AdminController::class, 'reject'])->name('admin.kyc.reject');
    });
});
