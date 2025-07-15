<?php

namespace App\Console\Commands;

use App\Models\Investment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateInvestmentProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-investment-profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update investment profit daily at 12AM based on interest rate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $today = Carbon::now();

        // Get all active investments that have not yet reached the end date
        $investments = Investment::where('due', 0)->get();

        foreach ($investments as $investment) {

            if ($investment->end_date <= $today) {
                $investment->due = 1; // Mark as completed
                $investment->save();
                continue; // Skip further calculations for completed investments
            }

            // Calculate daily interest
            $dailyInterest = ($investment->amount_invested * $investment->roi) / 100;

            // Update the profit column
            $investment->profit += $dailyInterest;
            $investment->save();


        }

        $this->info('Investment profits updated successfully.');
    }
}
