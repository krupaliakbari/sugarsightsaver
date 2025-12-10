<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PatientAppointment;
use App\Models\PatientMedicalRecord;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile_number',
        'name',
        'diabetes_from',
        'date_of_birth',
        'age',
        'short_address',
        'sex',
        'sssp_id',
        'hospital_id',
        'on_treatment',
        'type_of_treatment',
        'type_of_treatment_other',
        'bp',
        'bp_since',
        'other_diseases',
        'other_diseases_other',
        'other_input',
        'height',
        'weight',
        'bmi',
        'email',
        'created_by_doctor_id',
        'height_unit'
    ];

    protected $casts = [
        'diabetes_from' => 'date',
        'date_of_birth' => 'date',
        'bp_since' => 'date',
        'on_treatment' => 'boolean',
        'bp' => 'boolean',
        'type_of_treatment' => 'array',
        'other_diseases' => 'array',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'bmi' => 'decimal:2',
    ];

    /**
     * Get the doctor who created this patient
     */
    public function createdByDoctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_doctor_id');
    }

    /**
     * Get all appointments for this patient
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(PatientAppointment::class);
    }

    /**
     * Get all medical records for this patient
     */
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(PatientMedicalRecord::class);
    }

    /**
     * Get the latest appointment for this patient
     */
    public function latestAppointment()
    {
        return $this->appointments()->latest('visit_date_time')->first();
    }

    /**
     * Generate SSSP ID
     */
    public static function generateSSSPId(): string
    {
        $prefix = 'SSSP';
        $lastPatient = self::where('sssp_id', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        
        if ($lastPatient) {
            $lastNumber = (int) str_replace($prefix, '', $lastPatient->sssp_id);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Calculate BMI
     */
    // public function calculateBMI(): ?float
    // {
        
    //     if ($this->height && $this->weight) {
    //         return round($this->weight / ($this->height * $this->height), 2);
    //     }
    //     return null;
    // }

    // /**
    //  * Auto-calculate BMI when height or weight changes
    //  */
    // protected static function boot()
    // {
    //     parent::boot();
        
    //     static::saving(function ($patient) {
    //         if ($patient->height && $patient->weight) {
    //             $patient->bmi = $patient->calculateBMI();
    //         }
    //     });
    // }


// app/Models/Patient.php

protected static function boot()
{
    parent::boot();

    static::deleting(function ($patient) {
        // Delete all appointments
        $patient->appointments()->delete();

        // Delete all medical records + linked physician/ophthalmologist records
        foreach ($patient->medicalRecords as $medicalRecord) {
            if ($medicalRecord->record_type === 'physician') {
                $medicalRecord->physicianRecord?->delete();
            }
            if ($medicalRecord->record_type === 'ophthalmologist') {
                $medicalRecord->ophthalmologistRecord?->delete();
            }
            $medicalRecord->delete();
        }
    });
}


}
