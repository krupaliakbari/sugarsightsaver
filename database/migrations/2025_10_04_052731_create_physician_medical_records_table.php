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
        Schema::create('physician_medical_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_medical_record_id');
            $table->enum('type_of_diabetes', ['type1', 'type2', 'other'])->nullable();
            $table->boolean('family_history_diabetes')->default(false);
            $table->json('current_treatment')->nullable(); // lifestyle, oha, insulin, glp1
            $table->enum('compliance', ['good', 'irregular', 'poor'])->nullable();
            $table->text('other_data')->nullable();
            $table->enum('blood_sugar_type', ['rbs', 'fbs', 'ppbs', 'hba1c'])->nullable();
            $table->decimal('blood_sugar_value', 8, 2)->nullable();
            $table->timestamps();
            
            $table->foreign('patient_medical_record_id', 'physician_patient_medical_record_id_foreign')
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
        Schema::dropIfExists('physician_medical_records');
    }
};
