<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add patient basic details to appointments table to maintain historical record
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_appointments', function (Blueprint $table) {
            // Store snapshot of patient details at time of appointment
            $table->string('patient_name')->nullable()->after('appointment_type');
            $table->date('patient_diabetes_from')->nullable()->after('patient_name');
            $table->date('patient_date_of_birth')->nullable()->after('patient_diabetes_from');
            $table->integer('patient_age')->nullable()->after('patient_date_of_birth');
            $table->text('patient_short_address')->nullable()->after('patient_age');
            $table->enum('patient_sex', ['male', 'female', 'other'])->nullable()->after('patient_short_address');
            $table->string('patient_hospital_id')->nullable()->after('patient_sex');
            $table->boolean('patient_on_treatment')->default(false)->after('patient_hospital_id');
            $table->json('patient_type_of_treatment')->nullable()->after('patient_on_treatment');
            $table->boolean('patient_bp')->default(false)->after('patient_type_of_treatment');
            $table->date('patient_bp_since')->nullable()->after('patient_bp');
            $table->json('patient_other_diseases')->nullable()->after('patient_bp_since');
            $table->text('patient_other_input')->nullable()->after('patient_other_diseases');
            $table->decimal('patient_height', 5, 2)->nullable()->after('patient_other_input');
            $table->decimal('patient_weight', 5, 2)->nullable()->after('patient_height');
            $table->decimal('patient_bmi', 5, 2)->nullable()->after('patient_weight');
            $table->string('patient_email')->nullable()->after('patient_bmi');
            $table->string('patient_mobile_number')->nullable()->after('patient_email');
            $table->string('patient_sssp_id')->nullable()->after('patient_mobile_number');
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
            $table->dropColumn([
                'patient_name',
                'patient_diabetes_from',
                'patient_date_of_birth',
                'patient_age',
                'patient_short_address',
                'patient_sex',
                'patient_hospital_id',
                'patient_on_treatment',
                'patient_type_of_treatment',
                'patient_bp',
                'patient_bp_since',
                'patient_other_diseases',
                'patient_other_input',
                'patient_height',
                'patient_weight',
                'patient_bmi',
                'patient_email',
                'patient_mobile_number',
                'patient_sssp_id'
            ]);
        });
    }
};
