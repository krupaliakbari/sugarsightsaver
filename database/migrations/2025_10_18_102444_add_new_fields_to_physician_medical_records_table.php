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
        Schema::table('physician_medical_records', function (Blueprint $table) {
            $table->boolean('hypertension')->default(false);
            $table->boolean('dyslipidemia')->default(false);
            $table->text('retinopathy')->nullable();
            $table->enum('neuropathy', ['peripheral', 'autonomic', 'no'])->nullable();
            $table->enum('nephropathy', ['no', 'microalbuminuria', 'proteinuria', 'ckd', 'on_dialysis'])->nullable();
            $table->enum('cardiovascular', ['no', 'ihd', 'stroke', 'pvd'])->nullable();
            $table->enum('foot_disease', ['no', 'ulcer', 'gangrene', 'deformity'])->nullable();
            $table->json('others')->nullable();
            $table->text('others_details')->nullable();
            $table->enum('hba1c_range', ['less_than_7', '7_to_9', 'greater_than_9'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('physician_medical_records', function (Blueprint $table) {
            $table->dropColumn([
                'hypertension',
                'dyslipidemia', 
                'retinopathy',
                'neuropathy',
                'nephropathy',
                'cardiovascular',
                'foot_disease',
                'others',
                'others_details',
                'hba1c_range'
            ]);
        });
    }
};
