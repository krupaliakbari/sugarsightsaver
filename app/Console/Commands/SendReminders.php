<?php

namespace App\Console\Commands;

use App\Services\ReminderService;
use Illuminate\Console\Command;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated reminders to patients (six-month, three-month, or all)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reminderService = new ReminderService();
        $type = $this->argument('type');

        switch ($type) {
            case 'six-month':
                $this->sendSixMonthReminders($reminderService);
                break;
            case 'three-month':
                $this->sendThreeMonthReminders($reminderService);
                break;
            case 'all':
            default:
                $this->sendAllReminders($reminderService);
                break;
        }
    }

    /**
     * Send six-month reminders
     */
    private function sendSixMonthReminders($reminderService)
    {
        $this->info('Sending 6-month follow-up reminders...');
        $sentCount = $reminderService->sendSixMonthReminders();
        $this->info("Sent {$sentCount} six-month reminders.");
    }

    /**
     * Send three-month reminders
     */
    private function sendThreeMonthReminders($reminderService)
    {
        $this->info('Sending 3-month report reminders...');
        $sentCount = $reminderService->sendThreeMonthReportReminders();
        $this->info("Sent {$sentCount} three-month report reminders.");
    }

    /**
     * Send all reminders
     */
    private function sendAllReminders($reminderService)
    {
        $this->info('Sending all reminders...');
        
        $sixMonthCount = $reminderService->sendSixMonthReminders();
        $threeMonthCount = $reminderService->sendThreeMonthReportReminders();
        
        $this->info("Sent {$sixMonthCount} six-month reminders.");
        $this->info("Sent {$threeMonthCount} three-month report reminders.");
        $this->info("Total reminders sent: " . ($sixMonthCount + $threeMonthCount));
    }
}
