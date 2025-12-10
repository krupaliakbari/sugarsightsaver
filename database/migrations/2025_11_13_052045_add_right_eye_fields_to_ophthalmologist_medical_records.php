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
        Schema::table('ophthalmologist_medical_records', function (Blueprint $table) {

             $table->string('ucva_re')->nullable()->after('review_date');
            $table->string('ucva_le')->nullable()->after('ucva_re');

            $table->string('bcva_re')->nullable()->after('ucva_le');
            $table->string('bcva_le')->nullable()->after('bcva_re');

            $table->string('anterior_segment_re')->nullable()->after('bcva_le');
            $table->string('anterior_segment_le')->nullable()->after('anterior_segment_re');

            $table->string('iop_re')->nullable()->after('anterior_segment_le');
            $table->string('iop_le')->nullable()->after('iop_re');


            $table->boolean('diabetic_retinopathy_re')->default(false)->after('diabetic_macular_edema');
            $table->boolean('diabetic_macular_edema_re')->default(false)->after('diabetic_retinopathy_re');

            $table->enum('type_of_dr_re', [
                'npdr_mild', 'npdr_moderate', 'npdr_severe', 'npdr_very_severe',
                'pdr_non_high_risk', 'pdr_high_risk'
            ])->nullable()->after('type_of_dr');

            $table->enum('type_of_dme_re', ['nil_absent', 'present', 'mild', 'moderate', 'severe'])
                  ->nullable()->after('type_of_dme');

            $table->enum('advised_re', [
                'no_treatment', 'close_watch', 'drops', 'medications',
                'focal_laser', 'prp_laser', 'intravit_inj', 'steroid', 'surgery'
            ])->nullable()->after('advised');

            $table->date('treatment_done_date_re')->nullable()->after('treatment_done_date');
            $table->date('review_date_re')->nullable()->after('review_date');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ophthalmologist_medical_records', function (Blueprint $table) {
            $table->dropColumn([
                'diabetic_retinopathy_re',
                'diabetic_macular_edema_re',
                'type_of_dr_re',
                'type_of_dme_re',
                'advised_re',
                'treatment_done_date_re',
                'review_date_re',
                 'ucva_re', 'ucva_le',
                'bcva_re', 'bcva_le',
                'anterior_segment_re', 'anterior_segment_le',
                'iop_re', 'iop_le',
            ]);
        });
    }
};
