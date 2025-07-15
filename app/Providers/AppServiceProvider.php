<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Models\Deposit;
use App\Models\Withdrawal;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Prevent lazy loading locally (optional)
        if (app()->isLocal()) {
            Model::preventLazyLoading(!app()->isProduction());
        }

        // Share pending counts with all views
        view()->composer('*', function ($view) {
            $pendingDepositsCount = Deposit::where('status', 'pending')->count();
            $pendingWithdrawalsCount = Withdrawal::where('status', 'pending')->count();

            $view->with('pendingDepositsCount', $pendingDepositsCount)
                 ->with('pendingWithdrawalsCount', $pendingWithdrawalsCount);
        });
    }
}
