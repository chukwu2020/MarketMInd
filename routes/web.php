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
    IdController,
    MessageController,
    WithdrawalController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    $plans = Plan::orderBy('created_at', 'DESC')->get();
    return view('welcome', compact('plans'));
});


Auth::routes();


Route::prefix('auth')->group(function () {
    Route::get('/signup', [UserController::class, 'signup'])->name('signup');
    // Route::post('/create', [UserController::class, 'create_user'])->name('user.create');
    Route::get('/planlists', [UserController::class, 'plans_header'])->name('plans.header');
    Route::get('/about-us', [UserController::class, 'About_Us'])->name('about.us');
    Route::get('/OurServices', [UserController::class, 'services'])->name('our.services');
    Route::get('/ContactUs', [UserController::class, 'contactus'])->name('contact.us');

    // contact us 

    Route::post('/contact/send', [UserController::class, 'send'])->name('user.contact.send');
});


//language
Route::post('/set-language', function (\Illuminate\Http\Request $request) {
    session(['locale' => $request->lang]);
    return response()->json(['status' => 'ok']);
});

// web.php





Route::post('/certificate-shown', function (Request $request) {
    $count = session('overlayCountToday', 0);
    if ($count < 2) {
        session(['overlayCountToday' => $count + 1]);
    }
    return response()->json(['success' => true]);
});


// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);


// password reset
// OTP Password Reset
// Show form to request OTP
Route::get('password/forgot', [ForgotPasswordController::class, 'showOtpRequestForm'])->name('password.otp.request');

// Handle sending OTP
Route::post('password/otp-send', [ForgotPasswordController::class, 'sendOtp'])->name('password.otp.send');

// Show OTP input form
Route::get('password/otp-verify', [ForgotPasswordController::class, 'showOtpVerifyForm'])->name('password.otp.verify.form');

// Handle OTP verification and password reset
Route::post('password/otp-verify', [ForgotPasswordController::class, 'verifyOtpAndReset'])->name('password.otp.verify');

Route::get('/password/verify-otp', function () {
    return view('auth.passwords.otp_verify');
})->name('password.otp.form');



// deposit and withdrawal notication

Route::get('/user/notifications', function () {
    return view('dashboard.user.notifications');
})->middleware(['auth', 'verified'])->name('user.notifications');



// certificate 


Route::post('/certificate-shown', function () {
    // Clear the showAt timestamp so it doesn't show again
    session()->forget('certShowAt');
    return response()->json(['success' => true]);
})->middleware('auth');



Route::post('/create-user', [UserController::class, 'createUser'])->name('user.create');

Route::post('/user/take-profit', [UserController::class, 'takeProfit'])->middleware('auth');
Route::get('/verify-otp/{token}', [UserController::class, 'showVerifyOtpForm'])->name('verify.otp');


Route::post('/verify-otp', [UserController::class, 'submitOtp'])->name('otp.submit');

Route::post('/resend-otp', [UserController::class, 'resendOtp'])->name('otp.resend');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Home and Signout
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/signout', [HomeController::class, 'signout'])->name('signout');

    // Profile Routes
    Route::middleware(['auth'])->group(function () {
        // Show profile page
        Route::get('/profile', [ProfileController::class, 'userProfile'])->name('profile.show');

        // Update profile POST/PUT route
        Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

        // Update password route

        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

    // user very identity
   Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/id-verification', [IdController::class, 'create'])->name('id.verification.create');
   
    Route::post('id-verification', [IdController::class, 'store'])->name('id.verification.store');
});

