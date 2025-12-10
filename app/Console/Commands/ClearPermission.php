<?php

namespace App\Console\Commands;

use App\Models\ModulePermissions;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ClearPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:clearpermission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin Auth permission clear within 24 hour';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ModulePermissions::where('permission_status', 1)
        ->where('permisson_end_time', '<', Carbon::now()->subHours(24))
        ->delete();

        if(ModulePermissions::count() == 0){
            ModulePermissions::truncate();
        }

        $this->info('Old permissions deleted successfully.');
    }
}
