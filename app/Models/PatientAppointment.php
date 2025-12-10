<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PatientAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_date_time',
        'appointment_type',
        // Patient snapshot fields
        'patient_name',
        'patient_diabetes_from',
        'patient_date_of_birth',
        'patient_age',
        'patient_short_address',
        'patient_sex',
        'patient_hospital_id',
        'patient_on_treatment',
        'patient_type_of_treatment',
        'patient_treatment_other',
        'patient_bp',
        'patient_bp_since',
        'patient_other_diseases',
        'patient_disease_other',
        'patient_other_input',
        'patient_height',
        'patient_weight',
        'patient_bmi',
        'patient_email',
        'patient_mobile_number',
        'patient_sssp_id',
        'patient_height_unit'
    ];

    protected $casts = [
        'visit_date_time' => 'datetime',
        'patient_diabetes_from' => 'date',
        'patient_date_of_birth' => 'date',
        'patient_bp_since' => 'date',
        'patient_on_treatment' => 'boolean',
        'patient_bp' => 'boolean',
        'patient_type_of_treatment' => 'array',
        'patient_other_diseases' => 'array',
        'patient_height' => 'decimal:2',
        'patient_weight' => 'decimal:2',
        'patient_bmi' => 'decimal:2',
    ];

    /**
     * Get the patient for this appointment
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor for this appointment
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get medical records for this appointment
     */
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(PatientMedicalRecord::class, 'appointment_id');
    }

    /**
     * Get formatted appointment type for display
     */
    public function getFormattedAppointmentTypeAttribute(): string
    {
        return match($this->appointment_type) {
            'follow_up' => 'Follow up',
            'new' => 'New Visit',
            default => ucfirst($this->appointment_type)
        };
    }

    /**
     * Helper methods to get patient details from appointment snapshot only
     * All data is retrieved from the appointment's snapshot fields, not from the patient model
     */
    
    public function getPatientNameSnapshotAttribute()
    {
        return $this->patient_name;
    }

    public function getPatientEmailSnapshotAttribute()
    {
        return $this->patient_email;
    }

    public function getPatientMobileNumberSnapshotAttribute()
    {
        return $this->patient_mobile_number;
    }

    public function getPatientSsspIdSnapshotAttribute()
    {
        return $this->attributes['patient_sssp_id'] ?? null;
    }

    public function getPatientAgeSnapshotAttribute()
    {
        return $this->patient_age;
    }

    public function getPatientSexSnapshotAttribute()
    {
        return $this->patient_sex;
    }

    public function getPatientHeightSnapshotAttribute()
    {
        return $this->patient_height;
    }

    public function getPatientWeightSnapshotAttribute()
    {
        return $this->patient_weight;
    }

    public function getPatientBmiSnapshotAttribute()
    {
        return $this->patient_bmi;
    }

    public function getPatientDiabetesFromSnapshotAttribute()
    {
        return $this->patient_diabetes_from;
    }

    public function getPatientDateOfBirthSnapshotAttribute()
    {
        return $this->patient_date_of_birth;
    }

    public function getPatientShortAddressSnapshotAttribute()
    {
        return $this->patient_short_address;
    }

    public function getPatientHospitalIdSnapshotAttribute()
    {
        return $this->patient_hospital_id;
    }

    public function getPatientOnTreatmentSnapshotAttribute()
    {
        return $this->patient_on_treatment;
    }

    public function getPatientTypeOfTreatmentSnapshotAttribute()
    {
        return $this->patient_type_of_treatment;
    }

    public function getPatientBpSnapshotAttribute()
    {
        return $this->patient_bp;
    }

    public function getPatientBpSinceSnapshotAttribute()
    {
        return $this->patient_bp_since;
    }

    public function getPatientOtherDiseasesSnapshotAttribute()
    {
        return $this->patient_other_diseases;
    }

    public function getPatientOtherInputSnapshotAttribute()
    {
        return $this->patient_other_input;
    }

    public function getPatientTypeOfTreatmentOtherSnapshotAttribute()
    {
        return $this->attributes['patient_treatment_other'] ?? null;
    }

    public function getPatientOtherDiseasesOtherSnapshotAttribute()
    {
        return $this->attributes['patient_disease_other'] ?? null;
    }
}
