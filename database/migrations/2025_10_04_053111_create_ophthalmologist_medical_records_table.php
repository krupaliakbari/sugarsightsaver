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
        Schema::create('ophthalmologist_medical_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_medical_record_id');
            $table->boolean('diabetic_retinopathy')->default(false);
            $table->boolean('diabetic_macular_edema')->default(false);
            $table->enum('type_of_dr', [
                'npdr_mild', 'npdr_moderate', 'npdr_severe', 'npdr_very_severe',
                'pdr_non_high_risk', 'pdr_high_risk'
            ])->nullable();
            $table->enum('type_of_dme', ['nil_absent', 'present', 'mild', 'moderate', 'severe'])->nullable();
            $table->json('investigations')->nullable(); // fundus_pic, oct, octa, ffa, others
            $table->enum('advised', [
                'no_treatment', 'close_watch', 'drops', 'medications', 
                'focal_laser', 'prp_laser', 'intravit_inj', 'steroid', 'surgery'
            ])->nullable();
            $table->date('treatment_done_date')->nullable();
            $table->date('review_date')->nullable();
            $table->text('other_remarks')->nullable();
            $table->timestamps();
            
            $table->foreign('patient_medical_record_id', 'ophthalmologist_patient_medical_record_id_foreign')
                  ->references('id')->on('patient_medical_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ophthalmologist_medical_records');
    }
};