Route::post('/id-alert-dismiss', [IdController::class, 'dismissAlert'])->name('id.alert.dismiss');

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/id-verifications', [IdController::class, 'index'])->name('admin.verifications.index');
    Route::post('/id-verifications/{id}/approve', [IdController::class, 'approve'])->name('admin.verifications.approve'); 
    Route::post('/id-verifications/{id}/reject', [IdController::class, 'reject'])->name('admin.verifications.reject');
});


    // Shared Routes (Dashboard investments & withdrawals)
    Route::post('/user/investments/{id}/withdraw', [InvestmentController::class, 'withdraw'])->name('investments.withdraw');


    Route::post('/dashboard/withdraw', [WithdrawalController::class, 'withdrawFromBalance'])->name('user.balance.withdraw');
    Route::get('/investments', [InvestmentController::class, 'index'])->name('user.investments');
    Route::get('/withdrawn-investments', [InvestmentController::class, 'withdrawnInvestments'])->name('user.withdrawn.investments');


    // User-specific Routes
    Route::prefix('user')->group(function () {

        // Dashboard & Profile
        Route::get('/dashboard', [UserController::class, 'user_dashboard'])->name('user_dashboard');




        // Deposit
        Route::controller(DepositController::class)->group(function () {

            Route::get('/deposit', 'userDeposit')->name('user.deposit');

            Route::post('/make-deposit', 'userMakeDeposit')->name('user.make-deposit');
            Route::get('/confirm-deposit', 'confirmDeposit')->name('deposit.confirm');
            Route::post('/submit-deposit', 'submitDeposit')->name('deposit.submit');
            Route::get('/deposit-history', 'depositHistory')->name('user.deposit-history');
        });

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



    // Admin Routes
    Route::prefix('admin')->middleware('isAdmin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'admin_dashboard'])->name('admin_dashboard');
        // 
        // admin contact us




        Route::get('/messages', [AdminController::class, 'index'])->name('admin.messages.index');
        Route::delete('/admin/messages/{message}', [AdminController::class, 'destroy'])->name('admin.messages.destroy');

        Route::middleware(['auth'])->group(function () {

            Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
            Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
        });
    });



    // Plans
    Route::prefix('plans')->group(function () {
        Route::get('/', [PlanController::class, 'planList'])->name('plan.list');
        Route::get('/create', [PlanController::class, 'addPlan'])->name('create_plan');
        Route::post('/store', [PlanController::class, 'store'])->name('plans.store');
        Route::get('/edit/{id}', [PlanController::class, 'editPlan'])->name('plan.edit');
        Route::post('/update/{id}', [PlanController::class, 'updatePlan'])->name('plan.update');
        Route::get('/delete/{id}', [PlanController::class, 'deletePlan'])->name('plan.delete');
    });

    // Wallets
    Route::prefix('wallets')->group(function () {
        Route::get('/', [WalletController::class, 'index'])->name('wallet.index');
        Route::get('/create', [WalletController::class, 'addWallet'])->name('create_wallet');
        Route::post('/store', [WalletController::class, 'storeWallet'])->name('wallet.create');
        Route::delete('/{id}', [WalletController::class, 'destroy'])->name('wallet.delete');
    });

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'userIndex'])->name('user.index');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('user.edit');
        Route::put('/{id}/update-balance', [AdminController::class, 'updateBalance'])->name('admin.users.updateBalance');
        Route::delete('/{id}', [AdminController::class, 'userDestroy'])->name('user.destroy');
    });

    // Deposits
    Route::prefix('deposits')->controller(AdminController::class)->group(function () {
        Route::get('/pending', 'pendingDeposits')->name('admin.deposits.pending');
        Route::get('/approved', 'approvedDeposits')->name('admin.deposits.approved');
        Route::post('/approve/{id}', 'approveDeposit')->name('admin.approve.deposit');
    });

    // Withdrawals
    Route::prefix('withdrawals')->group(function () {
        Route::get('/pending', [AdminController::class, 'adminViewWithdrawals'])->name('withdrawals.pending');
        Route::get('/approved', [AdminController::class, 'showApprovedWithdrawals'])->name('admin.withdrawals.approved');
        Route::post('/{id}/approve', [AdminController::class, 'approveBalanceWithdrawal'])->name('admin.approve.withdrawal');
        Route::delete('/{id}', [AdminController::class, 'withdrawaldestroy'])->name('withdraw.delete');
    });
});
