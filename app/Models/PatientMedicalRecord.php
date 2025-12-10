<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientMedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'record_type'
    ];

    /**
     * Get the patient for this medical record
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the appointment for this medical record
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(PatientAppointment::class, 'appointment_id');
    }

    /**
     * Get the physician medical record for this record
     */
    public function physicianRecord()
    {
        return $this->hasOne(PhysicianMedicalRecord::class);
    }

    /**
     * Get the ophthalmologist medical record for this record
     */
    public function ophthalmologistRecord()
    {
        return $this->hasOne(OphthalmologistMedicalRecord::class);
    }
}
