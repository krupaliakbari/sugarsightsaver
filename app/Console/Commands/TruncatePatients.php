<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncatePatients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patients:truncate {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate all patients and related data (appointments, medical records)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Are you sure you want to delete ALL patients and all related data? This cannot be undone!')) {
                $this->info('Operation cancelled.');
                return Command::SUCCESS;
            }
        }

        $this->info('Starting data truncation...');
        $this->newLine();

        try {
            $connection = DB::connection();
            $driverName = $connection->getDriverName();

            DB::beginTransaction();

            // Handle foreign key checks based on database driver
            if ($driverName === 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                $this->info('Foreign key checks disabled (MySQL)');
            }

            // Truncate medical record detail tables first (child tables)
            $this->info('Truncating physician_medical_records...');
            DB::table('physician_medical_records')->truncate();
            $this->info('✓ physician_medical_records truncated');

            $this->info('Truncating ophthalmologist_medical_records...');
            DB::table('ophthalmologist_medical_records')->truncate();
            $this->info('✓ ophthalmologist_medical_records truncated');

            // Truncate patient medical records (depends on appointments and patients)
            $this->info('Truncating patient_medical_records...');
            DB::table('patient_medical_records')->truncate();
            $this->info('✓ patient_medical_records truncated');

            // Truncate appointments (depends on patients)
            $this->info('Truncating patient_appointments...');
            DB::table('patient_appointments')->truncate();
            $this->info('✓ patient_appointments truncated');

            // Truncate patients table
            $this->info('Truncating patients...');
            DB::table('patients')->truncate();
            $this->info('✓ patients truncated');

            // Re-enable foreign key checks (MySQL only)
            if ($driverName === 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');
                $this->info('Foreign key checks re-enabled (MySQL)');
            }

            DB::commit();

            $this->newLine();
            $this->info('✓ All patients and related data have been successfully truncated!');
            $this->newLine();

            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($driverName === 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            }

            $this->error('Error truncating data: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
