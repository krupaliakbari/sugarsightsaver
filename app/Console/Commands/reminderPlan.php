<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Console\Command;
use Carbon\Carbon;

class reminderPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:reminderplan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder for next review date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $userIds = User::role('patient')->where('reminder_status', 1)->pluck('id')->toArray();

        $reminderSend = UserPlan::whereIn('user_id', $userIds)
            ->where('plan_status', 'completed')
            ->whereNotNull('review_date')
            ->whereDate('review_date', '<', now())
            ->pluck('id')
            ->toArray();

        UserPlan::sendreviewNotification($reminderSend);

        $reminderNotSend = UserPlan::whereNotIn('user_id', $userIds)
        ->where('plan_status', 'completed')
        ->whereNotNull('review_date')
        ->whereDate('review_date', '<', now())
        ->pluck('id')
        ->toArray();

        UserPlan::updatereviewDateWithoutNotification($reminderNotSend);
        

    }
}
