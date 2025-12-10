<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicianMedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_medical_record_id',
        'type_of_diabetes',
        'family_history_diabetes',
        'current_treatment',
        'current_treatment_other',
        'compliance',
        'other_data',
        'blood_sugar_type',
        'blood_sugar_value',
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
    ];

    protected $casts = [
        'family_history_diabetes' => 'boolean',
        'current_treatment' => 'array',
        'blood_sugar_value' => 'decimal:2',
        'hypertension' => 'boolean',
        'dyslipidemia' => 'boolean',
        'others' => 'array'
    ];

    // Relationships
    public function patientMedicalRecord()
    {
        return $this->belongsTo(PatientMedicalRecord::class);
    }

    // Accessor for formatted diabetes type
    public function getFormattedDiabetesTypeAttribute()
    {
        return match($this->type_of_diabetes) {
            'type1' => 'Type 1',
            'type2' => 'Type 2',
            'other' => 'Other',
            default => 'Not specified'
        };
    }

    // Accessor for formatted compliance
    public function getFormattedComplianceAttribute()
    {
        return match($this->compliance) {
            'good' => 'Good',
            'irregular' => 'Irregular',
            'poor' => 'Poor',
            default => 'Not specified'
        };
    }

    // Accessor for formatted blood sugar type
    public function getFormattedBloodSugarTypeAttribute()
    {
        return match($this->blood_sugar_type) {
            'rbs' => 'RBS',
            'fbs' => 'FBS',
            'ppbs' => 'PPBS',
            'hba1c' => 'HBA1C',
            default => 'Not specified'
        };
    }

    // Accessor for formatted neuropathy
    public function getFormattedNeuropathyAttribute()
    {
        return match($this->neuropathy) {
            'peripheral' => 'Peripheral',
            'autonomic' => 'Autonomic',
            'no' => 'No',
            default => 'Not specified'
        };
    }

    // Accessor for formatted nephropathy
    public function getFormattedNephropathyAttribute()
    {
        return match($this->nephropathy) {
            'no' => 'No',
            'microalbuminuria' => 'Microalbuminuria',
            'proteinuria' => 'Proteinuria',
            'ckd' => 'CKD',
            'on_dialysis' => 'On Dialysis',
            default => 'Not specified'
        };
    }

    // Accessor for formatted retinopathy
    public function getFormattedRetinopathyAttribute()
    {
        return match($this->retinopathy) {
            'yes' => 'Yes',
            'no' => 'No',
            'to_be_checked' => 'To be checked',
            default => $this->retinopathy ?: 'Not specified'
        };
    }

    // Accessor for formatted cardiovascular
    public function getFormattedCardiovascularAttribute()
    {
        return match($this->cardiovascular) {
            'no' => 'No',
            'ihd' => 'IHD',
            'stroke' => 'Stroke',
            'pvd' => 'PVD',
            default => 'Not specified'
        };
    }

    // Accessor for formatted foot disease
    public function getFormattedFootDiseaseAttribute()
    {
        return match($this->foot_disease) {
            'no' => 'No',
            'ulcer' => 'Ulcer',
            'gangrene' => 'Gangrene',
            'deformity' => 'Deformity',
            default => 'Not specified'
        };
    }

    // Accessor for formatted HBA1C range
    public function getFormattedHba1cRangeAttribute()
    {
        return match($this->hba1c_range) {
            'less_than_7' => '< 7',
            '7_to_9' => '7 to 9',
            'greater_than_9' => '> 9',
            default => 'Not specified'
        };
    }

    // Accessor for formatted others
    public function getFormattedOthersAttribute()
    {
        if (!$this->others || empty($this->others)) {
            return 'None';
        }

        $formatted = [];
        foreach ($this->others as $other) {
            $formatted[] = match($other) {
                'infections' => 'Infections',
                'dental_problems' => 'Dental Problems',
                'erectile_dysfunction' => 'Erectile Dysfunction',
                'other' => 'Other',
                default => ucfirst(str_replace('_', ' ', $other))
            };
        }

        return implode(', ', $formatted);
    }

    // Accessor for formatted current treatment
    public function getFormattedCurrentTreatmentAttribute()
    {
        if (!$this->current_treatment || empty($this->current_treatment)) {
            return 'Not specified';
        }

        $formatted = array_map(function($value) {
            $value = str_replace('_', ' ', $value);
            return match($value) {
                'lifestyle' => 'Lifestyle',
                'oha' => 'OHA',
                'insulin' => 'Insulin',
                'glp1' => 'GLP1',
                'ayurvedic homeopathy' => 'Ayurvedic/Homeopathy',
                'others' => 'Others',
                default => ucfirst($value)
            };
        }, $this->current_treatment);

        // Replace "Others" with the actual value if current_treatment_other exists
        $finalFormatted = [];
        foreach ($formatted as $index => $item) {
            if ($item === 'Others' && $this->current_treatment[$index] === 'others' && !empty($this->current_treatment_other)) {
                $finalFormatted[] = $this->current_treatment_other;
            } else {
                $finalFormatted[] = $item;
            }
        }

        return implode(', ', $finalFormatted);
    }
}
