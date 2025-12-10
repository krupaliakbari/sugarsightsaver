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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_number')->index();
            $table->string('name');
            $table->date('diabetes_from')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('age')->nullable();
            $table->text('short_address')->nullable();
            $table->enum('sex', ['male', 'female', 'other'])->nullable();
            $table->string('sssp_id')->unique();
            $table->string('hospital_id')->nullable();
            $table->boolean('on_treatment')->default(false);
            $table->json('type_of_treatment')->nullable(); // Allopathic, Diet Control, Ayurvedic, Others
            $table->boolean('bp')->default(false);
            $table->date('bp_since')->nullable();
            $table->json('other_diseases')->nullable(); // Heart disease, Cholesterol, Thyroid, Stroke, Others
            $table->text('other_input')->nullable();
            $table->decimal('height', 5, 2)->nullable(); // In meters
            $table->decimal('weight', 5, 2)->nullable(); // In Kg
            $table->decimal('bmi', 5, 2)->nullable();
            $table->string('email')->nullable();
            $table->foreignId('created_by_doctor_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
