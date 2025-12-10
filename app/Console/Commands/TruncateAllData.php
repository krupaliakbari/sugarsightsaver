<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class TruncateAllData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:truncate-all {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate all doctors, patients and all related data (appointments, medical records)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Are you sure you want to delete ALL doctors, patients and all related data? This cannot be undone!')) {
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

            // Delete doctors from users table (but keep admin users)
            $this->info('Deleting doctors from users table...');
            $doctorsDeleted = User::where('user_type', 'doctor')->delete();
            $this->info("✓ {$doctorsDeleted} doctors deleted from users table");

            // Delete doctor role assignments from model_has_roles
            $this->info('Cleaning up doctor role assignments...');
            $roleAssignmentsDeleted = DB::table('model_has_roles')
                ->where('model_type', 'App\Models\User')
                ->whereIn('role_id', function($query) {
                    $query->select('id')
                        ->from('roles')
                        ->where('name', 'doctor');
                })
                ->delete();
            $this->info("✓ {$roleAssignmentsDeleted} doctor role assignments removed");

            // Re-enable foreign key checks (MySQL only)
            if ($driverName === 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');
                $this->info('Foreign key checks re-enabled (MySQL)');

                // Reset AUTO_INCREMENT counters (MySQL only)
                $this->info('Resetting AUTO_INCREMENT counters...');
                DB::statement('ALTER TABLE `physician_medical_records` AUTO_INCREMENT = 1');
                DB::statement('ALTER TABLE `ophthalmologist_medical_records` AUTO_INCREMENT = 1');
                DB::statement('ALTER TABLE `patient_medical_records` AUTO_INCREMENT = 1');
                DB::statement('ALTER TABLE `patient_appointments` AUTO_INCREMENT = 1');
                DB::statement('ALTER TABLE `patients` AUTO_INCREMENT = 1');
                $this->info('✓ AUTO_INCREMENT counters reset');
            }

            DB::commit();

            $this->newLine();
            $this->info('✓ All doctors, patients and related data have been successfully truncated!');
            $this->newLine();

            // Verify truncation
            $this->info('Verification:');
            $this->info('  - Patients: ' . DB::table('patients')->count());
            $this->info('  - Appointments: ' . DB::table('patient_appointments')->count());
            $this->info('  - Medical Records: ' . DB::table('patient_medical_records')->count());
            $this->info('  - Physician Records: ' . DB::table('physician_medical_records')->count());
            $this->info('  - Ophthalmologist Records: ' . DB::table('ophthalmologist_medical_records')->count());
            $this->info('  - Doctors: ' . User::where('user_type', 'doctor')->count());
            $this->newLine();

            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($driverName === 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            }

            $this->error('Error truncating data: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}

