<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OphthalmologistMedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_medical_record_id',
        'diabetic_retinopathy',
        'diabetic_macular_edema',
        'type_of_dr',
        'type_of_dme',
        'investigations',
        'investigations_others',
        'advised',
        'treatment_done_date',
        'review_date',
        'other_remarks',
        'diabetic_retinopathy_re',
    'diabetic_macular_edema_re',
    'type_of_dr_re',
    'type_of_dme_re',
    'advised_re',


    // ---- Visual and Eye Examination ----
    'ucva_re',
    'ucva_le',
    'bcva_re',
    'bcva_le',
    'anterior_segment_re',
    'anterior_segment_le',
    'iop_re',
    'iop_le',
    ];

    protected $casts = [
        'diabetic_retinopathy' => 'boolean',
        'diabetic_macular_edema' => 'boolean',
        'investigations' => 'array',
        'treatment_done_date' => 'date',
        'review_date' => 'date'
    ];

    // Relationships
    public function patientMedicalRecord()
    {
        return $this->belongsTo(PatientMedicalRecord::class);
    }

    // Accessor for formatted DR type
    public function getFormattedDrTypeAttribute()
    {
        return match($this->type_of_dr) {
            'npdr_mild' => 'NPDR - Mild',
            'npdr_moderate' => 'NPDR - Moderate',
            'npdr_severe' => 'NPDR - Severe',
            'npdr_very_severe' => 'NPDR - Very Severe',
            'pdr_non_high_risk' => 'PDR - Non-High Risk',
            'pdr_high_risk' => 'PDR - High Risk',
            default => 'Not specified'
        };
    }

    public function getFormattedDrTypeReAttribute()
    {
        return match($this->type_of_dr_re) {
            'npdr_mild' => 'NPDR - Mild',
            'npdr_moderate' => 'NPDR - Moderate',
            'npdr_severe' => 'NPDR - Severe',
            'npdr_very_severe' => 'NPDR - Very Severe',
            'pdr_non_high_risk' => 'PDR - Non-High Risk',
            'pdr_high_risk' => 'PDR - High Risk',
            default => 'Not specified'
        };
    }
    // Accessor for formatted DME type
    public function getFormattedDmeTypeAttribute()
    {
        return match($this->type_of_dme) {
            'nil_absent' => 'Nil/Absent',
            'present' => 'Present',
            'mild' => 'Present - Mild',
            'moderate' => 'Present - Moderate',
            'severe' => 'Present - Severe (Based On Inv Of Fovea)',
            default => 'Not specified'
        };
    }
     public function getFormattedDmeTypeReAttribute()
    {
        return match($this->type_of_dme_re) {
            'nil_absent' => 'Nil/Absent',
            'present' => 'Present',
            'mild' => 'Present - Mild',
            'moderate' => 'Present - Moderate',
            'severe' => 'Present - Severe (Based On Inv Of Fovea)',
            default => 'Not specified'
        };
    }

    // Accessor for formatted advised treatment
    public function getFormattedAdvisedAttribute()
    {
        return match($this->advised) {
            'no_treatment' => 'No treatment',
            'close_watch' => 'Close watch',
            'drops' => 'Any other drops',
            'medications' => 'Medications',
            'focal_laser' => 'Focal laser',
            'prp_laser' => 'PRP laser',
            'intravit_inj' => 'Intravit inj antivefg',
            'steroid' => 'Steroid',
            'surgery' => 'Surgery',
            default => 'Not specified'
        };
    }
      public function getFormattedAdvisedReAttribute()
    {
        return match($this->advised_re) {
            'no_treatment' => 'No treatment',
            'close_watch' => 'Close watch',
            'drops' => 'Any other drops',
            'medications' => 'Medications',
            'focal_laser' => 'Focal laser',
            'prp_laser' => 'PRP laser',
            'intravit_inj' => 'Intravit inj antivefg',
            'steroid' => 'Steroid',
            'surgery' => 'Surgery',
            default => 'Not specified'
        };
    }

    // Accessor for formatted investigations
    public function getFormattedInvestigationsAttribute()
    {
        $investigationsList = [];

        if ($this->investigations && !empty($this->investigations)) {
            $formatted = array_map(function($value) {
                return match($value) {
                    'fundus_pic' => 'Fundus pic',
                    'oct' => 'Oct',
                    'octa' => 'Octa',
                    'ffa' => 'Ffa',
                    'others' => 'Others',
                    default => ucfirst(str_replace('_', ' ', $value))
                };
            }, $this->investigations);

            $investigationsList = $formatted;

            // If "others" is selected and investigations_others exists, replace "Others" with the actual value
            if (in_array('others', $this->investigations) && $this->investigations_others) {
                $othersIndex = array_search('Others', $investigationsList);
                if ($othersIndex !== false) {
                    $investigationsList[$othersIndex] = 'Others: ' . $this->investigations_others;
                }
            }
        } elseif ($this->investigations_others) {
            // If only investigations_others exists without "others" in investigations array
            $investigationsList[] = $this->investigations_others;
        }

        if (empty($investigationsList)) {
            return 'Not specified';
        }

        return implode(', ', $investigationsList);
    }
}
