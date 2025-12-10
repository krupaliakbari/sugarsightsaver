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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email',255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone',80)->nullable();
            $table->string('password');
            $table->text('profile_image')->nullable();
            $table->enum('status',['active','deactive','pending'])->default('active');
            $table->string('user_type')->default('admin'); // admin, doctor, patient
            $table->string('hospital_name')->nullable();
            $table->text('address')->nullable();
            $table->enum('doctor_type',['diabetes_treating','ophthalmologist'])->nullable();
            $table->text('qualification')->nullable();
            $table->enum('approval_status',['pending','approved','rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
