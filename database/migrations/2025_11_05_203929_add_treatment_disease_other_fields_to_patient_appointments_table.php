<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_appointments', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('patient_appointments', 'patient_type_of_treatment_other_snapshot')) {
                $table->dropColumn('patient_type_of_treatment_other_snapshot');
            }
            if (Schema::hasColumn('patient_appointments', 'patient_other_diseases_other_snapshot')) {
                $table->dropColumn('patient_other_diseases_other_snapshot');
            }
            
            // Add new columns with simpler names
            if (!Schema::hasColumn('patient_appointments', 'patient_treatment_other')) {
                $table->string('patient_treatment_other')->nullable()->after('patient_type_of_treatment');
            }
            if (!Schema::hasColumn('patient_appointments', 'patient_disease_other')) {
                $table->string('patient_disease_other')->nullable()->after('patient_other_diseases');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_appointments', function (Blueprint $table) {
            // Drop new columns
            if (Schema::hasColumn('patient_appointments', 'patient_treatment_other')) {
                $table->dropColumn('patient_treatment_other');
            }
            if (Schema::hasColumn('patient_appointments', 'patient_disease_other')) {
                $table->dropColumn('patient_disease_other');
            }
            
            // Restore old columns
            if (!Schema::hasColumn('patient_appointments', 'patient_type_of_treatment_other_snapshot')) {
                $table->string('patient_type_of_treatment_other_snapshot')->nullable()->after('patient_type_of_treatment');
            }
            if (!Schema::hasColumn('patient_appointments', 'patient_other_diseases_other_snapshot')) {
                $table->string('patient_other_diseases_other_snapshot')->nullable()->after('patient_other_diseases');
            }
        });
    }
};
