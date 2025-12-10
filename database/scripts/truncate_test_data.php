<?php
/**
 * Truncate all patient and appointment data for testing
 * 
 * WARNING: This will delete ALL patient, appointment, and medical record data
 * Use only for testing purposes
 * 
 * Usage: php artisan tinker
 * Then run: require database/scripts/truncate_test_data.php;
 */

use Illuminate\Support\Facades\DB;

echo "Starting data truncation...\n\n";

try {
    $connection = DB::connection();
    $driverName = $connection->getDriverName();

    DB::beginTransaction();

    // Handle foreign key checks based on database driver
    if ($driverName === 'mysql') {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    }

    // Truncate medical record detail tables first (child tables)
    echo "Truncating physician_medical_records...\n";
    DB::table('physician_medical_records')->truncate();

    echo "Truncating ophthalmologist_medical_records...\n";
    DB::table('ophthalmologist_medical_records')->truncate();

    // Truncate patient medical records (depends on appointments and patients)
    echo "Truncating patient_medical_records...\n";
    DB::table('patient_medical_records')->truncate();

    // Truncate appointments (depends on patients)
    echo "Truncating patient_appointments...\n";
    DB::table('patient_appointments')->truncate();

    // Truncate patients table
    echo "Truncating patients...\n";
    DB::table('patients')->truncate();

    // Re-enable foreign key checks (MySQL only)
    if ($driverName === 'mysql') {
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        // Reset AUTO_INCREMENT counters (MySQL only)
        echo "\nResetting AUTO_INCREMENT counters...\n";
        DB::statement('ALTER TABLE `physician_medical_records` AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE `ophthalmologist_medical_records` AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE `patient_medical_records` AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE `patient_appointments` AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE `patients` AUTO_INCREMENT = 1');
    }

    DB::commit();

    echo "\n✓ All patient and appointment data has been truncated successfully!\n";
    echo "✓ AUTO_INCREMENT counters have been reset.\n";
    echo "\nYou can now start fresh testing.\n";

    // Verify truncation
    echo "\nVerification:\n";
    echo "  - Patients: " . DB::table('patients')->count() . "\n";
    echo "  - Appointments: " . DB::table('patient_appointments')->count() . "\n";
    echo "  - Medical Records: " . DB::table('patient_medical_records')->count() . "\n";
    echo "  - Physician Records: " . DB::table('physician_medical_records')->count() . "\n";
    echo "  - Ophthalmologist Records: " . DB::table('ophthalmologist_medical_records')->count() . "\n";

} catch (\Exception $e) {
    DB::rollBack();
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    throw $e;
}

