<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'profile_image',
        'status',
        'user_type',
        'hospital_name',
        'address',
        'doctor_type',
        'qualification',
        'medical_council_registration_number',
        'state',
        'approval_status',
        'rejection_reason'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if user is a doctor
     */
    public function isDoctor()
    {
        return $this->user_type === 'doctor';
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    /**
     * Check if user is a patient
     */
    public function isPatient()
    {
        return $this->user_type === 'patient';
    }

    /**
     * Check if doctor is approved
     */
    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    /**
     * Check if doctor is pending approval
     */
    public function isPending()
    {
        return $this->approval_status === 'pending';
    }

    /**
     * Get doctor type display name
     */
    public function getDoctorTypeDisplayAttribute()
    {
        return match($this->doctor_type) {
            'diabetes_treating' => 'Diabetes-Treating Physician',
            'ophthalmologist' => 'Ophthalmologist',
            default => 'Unknown'
        };
    }



protected static function boot()
{
    parent::boot();

    static::deleting(function ($doctor) {
        if ($doctor->user_type !== 'doctor') {
            return;
        }

        // Get all patients created by this doctor
        $patients = Patient::where('created_by_doctor_id', $doctor->id)->get();

        foreach ($patients as $patient) {

            // 1. Delete all appointments for this patient
            PatientAppointment::where('patient_id', $patient->id)->delete();

            // 2. Delete all medical records and their related physician/ophthalmologist records
            $medicalRecords = PatientMedicalRecord::where('patient_id', $patient->id)->get();

            foreach ($medicalRecords as $record) {

                // Delete linked physician record
                if ($record->record_type === 'physician') {
                    PhysicianMedicalRecord::where('patient_medical_record_id', $record->id)->delete();
                }

                // Delete linked ophthalmologist record
                if ($record->record_type === 'ophthalmologist') {
                    OphthalmologistMedicalRecord::where('patient_medical_record_id', $record->id)->delete();
                }

                // Delete the main medical record
                $record->delete();
            }

            // Finally delete the patient itself
            $patient->delete();
        }
    });
}

}