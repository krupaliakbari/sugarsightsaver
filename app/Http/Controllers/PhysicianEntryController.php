<?php

namespace App\Http\Controllers;

use App\Models\PatientAppointment;
use App\Models\PatientMedicalRecord;
use App\Models\PhysicianMedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PhysicianEntryController extends Controller
{
    /**
     * Show the physician entries form
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
            ->where('record_type', 'physician')
            ->first();

        if (!$patientMedicalRecord) {
            $patientMedicalRecord = PatientMedicalRecord::create([
                'patient_id' => $appointment->patient_id,
                'appointment_id' => $appointmentId,
                'record_type' => 'physician'
            ]);
        }

        // Get existing physician record if any
        $physicianRecord = $patientMedicalRecord->physicianRecord;

        // ALWAYS fetch previous physician record for pre-filling (from most recent previous appointment)
        $previousMedicalRecord = PatientMedicalRecord::where('patient_id', $appointment->patient_id)
            ->where('appointment_id', '!=', $appointmentId)
            ->where('record_type', 'physician')
            ->whereHas('physicianRecord') // Only get records that actually have physician data
            ->with('physicianRecord')
            ->orderBy('id', 'desc') // Use ID to get most recent
            ->first();
        
        $previousPhysicianRecord = null;
        if ($previousMedicalRecord && $previousMedicalRecord->physicianRecord) {
            $previousPhysicianRecord = $previousMedicalRecord->physicianRecord;
        }
        
        \Log::info('Physician Previous Record Search', [
            'patient_id' => $appointment->patient_id,
            'current_appointment_id' => $appointmentId,
            'current_has_data' => $physicianRecord ? 'YES' : 'NO',
            'found_previous_record' => $previousMedicalRecord ? $previousMedicalRecord->id : 'NO',
            'has_previous_data' => $previousPhysicianRecord ? 'YES' : 'NO'
        ]);

        $title = 'Physician Entry - ' . $appointment->patient->name;

        return view('doctor.medical.physician-entries', compact('appointment', 'patientMedicalRecord', 'physicianRecord', 'previousPhysicianRecord', 'title'));
    }

    /**
     * Store physician entries
     */
    public function store(Request $request, $appointmentId)
    {
        $appointment = PatientAppointment::findOrFail($appointmentId);
        
        // Check if user is authorized
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this appointment.');
        }

        $rules = [
            'type_of_diabetes' => 'required|in:type1,type2,other',
            'family_history_diabetes' => 'boolean',
            'current_treatment' => 'array',
            'current_treatment.*' => 'in:lifestyle,oha,insulin,glp1,ayurvedic_homeopathy,others',
            'current_treatment_other' => 'nullable|string|max:500',
            'compliance' => 'required|in:good,irregular,poor',
            'blood_sugar_type' => 'required|in:rbs,fbs,ppbs,hba1c',
            'blood_sugar_value' => 'required|numeric|min:0|max:999.99',
            'other_data' => 'nullable|string|max:1000',
            'hypertension' => 'boolean',
            'dyslipidemia' => 'boolean',
            'retinopathy' => 'nullable|string|max:1000',
            'neuropathy' => 'nullable|in:peripheral,autonomic,no',
            'nephropathy' => 'nullable|in:no,microalbuminuria,proteinuria,ckd,on_dialysis',
            'cardiovascular' => 'nullable|in:no,ihd,stroke,pvd',
            'foot_disease' => 'nullable|in:no,ulcer,gangrene,deformity',
            'others' => 'array',
            'others.*' => 'in:infections,dental_problems,erectile_dysfunction,other',
            'others_details' => 'nullable|string|max:1000',
            'hba1c_range' => 'nullable|in:less_than_7,7_to_9,greater_than_9'
        ];

        $validator = Validator::make($request->all(), $rules, [
            'current_treatment_other.required' => 'Specify Other Treatment is required.',
            'current_treatment_other.string' => 'Specify Other Treatment must be a valid text.',
            'current_treatment_other.max' => 'Specify Other Treatment may not be greater than 500 characters.',
        ]);

        // Add conditional validation for current_treatment_other
        $validator->sometimes('current_treatment_other', 'required|string|max:500', function ($input) use ($request) {
            $currentTreatment = $request->input('current_treatment', []);
            if (!is_array($currentTreatment)) {
                $currentTreatment = [];
            }
            return in_array('others', $currentTreatment);
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
                ->where('record_type', 'physician')
                ->first();

            if (!$patientMedicalRecord) {
                $patientMedicalRecord = PatientMedicalRecord::create([
                    'patient_id' => $appointment->patient_id,
                    'appointment_id' => $appointmentId,
                    'record_type' => 'physician'
                ]);
            }

            // Create or update physician record
            $physicianRecord = $patientMedicalRecord->physicianRecord;
            
            if ($physicianRecord) {
                $updateData = $request->only([
                    'type_of_diabetes',
                    'family_history_diabetes',
                    'current_treatment',
                    'current_treatment_other',
                    'compliance',
                    'blood_sugar_type',
                    'blood_sugar_value',
                    'other_data',
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
                
                // Trim current_treatment_other if present
                if (isset($updateData['current_treatment_other'])) {
                    $updateData['current_treatment_other'] = ($updateData['current_treatment_other']) ? trim($updateData['current_treatment_other']) : null;
                }
                
                $physicianRecord->update($updateData);
            } else {
                $physicianRecord = PhysicianMedicalRecord::create([
                    'patient_medical_record_id' => $patientMedicalRecord->id,
                    'type_of_diabetes' => $request->type_of_diabetes,
                    'family_history_diabetes' => $request->boolean('family_history_diabetes'),
                    'current_treatment' => $request->current_treatment ?? [],
                    'current_treatment_other' => ($request->current_treatment_other) ? trim($request->current_treatment_other) : null,
                    'compliance' => $request->compliance,
                    'blood_sugar_type' => $request->blood_sugar_type,
                    'blood_sugar_value' => $request->blood_sugar_value,
                    'other_data' => $request->other_data,
                    'hypertension' => $request->boolean('hypertension'),
                    'dyslipidemia' => $request->boolean('dyslipidemia'),
                    'retinopathy' => $request->retinopathy,
                    'neuropathy' => $request->neuropathy,
                    'nephropathy' => $request->nephropathy,
                    'cardiovascular' => $request->cardiovascular,
                    'foot_disease' => $request->foot_disease,
                    'others' => $request->others ?? [],
                    'others_details' => $request->others_details,
                    'hba1c_range' => $request->hba1c_range
                ]);
            }

            DB::commit();

            return redirect()->route('doctor.medical.summary', $patientMedicalRecord->id)
                ->with('success', 'Appointment details added successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to save physician entry. Please try again.')
                ->withInput();
        }
    }
}
