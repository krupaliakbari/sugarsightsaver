<?php

namespace App\Http\Controllers;

use App\Models\PatientAppointment;
use App\Models\PatientMedicalRecord;
use App\Models\OphthalmologistMedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OphthalmologistEntryController extends Controller
{
    /**
     * Show the ophthalmologist entries form
     */
    public function show($appointmentId)
    {
        $appointment = PatientAppointment::with(['patient', 'doctor'])->findOrFail($appointmentId);
        
        // Check if user is authorized to access this appointment
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this appointment.');
        }

        // Get or create patient medical record
        $patientMedicalRecord = PatientMedicalRecord::where('appointment_id', $appointmentId)
            ->where('record_type', 'ophthalmologist')
            ->first();

        if (!$patientMedicalRecord) {
            $patientMedicalRecord = PatientMedicalRecord::create([
                'patient_id' => $appointment->patient_id,
                'appointment_id' => $appointmentId,
                'record_type' => 'ophthalmologist'
            ]);
        }

        // Get existing ophthalmologist record if any
        $ophthalmologistRecord = $patientMedicalRecord->ophthalmologistRecord;

        // ALWAYS fetch previous ophthalmologist record for pre-filling (from most recent previous appointment)
        $previousMedicalRecord = PatientMedicalRecord::where('patient_id', $appointment->patient_id)
            ->where('appointment_id', '!=', $appointmentId)
            ->where('record_type', 'ophthalmologist')
            ->whereHas('ophthalmologistRecord') // Only get records that actually have ophthalmologist data
            ->with('ophthalmologistRecord')
            ->orderBy('id', 'desc') // Use ID to get most recent
            ->first();
        
        $previousOphthalmologistRecord = null;
        if ($previousMedicalRecord && $previousMedicalRecord->ophthalmologistRecord) {
            $previousOphthalmologistRecord = $previousMedicalRecord->ophthalmologistRecord;
        }
        
        \Log::info('Ophthalmologist Previous Record Search', [
            'patient_id' => $appointment->patient_id,
            'current_appointment_id' => $appointmentId,
            'current_has_data' => $ophthalmologistRecord ? 'YES' : 'NO',
            'found_previous_record' => $previousMedicalRecord ? $previousMedicalRecord->id : 'NO',
            'has_previous_data' => $previousOphthalmologistRecord ? 'YES' : 'NO'
        ]);

        $title = 'Ophthalmologist Entries - ' . $appointment->patient->name;

        return view('doctor.medical.ophthalmologist-entries', compact('appointment', 'patientMedicalRecord', 'ophthalmologistRecord', 'previousOphthalmologistRecord', 'title'));
    }

    /**
     * Store ophthalmologist entries
     */
    public function store(Request $request, $appointmentId)
    {
        $appointment = PatientAppointment::findOrFail($appointmentId);
        
        // Check if user is authorized
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this appointment.');
        }

        $validator = \Validator::make($request->all(), [
            'diabetic_retinopathy' => 'boolean',
            'diabetic_macular_edema' => 'boolean',
            'type_of_dr' => 'nullable|in:npdr_mild,npdr_moderate,npdr_severe,npdr_very_severe,pdr_non_high_risk,pdr_high_risk',
            'type_of_dme' => 'nullable|in:nil_absent,present,mild,moderate,severe',
            'investigations' => 'nullable|array',
            'investigations.*' => 'in:fundus_pic,oct,octa,ffa,others',
            'investigations_others' => 'nullable|string|max:255',
            'advised' => 'nullable|in:no_treatment,close_watch,drops,medications,focal_laser,prp_laser,intravit_inj,steroid,surgery',
            'treatment_done_date' => 'nullable|date|before_or_equal:today',
            'review_date' => 'nullable|date|after_or_equal:today',
            'other_remarks' => 'nullable|string|max:1000'
        ]);
        
        // Add conditional validation: investigations_others is required when "others" is in investigations
        $validator->sometimes('investigations_others', 'required|string|max:255', function ($input) use ($request) {
            $investigations = $request->input('investigations', []);
            if (!is_array($investigations)) {
                $investigations = [];
            }
            return in_array('others', $investigations);
        });
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Get or create patient medical record
            $patientMedicalRecord = PatientMedicalRecord::where('appointment_id', $appointmentId)
                ->where('record_type', 'ophthalmologist')
                ->first();

            if (!$patientMedicalRecord) {
                $patientMedicalRecord = PatientMedicalRecord::create([
                    'patient_id' => $appointment->patient_id,
                    'appointment_id' => $appointmentId,
                    'record_type' => 'ophthalmologist'
                ]);
            }

            // Create or update ophthalmologist record
            $ophthalmologistRecord = $patientMedicalRecord->ophthalmologistRecord;
            
            if ($ophthalmologistRecord) {
                $ophthalmologistRecord->update($request->only([
                    'diabetic_retinopathy',
                    'diabetic_macular_edema',
                    'type_of_dr',
                    'type_of_dme',
                    'investigations',
                    'investigations_others',
                    'advised',
                    'treatment_done_date',
                    'review_date',
                    'other_remarks'
                ]));
            } else {
                $ophthalmologistRecord = OphthalmologistMedicalRecord::create([
                    'patient_medical_record_id' => $patientMedicalRecord->id,
                    'diabetic_retinopathy' => $request->boolean('diabetic_retinopathy'),
                    'diabetic_macular_edema' => $request->boolean('diabetic_macular_edema'),
                    'type_of_dr' => $request->type_of_dr,
                    'type_of_dme' => $request->type_of_dme,
                    'investigations' => $request->investigations ?? [],
                    'investigations_others' => $request->investigations_others,
                    'advised' => $request->advised,
                    'treatment_done_date' => $request->treatment_done_date,
                    'review_date' => $request->review_date,
                    'other_remarks' => $request->other_remarks
                ]);
            }

            DB::commit();

            return redirect()->route('doctor.medical.summary', $patientMedicalRecord->id)
                ->with('success', 'Appointment details added successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to save ophthalmologist entry. Please try again.')
                ->withInput();
        }
    }
}
