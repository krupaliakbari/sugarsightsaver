<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientAppointment;
use App\Models\PatientMedicalRecord;
use App\Models\User;
use App\Services\ReminderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    /**
     * Generate mobile number with A/B/C suffix for same mobile number globally (shared across all doctors)
     */
    private function generateMobileNumberWithSuffix($baseMobileNumber, $doctorId)
    {
        // Check how many patients exist globally with this base mobile number
        $existingPatients = Patient::where('mobile_number', 'like', $baseMobileNumber . '%')
            ->get();

        $count = $existingPatients->count();

        if ($count == 0) {
            // First patient with this mobile number
            return $baseMobileNumber;
        } elseif ($count == 1) {
            // Second patient - add _A suffix
            return $baseMobileNumber . '_A';
        } elseif ($count == 2) {
            // Third patient - add _B suffix
            return $baseMobileNumber . '_B';
        } else {
            // Fourth patient - add _C suffix (max 4 patients per mobile number)
            return $baseMobileNumber . '_C';
        }
    }
    /**
     * Show Add Patient Appointment page
     */
    public function showAddPatientAppointment()
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        return view('doctor.patients.add-appointment', [
            'title' => 'Add Appointment',
            'breadcrumb' => 'Add Appointment'
        ]);
    }

    /**
     * Search patient by mobile number - Shows all patients across all doctors
     */
    public function searchPatient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|min:10|max:10|regex:/^\d{10}$/'
        ], [
            'mobile_number.required' => 'Mobile number is required.',
            'mobile_number.min' => 'Mobile number must be exactly 10 digits.',
            'mobile_number.max' => 'Mobile number must be exactly 10 digits.',
            'mobile_number.regex' => 'Only digits should be allowed to enter at mobile number.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $mobileNumber = $request->mobile_number;

        // Search for patients with this mobile number (with or without suffix) - ALL patients across all doctors
        $patients = Patient::where('mobile_number', 'like', $mobileNumber . '%')
            ->with(['appointments' => function ($query) {
                // Only load appointments created by the current doctor
                $query->where('doctor_id', Auth::id());
            }, 'appointments.doctor'])
            ->get();

        if ($patients->count() > 0) {
            return response()->json([
                'success' => true,
                'patients' => $patients,
                'message' => 'Found ' . $patients->count() . ' patient(s) with this mobile number.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No patients found with this mobile number.'
            ]);
        }
    }

    /**
     * Show Add New Patient form
     */
    public function showAddNewPatient(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        $mobileNumber = $request->get('mobile_number', '');
        $suffix = $request->get('suffix', '');

        return view('doctor.patients.add-patient', [
            'title' => 'Add Appointment',
            'breadcrumb' => 'Add Appointment',
            'mobileNumber' => $mobileNumber,
            'suffix' => $suffix
        ]);
    }

    /**
     * Store new patient (first step - without medical records)
     */
    public function storePatient(Request $request)
{
    // dd("storePatient called");
    if (!Auth::check() || !Auth::user()->isDoctor()) {
        return redirect('/doctor/login');
    }

    // Base validation rules (only patient data, no medical records)
    $validationRules = [
        'mobile_number' => 'required|string|min:10|max:10|regex:/^\d{10}$/',
        'name' => 'required|string|max:255',
        'diabetes_from' => 'nullable|date_format:m-Y',
        'diabetes_years' => 'nullable|integer|min:0|max:100', // Changed to nullable
        'diabetes_months' => 'nullable|integer|min:0|max:11', // Changed to nullable
        'date_of_birth' => 'nullable|date|before:today',
        'age' => 'required|integer|min:1|max:120',
        'short_address' => 'required|string|max:500',
        'sex' => 'required|in:male,female,other',
        'on_treatment' => 'required|boolean',
        'type_of_treatment' => 'nullable|array',
        'type_of_treatment.*' => 'in:allopathic,diet_control,ayurvedic,others',
        'type_of_treatment_other' => in_array('others', $request->type_of_treatment ?? []) ? 'required|string|max:255' : 'nullable|string|max:255',
        'bp' => 'required|boolean',
        'bp_since' => 'nullable',
        'bp_years' => 'nullable|integer|min:0|max:100',
        'bp_months' => 'nullable|integer|min:0|max:11',
        'other_diseases' => 'nullable|array',
        'other_diseases.*' => 'in:heart_disease,cholesterol,thyroid,stroke,others',
        'other_diseases_other' => in_array('others', $request->other_diseases ?? []) ? 'required|string|max:255' : 'nullable|string|max:255',
        'height_unit' => 'required|in:meter,feet',
        'height' => 'nullable|numeric', // Remove min/max - handle in conditional validation
        'weight' => 'nullable|numeric|min:10|max:500',
        'email' => 'nullable|email|max:255',
    ];

    $validator = Validator::make($request->all(), $validationRules, [
        'mobile_number.required' => 'Mobile number is required.',
        'name.required' => 'Name is required.',
        'age.required' => 'Age is required.',
        'type_of_treatment_other.required' => 'Please specify other type of treatment.',
        'other_diseases_other.required' => 'Please specify other disease.',
        'short_address.required' => 'Address is required.',
        'sex.required' => 'Sex is required.',
        'on_treatment.required' => 'Treatment status is required.',
        'bp.required' => 'BP status is required.',
        'weight.min' => 'Weight must be at least 10 kg.',
        'weight.max' => 'Weight must not exceed 500 kg.',
        'email.email' => 'Please enter a valid email address.'
    ]);

    // Custom validation for height, diabetes duration and BP duration
    $validator->after(function ($validator) use ($request) {
        // Height validation based on unit
        if ($request->filled('height')) {
            if ($request->height_unit == 'meter') {
                if ($request->height < 0.5 || $request->height > 3.0) {
                    $validator->errors()->add(
                        'height',
                        'Height must be between 0.5 and 3.0 meters'
                    );
                }
            } else { // feet
                if ($request->height < 2.0 || $request->height > 9.0) {
                    $validator->errors()->add(
                        'height',
                        'Height must be between 2.0 and 9.0 feet'
                    );
                }
            }
        }

        // Validate diabetes duration
        if (empty($request->diabetes_years) && empty($request->diabetes_months)) {
            $validator->errors()->add(
                'diabetes_years',
                'Please enter either diabetes years or months.'
            );
            $validator->errors()->add(
                'diabetes_months',
                'Please enter either diabetes years or months.'
            );
        }

        // Validate BP duration if BP is checked
        if ($request->bp == '1') {
            if (empty($request->bp_years) && empty($request->bp_months)) {
                $validator->errors()->add(
                    'bp_years',
                    'Please enter either BP years or months.'
                );
                $validator->errors()->add(
                    'bp_months',
                    'Please enter either BP years or months.'
                );
            }
        }
    });

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        // Generate SSSP ID
        $ssspId = Patient::generateSSSPId();

        // Handle A/B/C suffix for same mobile number per doctor
        $baseMobileNumber = $request->mobile_number;
        $finalMobileNumber = $this->generateMobileNumberWithSuffix($baseMobileNumber, Auth::id());

        // Handle date format conversions
$diabetesFrom = null;
if ($request->filled('diabetes_from')) {
    // Convert from m-Y format to database format (Y-m-01)
    try {
        $diabetesFrom = \Carbon\Carbon::createFromFormat('m-Y', $request->diabetes_from)->format('Y-m-01');
    } catch (\Exception $e) {
        \Log::error('Error parsing diabetes_from: ' . $request->diabetes_from . ' - ' . $e->getMessage());
        $diabetesFrom = null;
    }
}

$bpSince = null;
if ($request->filled('bp_since')) {
    // Convert from m-Y format to database format (Y-m-01)
    try {
        $bpSince = \Carbon\Carbon::createFromFormat('m-Y', $request->bp_since)->format('Y-m-01');
    } catch (\Exception $e) {
        \Log::error('Error parsing bp_since: ' . $request->bp_since . ' - ' . $e->getMessage());
        $bpSince = null;
    }
}

$visitDateTime = null;
if ($request->filled('visit_date_time')) {
    try {
        $visitDateTime = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->visit_date_time)->format('Y-m-d H:i:s');
    } catch (\Exception $e) {
        \Log::error('Error parsing visit_date_time: ' . $request->visit_date_time . ' - ' . $e->getMessage());
        $visitDateTime = now()->format('Y-m-d H:i:s');
    }
} else {
    $visitDateTime = now()->format('Y-m-d H:i:s');
}

$dateOfBirth = null;
if ($request->filled('date_of_birth')) {
    try {
        $dateOfBirth = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
    } catch (\Exception $e) {
        \Log::error('Error parsing date_of_birth: ' . $request->date_of_birth . ' - ' . $e->getMessage());
        $dateOfBirth = null;
    }
}

        // Handle height and BMI calculation (SAME as store appointment)
        $height = $request->filled('height') ? (float) $request->height : null;
        $heightUnit = $request->input('height_unit', 'meter');
        $weight = $request->filled('weight') ? (float) $request->weight : null;

        // Calculate BMI using the SAME method as JavaScript and store appointment
        $bmi = null;
        if ($height !== null && $weight !== null && $height > 0 && $weight > 0) {
            // Convert height to meters for BMI calculation if needed (same as JavaScript)
            $heightInMeters = $heightUnit === 'feet' ? $height * 0.3048 : $height;
            $bmi = round($weight / ($heightInMeters * $heightInMeters), 2);
        }

        // Create patient
        $patient = Patient::create([
            'mobile_number' => $finalMobileNumber,
            'name' => $request->name,
            'diabetes_from' => $diabetesFrom,
            'diabetes_years' => $request->diabetes_years,
            'diabetes_months' => $request->diabetes_months,
            'bp_years' => $request->bp_years,
            'bp_months' => $request->bp_months,
            'date_of_birth' => $dateOfBirth,
            'age' => $request->age,
            'short_address' => $request->short_address,
            'sex' => $request->sex,
            'sssp_id' => $ssspId,
            'hospital_id' => $request->hospital_id,
            'on_treatment' => $request->on_treatment,
            'type_of_treatment' => $request->type_of_treatment,
            'type_of_treatment_other' => ($request->type_of_treatment_other) ? trim($request->type_of_treatment_other) : null,
            'bp' => $request->bp,
            'bp_since' => $bpSince, // Use the processed bp_since
            'other_diseases' => $request->other_diseases,
            'other_diseases_other' => ($request->other_diseases_other) ? trim($request->other_diseases_other) : null,
            'other_input' => $request->other_input,
            'height' => $height,
            'height_unit' => $heightUnit,
            'weight' => $weight,
            'bmi' => $bmi, // Add BMI calculation
            'email' => $request->email,
            'created_by_doctor_id' => Auth::id()
        ]);

        $doctor = User::find(Auth::id());
            // WhatsApp Number
        $mobile = "91" . $patient->mobile_number;

        // MSG91 Template
        $templateName = "patient_registration";

        $components = [
            "body_1" => ["type" => "text", "value" => $patient->name],
            "body_2" => ["type" => "text", "value" => $doctor->hospital_name],
            "body_3" => ["type" => "text", "value" => $doctor->name],
        
        ];


        // Send WhatsApp
        sendWhatsapp($mobile, $templateName, $components);

        // Process "other" values from request
        $typeOtherInput = $request->input('type_of_treatment_other', '');
        $typeOfTreatmentOther = (!empty($typeOtherInput)) ? trim((string)$typeOtherInput) : null;

        $diseasesOtherInput = $request->input('other_diseases_other', '');
        $otherDiseasesOther = (!empty($diseasesOtherInput)) ? trim((string)$diseasesOtherInput) : null;

        // Create appointment with patient details snapshot
        $appointment = PatientAppointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => Auth::id(),
            'visit_date_time' => $visitDateTime,
            'appointment_type' => 'new',
            // Store patient details snapshot
            'patient_name' => $patient->name,
            'patient_diabetes_from' => $diabetesFrom,
            'patient_diabetes_years' => $request->diabetes_years,
            'patient_diabetes_months' => $request->diabetes_months,
            'patient_date_of_birth' => $dateOfBirth,
            'patient_age' => $patient->age,
            'patient_short_address' => $patient->short_address,
            'patient_sex' => $patient->sex,
            'patient_hospital_id' => $patient->hospital_id,
            'patient_on_treatment' => $patient->on_treatment,
            'patient_type_of_treatment' => $patient->type_of_treatment,
            'patient_treatment_other' => $typeOfTreatmentOther,
            'patient_bp' => $patient->bp,
            'patient_bp_since' => $bpSince, // Use patient's bp_since
            'patient_bp_years' => $request->bp_years,
            'patient_bp_months' => $request->bp_months,
            'patient_other_diseases' => $patient->other_diseases,
            'patient_disease_other' => $otherDiseasesOther,
            'patient_other_input' => $patient->other_input,
            'patient_height' => $patient->height,
            'patient_height_unit' => $patient->height_unit, // CORRECTED: height_unit not heightUnit
            'patient_weight' => $patient->weight,
            'patient_bmi' => $patient->bmi,
            'patient_email' => $patient->email,
            'patient_mobile_number' => $patient->mobile_number,
            'patient_sssp_id' => $patient->sssp_id
        ]);

        \Log::info('New Patient Created - Appointment snapshot:', [
            'appointment_id' => $appointment->id,
            'type_of_treatment_other_raw' => $request->input('type_of_treatment_other', ''),
            'type_of_treatment_other_processed' => $typeOfTreatmentOther,
            'other_diseases_other_raw' => $request->input('other_diseases_other', ''),
            'other_diseases_other_processed' => $otherDiseasesOther,
            'patient_treatment_other' => $appointment->patient_treatment_other,
            'patient_disease_other' => $appointment->patient_disease_other,
            'bmi_calculated' => $bmi
        ]);

        // Send patient notification with SSSP ID
        $reminderService = new ReminderService();
        $reminderService->sendPatientRegistrationConfirmation($patient);

        // Redirect to medical entry page
        return redirect()->route('doctor.patients.add-medical-entry', $appointment->id)
            ->with('success', 'Patient information updated and appointment created successfully.');
    } catch (\Exception $e) {
        \Log::error('Failed Reason....: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Failed to create patient. Please try again.')
            ->withInput();
    }
}
    /**
     * Show medical entry form for new patient
     */
    public function showAddMedicalEntry($appointmentId)
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        $appointment = PatientAppointment::with('patient')
            ->where('doctor_id', Auth::id())
            ->findOrFail($appointmentId);

        // Fetch previous medical records for pre-filling based on doctor type
        $previousPhysicianRecord = null;
        $previousOphthalmologistRecord = null;

        if (Auth::user()->doctor_type === 'diabetes_treating') {
            // Fetch previous physician record
            $previousMedicalRecord = PatientMedicalRecord::where('patient_id', $appointment->patient_id)
                ->where('appointment_id', '!=', $appointmentId)
                ->where('record_type', 'physician')
                ->whereHas('physicianRecord')
                ->with('physicianRecord')
                ->orderBy('id', 'desc')
                ->first();

            if ($previousMedicalRecord && $previousMedicalRecord->physicianRecord) {
                $previousPhysicianRecord = $previousMedicalRecord->physicianRecord;
            }
        } elseif (Auth::user()->doctor_type === 'ophthalmologist') {
            // Fetch previous ophthalmologist record
            $previousMedicalRecord = PatientMedicalRecord::where('patient_id', $appointment->patient_id)
                ->where('appointment_id', '!=', $appointmentId)
                ->where('record_type', 'ophthalmologist')
                ->whereHas('ophthalmologistRecord')
                ->with('ophthalmologistRecord')
                ->orderBy('id', 'desc')
                ->first();

            if ($previousMedicalRecord && $previousMedicalRecord->ophthalmologistRecord) {
                $previousOphthalmologistRecord = $previousMedicalRecord->ophthalmologistRecord;
            }
        }

        return view('doctor.patients.add-medical-entry', [
            'title' => 'Medical Entry',
            'breadcrumb' => 'Medical Entry',
            'appointment' => $appointment,
            'previousPhysicianRecord' => $previousPhysicianRecord,
            'previousOphthalmologistRecord' => $previousOphthalmologistRecord
        ]);
    }

    /**
     * Store medical entry for new patient
     */
    public function storeMedicalEntry(Request $request, $appointmentId)
    {

       
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        $appointment = PatientAppointment::where('doctor_id', Auth::id())
            ->findOrFail($appointmentId);

        // Normalize checkbox inputs - ensure arrays are always present
        if (Auth::user()->doctor_type === 'diabetes_treating') {
            $physicianRecord = $request->input('physician_record', []);
            $needsMerge = false;

            // Ensure current_treatment is always an array
            // Only set to empty array if field is missing, null, or not an array
            if (
                !isset($physicianRecord['current_treatment']) ||
                !is_array($physicianRecord['current_treatment'])
            ) {
                $physicianRecord['current_treatment'] = [];
                $needsMerge = true;
            }

            // Ensure others is always an array
            if (!isset($physicianRecord['others']) || !is_array($physicianRecord['others'])) {
                $physicianRecord['others'] = [];
                $needsMerge = true;
            }

            // Merge back to request only if we made changes
            if ($needsMerge) {
                $request->merge(['physician_record' => $physicianRecord]);
            }
        }

        // Validation rules based on doctor type
        $validationRules = [];
        
        if (Auth::user()->doctor_type === 'diabetes_treating') {
            $validationRules = [
                'physician_record.type_of_diabetes' => 'required|in:type1,type2,other',
                'physician_record.family_history_diabetes' => 'required|boolean',
                'physician_record.current_treatment' => 'required|array|min:1',
                'physician_record.current_treatment.*' => 'in:lifestyle,oha,insulin,glp1,ayurvedic_homeopathy,others',
                'physician_record.compliance' => 'required|in:good,irregular,poor',
                'physician_record.blood_sugar_type' => 'required|in:rbs,fbs,ppbs,hba1c',
                'physician_record.blood_sugar_value' => 'required|numeric|min:0|max:999.99',
                'physician_record.other_data' => 'nullable|string|max:1000',
                'physician_record.hypertension' => 'boolean',
                'physician_record.dyslipidemia' => 'boolean',
                'physician_record.retinopathy' => 'nullable|string|max:1000',
                'physician_record.neuropathy' => 'nullable|in:peripheral,autonomic,no',
                'physician_record.nephropathy' => 'nullable|in:no,microalbuminuria,proteinuria,ckd,on_dialysis',
                'physician_record.cardiovascular' => 'nullable|in:no,ihd,stroke,pvd',
                'physician_record.foot_disease' => 'nullable|in:no,ulcer,gangrene,deformity',
                'physician_record.others' => 'array',
                'physician_record.others.*' => 'in:infections,dental_problems,erectile_dysfunction,other',
                'physician_record.others_details' => 'nullable|string|max:1000',
                'physician_record.hba1c_range' => 'nullable|in:less_than_7,7_to_9,greater_than_9',
            ];

           
        } else {
            $validationRules = [
                'ophthalmologist_record.diabetic_retinopathy_re' => 'required|in:0,1',
'ophthalmologist_record.diabetic_retinopathy'     => 'required|in:0,1',
'ophthalmologist_record.diabetic_macular_edema_re' => 'required|in:0,1',
'ophthalmologist_record.diabetic_macular_edema'     => 'required|in:0,1',
                'ophthalmologist_record.type_of_dr' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->ophthalmologist_record['diabetic_retinopathy'] == '1';
                    }),
                    'nullable',
                    Rule::in([
                        'npdr_mild',
                        'npdr_moderate',
                        'npdr_severe',
                        'npdr_very_severe',
                        'pdr_non_high_risk',
                        'pdr_high_risk'
                    ]),
                ],

                // DR TYPE RE
                'ophthalmologist_record.type_of_dr_re' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->ophthalmologist_record['diabetic_retinopathy_re'] == '1';
                    }),
                    'nullable',
                    Rule::in([
                        'npdr_mild',
                        'npdr_moderate',
                        'npdr_severe',
                        'npdr_very_severe',
                        'pdr_non_high_risk',
                        'pdr_high_risk'
                    ]),
                ],

                // DME TYPE LE
                'ophthalmologist_record.type_of_dme' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->ophthalmologist_record['diabetic_macular_edema'] == '1';
                    }),
                    'nullable',
                    Rule::in(['nil_absent', 'present', 'mild', 'moderate', 'severe']),
                ],

                // DME TYPE RE
                'ophthalmologist_record.type_of_dme_re' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->ophthalmologist_record['diabetic_macular_edema_re'] == '1';
                    }),
                    'nullable',
                    Rule::in(['nil_absent', 'present', 'mild', 'moderate', 'severe']),
                ],
                'ophthalmologist_record.investigations' => 'nullable|array',
                'ophthalmologist_record.investigations.*' => 'in:fundus_pic,oct,octa,ffa,others',
                'ophthalmologist_record.investigations_others' => 'nullable|string|max:255',
                'ophthalmologist_record.advised' => 'nullable|in:no_treatment,close_watch,drops,medications,focal_laser,prp_laser,intravit_inj,steroid,surgery',
                'ophthalmologist_record.advised_re' => 'nullable|in:no_treatment,close_watch,drops,medications,focal_laser,prp_laser,intravit_inj,steroid,surgery',
                'ophthalmologist_record.treatment_done_date' => 'nullable|date',
                'ophthalmologist_record.review_date' => 'nullable|date',
                'ophthalmologist_record.other_remarks' => 'nullable|string|max:1000',

                'ucva_re' => 'nullable|string|max:255',
                'ucva_le' => 'nullable|string|max:255',
                'bcva_re' => 'nullable|string|max:255',
                'bcva_le' => 'nullable|string|max:255',
                'anterior_segment_re' => 'nullable|string|max:255',
                'anterior_segment_le' => 'nullable|string|max:255',
                'iop_re' => 'nullable|string|max:255',
                'iop_le' => 'nullable|string|max:255',
            ];
        }

        // Friendly attribute names to avoid prefixes like "The physician record."
        $attributeNames = [];
        if (Auth::user()->doctor_type === 'diabetes_treating') {
            $attributeNames = [
                'physician_record.type_of_diabetes' => 'Type of diabetes',
                'physician_record.family_history_diabetes' => 'Family history of diabetes',
                'physician_record.current_treatment' => 'Current treatment',
                'physician_record.compliance' => 'Compliance',
                'physician_record.blood_sugar_type' => 'Blood sugar type',
                'physician_record.blood_sugar_value' => 'Blood sugar value',
                'physician_record.current_treatment_other' => 'Specify Other Treatment',
            ];
        } else {
            $attributeNames = [
                'ophthalmologist_record.diabetic_retinopathy' => 'Diabetic Retinopathy (DR) LE',
                'ophthalmologist_record.diabetic_macular_edema' => 'Diabetic Macular Edema (DME) LE',
                'ophthalmologist_record.diabetic_retinopathy_re' => 'Diabetic Retinopathy (DR) RE',
                'ophthalmologist_record.diabetic_macular_edema_re' => 'Diabetic Macular Edema (DME) RE',
                'ophthalmologist_record.type_of_dr' => 'Type of DR',
                'ophthalmologist_record.type_of_dr_re' => 'Type of DR RE',
                'ophthalmologist_record.type_of_dme' => 'Type of DME',
                'ophthalmologist_record.type_of_dme_re' => 'Type of DME RE',

                'ophthalmologist_record.ucva_re' => 'UCVA RE',
                'ophthalmologist_record.ucva_le' => 'UCVA LE',
                'ophthalmologist_record.bcva_re' => 'BCVA RE',
                'ophthalmologist_record.bcva_le' => 'BCVA LE',
                'ophthalmologist_record.anterior_segment_re' => 'Anterior Segment RE',
                'ophthalmologist_record.anterior_segment_le' => 'Anterior Segment LE',
                'ophthalmologist_record.iop_re' => 'IOP RE',
                'ophthalmologist_record.iop_le' => 'IOP LE',


            ];
        }

        $validator = Validator::make($request->all(), $validationRules, [
            'physician_record.current_treatment_other.required' => 'Specify Other Treatment is required.',
            'physician_record.current_treatment_other.string' => 'Specify Other Treatment must be a valid text.',
            'physician_record.current_treatment_other.max' => 'Specify Other Treatment may not be greater than 500 characters.',
            'ophthalmologist_record.investigations_others.required' => 'Please specify other investigations.',
            // Specific required messages without the leading "The"
            'physician_record.type_of_diabetes.required' => 'Type of diabetes field is required.',
            'physician_record.current_treatment.required' => 'Current treatment field is required.',
            'physician_record.current_treatment.min' => 'Please select at least one Current Treatment option.',
            'physician_record.blood_sugar_type.required' => 'Blood sugar type field is required.',
            'physician_record.blood_sugar_value.required' => 'Blood sugar value field is required.',
            'physician_record.others_details.required' => 'Please specify the other details.'
        ], $attributeNames);
        // Add conditional validation for current_treatment_other
        if (Auth::user()->doctor_type === 'diabetes_treating') {
            $validator->sometimes('physician_record.current_treatment_other', 'required|string|max:500', function ($input) use ($request) {
                $currentTreatment = $request->input('physician_record.current_treatment', []);
                if (!is_array($currentTreatment)) {
                    $currentTreatment = [];
                }
                return in_array('others', $currentTreatment);
            });
        }

        // Add conditional validation for others_details - PUT IT RIGHT HERE
if (Auth::user()->doctor_type === 'diabetes_treating') {
    $validator->sometimes('physician_record.others_details', 'required|string|max:1000', function ($input) use ($request) {
        $others = $request->input('physician_record.others', []);
        if (!is_array($others)) {
            $others = [];
        }
        return in_array('other', $others);
    });


}

        // Add conditional validation for investigations_others
        if (Auth::user()->doctor_type === 'ophthalmologist') {
            $validator->sometimes('ophthalmologist_record.investigations_others', 'required|string|max:255', function ($input) use ($request) {
                $investigations = $request->input('ophthalmologist_record.investigations', []);
                if (!is_array($investigations)) {
                    $investigations = [];
                }
                return in_array('others', $investigations);
            });
        }
        // dd($validator->errors());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            if (Auth::user()->doctor_type === 'diabetes_treating') {
                \Log::info('Creating physician record for appointment: ' . $appointmentId);

                $patientMedicalRecord = \App\Models\PatientMedicalRecord::create([
                    'patient_id' => $appointment->patient_id,
                    'appointment_id' => $appointment->id,
                    'record_type' => 'physician'
                ]);

                $physicianRecord = \App\Models\PhysicianMedicalRecord::create([
                    'patient_medical_record_id' => $patientMedicalRecord->id,
                    'type_of_diabetes' => $request->input('physician_record.type_of_diabetes'),
                    'family_history_diabetes' => $request->boolean('physician_record.family_history_diabetes'),
                    'current_treatment' => $request->input('physician_record.current_treatment'),
                    'current_treatment_other' => (function () use ($request) {
                        $currentTreatment = $request->input('physician_record.current_treatment', []);
                        $currentTreatmentOther = $request->input('physician_record.current_treatment_other');
                        if (is_array($currentTreatment) && in_array('others', $currentTreatment) && !empty($currentTreatmentOther)) {
                            return trim($currentTreatmentOther);
                        }
                        return null;
                    })(),
                    'compliance' => $request->input('physician_record.compliance'),
                    'blood_sugar_type' => $request->input('physician_record.blood_sugar_type'),
                    'blood_sugar_value' => $request->input('physician_record.blood_sugar_value'),
                    'other_data' => ($request->input('physician_record.other_data')) ? trim($request->input('physician_record.other_data')) : null,
                    'hypertension' => $request->boolean('physician_record.hypertension'),
                    'dyslipidemia' => $request->boolean('physician_record.dyslipidemia'),
                    'retinopathy' => ($request->input('physician_record.retinopathy')) ? trim($request->input('physician_record.retinopathy')) : null,
                    'neuropathy' => $request->input('physician_record.neuropathy'),
                    'nephropathy' => $request->input('physician_record.nephropathy'),
                    'cardiovascular' => $request->input('physician_record.cardiovascular'),
                    'foot_disease' => $request->input('physician_record.foot_disease'),
                    'others' => $request->input('physician_record.others', []),
                    'others_details' => ($request->input('physician_record.others_details')) ? trim($request->input('physician_record.others_details')) : null,
                    'hba1c_range' => $request->input('physician_record.hba1c_range')
                ]);

                return redirect()->route('doctor.medical.summary', $patientMedicalRecord->id)
                    ->with('success', 'Appointment details added successfully.');
            } else {
                \Log::info('Creating ophthalmologist record for appointment: ' . $appointmentId);

                $patientMedicalRecord = \App\Models\PatientMedicalRecord::create([
                    'patient_id' => $appointment->patient_id,
                    'appointment_id' => $appointment->id,
                    'record_type' => 'ophthalmologist'
                ]);
                $dr = $request->input('ophthalmologist_record.diabetic_retinopathy');
                $dr_re = $request->input('ophthalmologist_record.diabetic_retinopathy_re');

                $dme = $request->input('ophthalmologist_record.diabetic_macular_edema');
                $dme_re = $request->input('ophthalmologist_record.diabetic_macular_edema_re');


                $ophthalmologistRecord = \App\Models\OphthalmologistMedicalRecord::create([
                    'patient_medical_record_id' => $patientMedicalRecord->id,
                    'diabetic_retinopathy' => $request->input('ophthalmologist_record.diabetic_retinopathy') == '1' || $request->input('ophthalmologist_record.diabetic_retinopathy') === 1 || $request->input('ophthalmologist_record.diabetic_retinopathy') === true,

                    'diabetic_retinopathy_re' => $request->input('ophthalmologist_record.diabetic_retinopathy_re') == '1' || $request->input('ophthalmologist_record.diabetic_retinopathy_re') === 1 || $request->input('ophthalmologist_record.diabetic_retinopathy_re') === true,

                    'diabetic_macular_edema' => $request->input('ophthalmologist_record.diabetic_macular_edema') == '1' || $request->input('ophthalmologist_record.diabetic_macular_edema') === 1 || $request->input('ophthalmologist_record.diabetic_macular_edema') === true,

                    'diabetic_macular_edema_re' => $request->input('ophthalmologist_record.diabetic_macular_edema_re') == '1' || $request->input('ophthalmologist_record.diabetic_macular_edema_re') === 1 || $request->input('ophthalmologist_record.diabetic_macular_edema_re') === true,

                    'type_of_dr'     => $dr == '1' ? $request->input('ophthalmologist_record.type_of_dr') : null,
                    'type_of_dr_re'  => $dr_re == '1' ? $request->input('ophthalmologist_record.type_of_dr_re') : null,

                    // --------------------------------------------------------------------------------------
                    // DME TYPE: Only store value if YES (1), otherwise NULL
                    // --------------------------------------------------------------------------------------
                    'type_of_dme'    => $dme == '1' ? $request->input('ophthalmologist_record.type_of_dme') : null,
                    'type_of_dme_re' => $dme_re == '1' ? $request->input('ophthalmologist_record.type_of_dme_re') : null,

                    'investigations' => $request->input('ophthalmologist_record.investigations'),
                    'investigations_others' => $request->input('ophthalmologist_record.investigations_others'),
                    'advised' => $request->input('ophthalmologist_record.advised'),
                    'advised_re' => $request->input('ophthalmologist_record.advised_re'),
                    'treatment_done_date' => $request->input('ophthalmologist_record.treatment_done_date'),
                    'review_date' => $request->input('ophthalmologist_record.review_date'),
                    'other_remarks' => $request->input('ophthalmologist_record.other_remarks'),

                    'ucva_re' => $request->input('ophthalmologist_record.ucva_re'),
                    'ucva_le' => $request->input('ophthalmologist_record.ucva_le'),
                    'bcva_re' => $request->input('ophthalmologist_record.bcva_re'),
                    'bcva_le' => $request->input('ophthalmologist_record.bcva_le'),
                    'anterior_segment_re' => $request->input('ophthalmologist_record.anterior_segment_re'),
                    'anterior_segment_le' => $request->input('ophthalmologist_record.anterior_segment_le'),
                    'iop_re' => $request->input('ophthalmologist_record.iop_re'),
                    'iop_le' => $request->input('ophthalmologist_record.iop_le'),





                ]);

                return redirect()->route('doctor.medical.summary', $patientMedicalRecord->id)
                    ->with('success', 'Appointment details added successfully.');
            }
        } catch (\Exception $e) {
            \Log::error('Failed to save medical record: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to save medical record. Please try again.')
                ->withInput();
        }
    }

    /**
     * Store appointment for existing patient (step 1 - update patient info and create appointment)
     */
public function storeAppointmentExistingStep1(Request $request)
{
    
    if (!Auth::check() || !Auth::user()->isDoctor()) {
        return redirect('/doctor/login');
    }

    // Base validation rules
    $validationRules = [
        'patient_id' => 'required|exists:patients,id',
        'visit_date_time' => 'required|date_format:d-m-Y H:i',
        'name' => 'required|string|max:255',
        'diabetes_from' => 'nullable|date_format:m-Y',
        'diabetes_years' => 'nullable|integer|min:0|max:100',
        'diabetes_months' => 'nullable|integer|min:0|max:11',
        'date_of_birth' => 'nullable|date_format:d-m-Y|before:today',
        'age' => 'required|integer|min:0|max:150',
        'short_address' => 'required|string|max:500',
        'sex' => 'required|in:male,female,other',
        'hospital_id' => 'nullable|string|max:100',
        'on_treatment' => 'boolean',
        'type_of_treatment' => 'array|nullable',
        'type_of_treatment.*' => 'in:allopathic,diet_control,ayurvedic,others',
        'type_of_treatment_other' => in_array('others', $request->type_of_treatment ?? []) ? 'required|string|max:255' : 'nullable|string|max:255',
        'bp' => 'boolean',
        'bp_since' => 'nullable', // Simplified
        'bp_years' => 'nullable|integer|min:0|max:100',
        'bp_months' => 'nullable|integer|min:0|max:11',
        'other_diseases' => 'array|nullable',
        'other_diseases.*' => 'in:heart_disease,cholesterol,thyroid,stroke,others',
        'other_diseases_other' => in_array('others', $request->other_diseases ?? []) ? 'required|string|max:255' : 'nullable|string|max:255',
        'other_input' => 'nullable|string|max:1000',
        'height' => 'nullable|numeric|min:0.5|max:3.0',
        'height_unit' => 'required|in:meter,feet',
        'weight' => 'nullable|numeric|min:1|max:500',
        'email' => 'nullable|email|max:255',
    ];

    // Add conditional validation for height when unit is feet
    if ($request->input('height_unit') === 'feet') {
        $validationRules['height'] = 'nullable|numeric|min:2|max:9.9';
    }

    $validator = Validator::make($request->all(), $validationRules, [
        'date_of_birth.before' => 'Date of Birth must be before today.',
         'visit_date_time.date_format' => 'Appointment date must be in DD-MM-YYYY HH:MM format.',
        'date_of_birth.date_format' => 'Date of Birth must be in DD-MM-YYYY format.',
        'diabetes_from.date_format' => 'Diabetes Since must be in MM-YYYY format.',
        // REMOVED conflicting error messages for required fields
        'type_of_treatment_other.required' => 'Please specify other type of treatment.',
        'other_diseases_other.required' => 'Please specify other disease.',
        'height.min' => 'Height must be at least :min ' . ($request->input('height_unit') === 'feet' ? 'feet' : 'meters') . '.',
        'height.max' => 'Height cannot exceed :max ' . ($request->input('height_unit') === 'feet' ? 'feet' : 'meters') . '.',
    ]);

    // Custom validation for diabetes duration and BP duration
    $validator->after(function ($validator) use ($request) {
        // Validate diabetes duration
        if (empty($request->diabetes_years) && empty($request->diabetes_months)) {
            $validator->errors()->add(
                'diabetes_years',
                'Please enter either diabetes years or months.'
            );
            $validator->errors()->add(
                'diabetes_months',
                'Please enter either diabetes years or months.'
            );
        }

        // Validate BP duration if BP is checked
        if ($request->bp == '1') {
            if (empty($request->bp_years) && empty($request->bp_months)) {
                $validator->errors()->add(
                    'bp_years',
                    'Please enter either BP years or months.'
                );
                $validator->errors()->add(
                    'bp_months',
                    'Please enter either BP years or months.'
                );
            }
        }
    });

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Get the patient
    $patient = Patient::findOrFail($request->patient_id);

    try {
        // Handle height and BMI calculation
        $height = $request->filled('height') ? (float) $request->height : null;
        $heightUnit = $request->input('height_unit', 'meter');
        $weight = $request->filled('weight') ? (float) $request->weight : null;

        // Calculate BMI using the SAME method as JavaScript
        $bmi = null;
        if ($height !== null && $weight !== null && $height > 0 && $weight > 0) {
            // Convert height to meters for BMI calculation if needed (same as JavaScript)
            $heightInMeters = $heightUnit === 'feet' ? $height * 0.3048 : $height;
            $bmi = round($weight / ($heightInMeters * $heightInMeters), 2);
        }

        // Normalize arrays
        $typeOfTreatment = $request->input('type_of_treatment', []);
        if (!is_array($typeOfTreatment)) {
            $typeOfTreatment = [];
        }

        $otherDiseases = $request->input('other_diseases', []);
        if (!is_array($otherDiseases)) {
            $otherDiseases = [];
        }

        // Process "other" fields
        $typeOfTreatmentOther = $request->filled('type_of_treatment_other') ? trim($request->type_of_treatment_other) : null;
        $otherDiseasesOther = $request->filled('other_diseases_other') ? trim($request->other_diseases_other) : null;

        // NEW: Convert dates from d-m-Y to Y-m-d for database
        $visitDateTime = null;
        if ($request->visit_date_time) {
            $visitDateTime = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->visit_date_time)->format('Y-m-d H:i:s');
        }

        $dateOfBirth = null;
        if ($request->date_of_birth) {
            $dateOfBirth = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
        }

        $diabetesFrom = null;
        if ($request->diabetes_from) {
            $diabetesFrom = \Carbon\Carbon::createFromFormat('m-Y', $request->diabetes_from)->format('Y-m-01');
        }

        $bpSince = null;
        if ($request->bp_since) {
            $bpSince = \Carbon\Carbon::createFromFormat('m-Y', $request->bp_since)->format('Y-m-01');
        }

        // Prepare patient update data
        $patientUpdateData = [
            'name' => $request->name,
            'date_of_birth' => $dateOfBirth,
            'age' => $request->age,
            'short_address' => $request->short_address,
            'sex' => $request->sex,
            'hospital_id' => $request->hospital_id,
            'on_treatment' => $request->on_treatment,
            'type_of_treatment' => $typeOfTreatment,
            'type_of_treatment_other' => $typeOfTreatmentOther,
            'bp' => $request->bp,
            'other_diseases' => $otherDiseases,
            'other_diseases_other' => $otherDiseasesOther,
            'other_input' => $request->other_input,
            'email' => $request->email,
            'height' => $height,
            'height_unit' => $heightUnit,
            'weight' => $weight,
            'bmi' => $bmi,
            'diabetes_years' => $request->diabetes_years,
            'diabetes_months' => $request->diabetes_months,
            'bp_years' => $request->bp_years,
            'bp_months' => $request->bp_months,
            'diabetes_from' => $diabetesFrom, // Use converted date
            'bp_since' => $bpSince, // Use converted date
        ];


        // Update patient information
        $patient->update($patientUpdateData);

        // Refresh patient to get updated data
        $patient->refresh();

        // Create appointment with patient details snapshot
        $appointmentData = [
    'patient_id' => $request->patient_id,
    'doctor_id' => Auth::id(),
    'visit_date_time' => $visitDateTime, // Use converted date
    'appointment_type' => 'follow_up',
    // Store patient details snapshot - USE CONVERTED DATES
    'patient_name' => $request->input('name'),
    'patient_diabetes_from' => $diabetesFrom, // Use converted date
    'patient_diabetes_years' => $request->diabetes_years,
    'patient_diabetes_months' => $request->diabetes_months,
    'patient_date_of_birth' => $dateOfBirth, // Use converted date
    'patient_age' => $request->input('age'),
    'patient_short_address' => $request->input('short_address'),
    'patient_sex' => $request->input('sex'),
    'patient_hospital_id' => $request->input('hospital_id'),
    'patient_on_treatment' => $request->input('on_treatment'),
    'patient_type_of_treatment' => $typeOfTreatment,
    'patient_treatment_other' => $typeOfTreatmentOther,
    'patient_bp' => $request->input('bp'),
    'patient_bp_since' => $bpSince, // Use converted date
    'patient_bp_years' => $request->bp_years,
    'patient_bp_months' => $request->bp_months,
    'patient_other_diseases' => $otherDiseases,
    'patient_disease_other' => $otherDiseasesOther,
    'patient_other_input' => $request->input('other_input'),
    'patient_height' => $height,
    'patient_height_unit' => $heightUnit,
    'patient_weight' => $weight,
    'patient_bmi' => $bmi,
    'patient_email' => $request->input('email'),
    'patient_mobile_number' => $request->input('mobile_number'),
    'patient_sssp_id' => $request->input('sssp_id') ?? $patient->sssp_id,
];

        // Log for debugging
        \Log::info('BMI CALCULATION DETAILS:', [
            'height_input' => $height,
            'height_unit' => $heightUnit,
            'weight_input' => $weight,
            'bmi_calculated' => $bmi,
            'calculation' => $height !== null && $weight !== null ?
                "BMI = $weight / (" . ($heightUnit === 'feet' ? $height * 0.3048 : $height) . " * " . ($heightUnit === 'feet' ? $height * 0.3048 : $height) . ")" :
                'No BMI calculation - missing height or weight'
        ]);

        $appointment = PatientAppointment::create($appointmentData);

        \Log::info('STORAGE VERIFICATION:', [
            'patient_table_bmi' => $patient->bmi,
            'appointment_table_bmi' => $appointment->patient_bmi,
            'are_equal' => $patient->bmi === $appointment->patient_bmi
        ]);

        // Redirect to medical entry page
        return redirect()->route('doctor.patients.add-medical-entry', $appointment->id)
            ->with('success', 'Patient information updated and appointment created successfully.');

    } catch (\Exception $e) {
        \Log::error('Failed to update patient and create appointment: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return redirect()->back()
            ->with('error', 'Failed to update patient and create appointment. Please try again.')
            ->withInput();
    }
}

    /**
     * Show Add New Appointment for existing patient - Works with shared patients
     */
    public function showAddNewAppointment(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        $patientId = $request->get('patient_id');
        $patient = Patient::findOrFail($patientId);

        return view('doctor.patients.add-appointment-existing', [
            'title' => 'Add Appointment',
            'breadcrumb' => 'Add Appointment',
            'patient' => $patient
        ]);
    }

    /**
     * Store new appointment for existing patient - Works with shared patients
     */
    public function storeAppointment(Request $request)
    {
        // dd('storeAppointment called');
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'visit_date_time' => 'required|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Allow appointment for any patient (shared patient system)
        $patient = Patient::findOrFail($request->patient_id);

        try {
            // Create appointment with patient details snapshot
            $appointmentData = [
                'patient_id' => $request->patient_id,
                'doctor_id' => Auth::id(),
                'visit_date_time' => $request->visit_date_time,
                'appointment_type' => 'follow_up',
                // Store patient details snapshot
                'patient_name' => $patient->name,
                'patient_diabetes_from' => $patient->diabetes_from,
                'patient_date_of_birth' => $patient->date_of_birth,
                'patient_age' => $patient->age,
                'patient_short_address' => $patient->short_address,
                'patient_sex' => $patient->sex,
                'patient_hospital_id' => $patient->hospital_id,
                'patient_on_treatment' => $patient->on_treatment,
                'patient_type_of_treatment' => $patient->type_of_treatment,
                'patient_bp' => $patient->bp,
                'patient_bp_since' => $patient->bp_since,
                'patient_other_diseases' => $patient->other_diseases,
                'patient_other_input' => $patient->other_input,
                'patient_height' => $patient->height,
                'patient_weight' => $patient->weight,
                'patient_bmi' => $patient->bmi,
                'patient_email' => $patient->email,
                'patient_mobile_number' => $patient->mobile_number,
                'patient_sssp_id' => $patient->sssp_id
            ];

            // Save snapshot fields for "other" values from patient
            $appointmentData['patient_treatment_other'] = $patient->type_of_treatment_other ?? null;
            $appointmentData['patient_disease_other'] = $patient->other_diseases_other ?? null;

            $appointment = PatientAppointment::create($appointmentData);

            // Redirect based on doctor type to medical entries
            if (Auth::user()->doctor_type === 'diabetes_treating') {
                return redirect()->route('doctor.medical.physician-entries', $appointment->id)
                    ->with('success', 'Appointment created successfully. Please fill in the physician entries.');
            } else {
                return redirect()->route('doctor.medical.ophthalmologist-entries', $appointment->id)
                    ->with('success', 'Appointment created successfully. Please fill in the ophthalmologist entries.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create appointment. Please try again.');
        }
    }

    /**
     * Store new appointment with patient update for existing patient - Works with shared patients
     */
    public function storeAppointmentWithPatientUpdate(Request $request)
    {

        // dd('storeAppointmentWithPatientUpdate called');
        $appointmentId = $request->route('appointment_id');
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        // Base validation rules
        $validationRules = [
            'patient_id' => 'required|exists:patients,id',
            'visit_date_time' => 'required|date',
            'name' => 'required|string|max:255',
            'diabetes_from' => 'nullable|date_format:Y-m',
            'diabetes_years' => 'required|integer|min:0|max:100',
            'diabetes_months' => 'required|integer|min:0|max:11',
            // 'diabetes_years' => 'required',
            'date_of_birth' => 'nullable|date|before:today',
            'age' => 'required|integer|min:0|max:150',
            'short_address' => 'required|string|max:500',
            'sex' => 'required|in:male,female,other',
            'hospital_id' => 'nullable|string|max:100',
            'on_treatment' => 'boolean',
            'type_of_treatment' => 'array|nullable',
            'type_of_treatment.*' => 'in:allopathic,diet_control,ayurvedic,others',
            'bp' => 'boolean',
            'bp_since' => $request->bp == '1' ? 'nullable' : 'nullable',
            'bp_years' => $request->bp == '1' ? 'required' : 'nullable',
            'other_diseases' => 'array',
            'other_diseases.*' => 'in:heart_disease,cholesterol,thyroid,stroke,others',
            'other_input' => 'nullable|string|max:1000',
            'height' => 'nullable|numeric|min:0.5|max:3.0',
            'weight' => 'nullable|numeric|min:1|max:500',
            'email' => 'nullable|email|max:255',
        ];

        // Add medical record validation based on doctor type
        if (Auth::user()->doctor_type === 'diabetes_treating') {
            // Physician record validation for diabetes-treating doctors
            $validationRules = array_merge($validationRules, [
                'physician_record.type_of_diabetes' => 'required|in:type1,type2,other',
                'physician_record.family_history_diabetes' => 'required|boolean',
                'physician_record.current_treatment' => 'required|array|min:1',
                'physician_record.current_treatment.*' => 'in:lifestyle,oha,insulin,glp1,ayurvedic_homeopathy,others',
                'physician_record.compliance' => 'required|in:good,irregular,poor',
                'physician_record.blood_sugar_type' => 'required|in:rbs,fbs,ppbs,hba1c',
                'physician_record.blood_sugar_value' => 'required|numeric|min:0|max:999.99',
                'physician_record.other_data' => 'nullable|string|max:1000',

                'physician_record.hypertension' => 'boolean',

                'physician_record.dyslipidemia' => 'boolean',

                'physician_record.retinopathy' => 'nullable|string|max:1000',

                'physician_record.neuropathy' => 'nullable|in:peripheral,autonomic,no',

                'physician_record.nephropathy' => 'nullable|in:no,microalbuminuria,proteinuria,ckd,on_dialysis',

                'physician_record.cardiovascular' => 'nullable|in:no,ihd,stroke,pvd',

                'physician_record.foot_disease' => 'nullable|in:no,ulcer,gangrene,deformity',

                'physician_record.others' => 'array',

                'physician_record.others.*' => 'in:infections,dental_problems,erectile_dysfunction,other',

                'physician_record.others_details' => 'nullable|string|max:1000',

                'physician_record.hba1c_range' => 'nullable|in:less_than_7,7_to_9,greater_than_9',
            ]);
        } else {
            // Ophthalmologist record validation for ophthalmologists
            $validationRules = array_merge($validationRules, [
                'ophthalmologist_record.diabetic_retinopathy' => 'required|boolean',
                'ophthalmologist_record.diabetic_macular_edema' => 'required|boolean',

                'ophthalmologist_record.investigations' => 'nullable|array',
                'ophthalmologist_record.investigations.*' => 'in:fundus_pic,oct,octa,ffa,others',
                'ophthalmologist_record.investigations_others' => 'nullable|string|max:255',
                'ophthalmologist_record.advised' => 'nullable|in:no_treatment,close_watch,drops,medications,focal_laser,prp_laser,intravit_inj,steroid,surgery',
                'ophthalmologist_record.treatment_done_date' => 'nullable|date',
                'ophthalmologist_record.review_date' => 'nullable|date',
                'ophthalmologist_record.other_remarks' => 'nullable|string|max:1000',
                'ophthalmologist_record.diabetic_retinopathy_re' => 'required|boolean',
                'ophthalmologist_record.diabetic_macular_edema_re' => 'required|boolean',

                'ophthalmologist_record.type_of_dr' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->ophthalmologist_record['diabetic_retinopathy'] == '1';
                    }),
                    'nullable',
                    Rule::in([
                        'npdr_mild',
                        'npdr_moderate',
                        'npdr_severe',
                        'npdr_very_severe',
                        'pdr_non_high_risk',
                        'pdr_high_risk'
                    ]),
                ],

                // DR TYPE RE
                'ophthalmologist_record.type_of_dr_re' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->ophthalmologist_record['diabetic_retinopathy_re'] == '1';
                    }),
                    'nullable',
                    Rule::in([
                        'npdr_mild',
                        'npdr_moderate',
                        'npdr_severe',
                        'npdr_very_severe',
                        'pdr_non_high_risk',
                        'pdr_high_risk'
                    ]),
                ],

                // DME TYPE LE
                'ophthalmologist_record.type_of_dme' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->ophthalmologist_record['diabetic_macular_edema'] == '1';
                    }),
                    'nullable',
                    Rule::in(['nil_absent', 'present', 'mild', 'moderate', 'severe']),
                ],

                // DME TYPE RE
                'ophthalmologist_record.type_of_dme_re' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->ophthalmologist_record['diabetic_macular_edema_re'] == '1';
                    }),
                    'nullable',
                    Rule::in(['nil_absent', 'present', 'mild', 'moderate', 'severe']),
                ],
                'ucva_re' => 'nullable|string|max:255',
                'ucva_le' => 'nullable|string|max:255',
                'bcva_re' => 'nullable|string|max:255',
                'bcva_le' => 'nullable|string|max:255',
                'anterior_segment_re' => 'nullable|string|max:255',
                'anterior_segment_le' => 'nullable|string|max:255',
                'iop_re' => 'nullable|string|max:255',
                'iop_le' => 'nullable|string|max:255',
                'ophthalmologist_record.advised_re' => 'nullable|in:no_treatment,close_watch,drops,medications,focal_laser,prp_laser,intravit_inj,steroid,surgery',
            ]);
        }

        $validator = Validator::make($request->all(), $validationRules);

        // Add conditional validation for investigations_others
        $validator->sometimes('ophthalmologist_record.investigations_others', 'required|string|max:255', function ($input) use ($request) {
            $investigations = $request->input('ophthalmologist_record.investigations', []);
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

        // Allow appointment for any patient (shared patient system)
        $patient = Patient::findOrFail($request->patient_id);

        try {
            // Update patient information
            $updateData = $request->only([
                'name',
                'date_of_birth',
                'age',
                'short_address',
                'sex',
                'hospital_id',
                'on_treatment',
                'type_of_treatment',
                'bp',
                'other_diseases',
                'other_input',
                'height',
                'weight',
                'email'
            ]);

            // Handle month format fields
            if ($request->diabetes_from) {
                $updateData['diabetes_from'] = $request->diabetes_from . '-01'; // Convert YYYY-MM to YYYY-MM-DD
            }

            if ($request->bp_since) {
                $updateData['bp_since'] = $request->bp_since . '-01'; // Convert YYYY-MM to YYYY-MM-DD
            }

            // Normalize arrays first
            $typeOfTreatment = $request->input('type_of_treatment', []);
            if (!is_array($typeOfTreatment)) {
                $typeOfTreatment = [];
            }

            $otherDiseases = $request->input('other_diseases', []);
            if (!is_array($otherDiseases)) {
                $otherDiseases = [];
            }

            // ALWAYS get and process type_of_treatment_other from request - SIMPLE and DIRECT
            $typeOtherInput = $request->input('type_of_treatment_other', '');
            $typeOfTreatmentOther = (!empty($typeOtherInput)) ? trim((string)$typeOtherInput) : null;
            if ($typeOfTreatmentOther !== null && $typeOfTreatmentOther !== '') {
                $updateData['type_of_treatment_other'] = $typeOfTreatmentOther;
            }

            // ALWAYS get and process other_diseases_other from request - SIMPLE and DIRECT
            $diseasesOtherInput = $request->input('other_diseases_other', '');
            $otherDiseasesOther = (!empty($diseasesOtherInput)) ? trim((string)$diseasesOtherInput) : null;
            if ($otherDiseasesOther !== null && $otherDiseasesOther !== '') {
                $updateData['other_diseases_other'] = $otherDiseasesOther;
            }

            $patient->update($updateData);

            // Refresh patient to get updated data
            $patient->refresh();

            // Handle date format conversions
            $diabetesFrom = $request->input('diabetes_from');
            if ($diabetesFrom && !str_contains($diabetesFrom, '-')) {
                $diabetesFrom = $diabetesFrom . '-01';
            }

            $bpSince = $request->input('bp_since');
            if ($bpSince && !str_contains($bpSince, '-')) {
                $bpSince = $bpSince . '-01';
            }

            // Create appointment with patient details snapshot - save ALL fields directly from request
            $appointmentData = [
                'patient_id' => $request->patient_id,
                'doctor_id' => Auth::id(),
                'visit_date_time' => $request->visit_date_time,
                'appointment_type' => 'follow_up',
                // Store patient details snapshot directly from request
                'patient_name' => $request->input('name'),
                'patient_diabetes_from' => $diabetesFrom,
                'patient_date_of_birth' => $request->input('date_of_birth'),
                'patient_age' => $request->input('age'),
                'patient_short_address' => $request->input('short_address'),
                'patient_sex' => $request->input('sex'),
                'patient_hospital_id' => $request->input('hospital_id'),
                'patient_on_treatment' => $request->input('on_treatment'),
                'patient_type_of_treatment' => $typeOfTreatment,
                'patient_bp' => $request->input('bp'),
                'patient_bp_since' => $bpSince,
                'patient_other_diseases' => $otherDiseases,
                'patient_other_input' => $request->input('other_input'),
                'patient_height' => $request->input('height'),
                'patient_weight' => $request->input('weight'),
                'patient_bmi' => $request->input('bmi'),
                'patient_email' => $request->input('email'),
                'patient_mobile_number' => $request->input('mobile_number'),
                'patient_sssp_id' => $request->input('sssp_id')
            ];

            // Save snapshot fields for "other" values - Already included in appointmentData array above
            \Log::info('Creating Appointment (with patient update) - COMPLETE DATA:', [
                'type_of_treatment_other_raw' => $request->input('type_of_treatment_other', ''),
                'type_of_treatment_other_processed' => $typeOfTreatmentOther,
                'other_diseases_other_raw' => $request->input('other_diseases_other', ''),
                'other_diseases_other_processed' => $otherDiseasesOther,
                'appointment_data_type_other_value' => $appointmentData['patient_treatment_other'] ?? 'NULL',
                'appointment_data_diseases_other_value' => $appointmentData['patient_disease_other'] ?? 'NULL',
            ]);

            $appointment = PatientAppointment::create($appointmentData);

            // Handle medical record creation based on doctor type
            if (Auth::user()->doctor_type === 'diabetes_treating') {
                // For diabetes treating doctors, create physician record directly
                \Log::info('Creating physician record for doctor type: ' . Auth::user()->doctor_type);
                \Log::info('Physician record data: ' . json_encode($request->input('physician_record')));

                $patientMedicalRecord = \App\Models\PatientMedicalRecord::create([
                    'patient_id' => $appointment->patient_id,
                    'appointment_id' => $appointment->id,
                    'record_type' => 'physician'
                ]);

                // Create physician record
                $physicianRecord = \App\Models\PhysicianMedicalRecord::create([
                    'patient_medical_record_id' => $patientMedicalRecord->id,
                    'type_of_diabetes' => $request->input('physician_record.type_of_diabetes'),
                    'family_history_diabetes' => $request->boolean('physician_record.family_history_diabetes'),
                    'current_treatment' => $request->input('physician_record.current_treatment'),
                    'current_treatment_other' => (function () use ($request) {
                        $currentTreatment = $request->input('physician_record.current_treatment', []);
                        $currentTreatmentOther = $request->input('physician_record.current_treatment_other');
                        if (is_array($currentTreatment) && in_array('others', $currentTreatment) && !empty($currentTreatmentOther)) {
                            return trim($currentTreatmentOther);
                        }
                        return null;
                    })(),
                    'compliance' => $request->input('physician_record.compliance'),
                    'blood_sugar_type' => $request->input('physician_record.blood_sugar_type'),
                    'blood_sugar_value' => $request->input('physician_record.blood_sugar_value'),
                    'other_data' => ($request->input('physician_record.other_data')) ? trim($request->input('physician_record.other_data')) : null,
                    'hypertension' => $request->boolean('physician_record.hypertension'),
                    'dyslipidemia' => $request->boolean('physician_record.dyslipidemia'),
                    'retinopathy' => ($request->input('physician_record.retinopathy')) ? trim($request->input('physician_record.retinopathy')) : null,
                    'neuropathy' => $request->input('physician_record.neuropathy'),
                    'nephropathy' => $request->input('physician_record.nephropathy'),
                    'cardiovascular' => $request->input('physician_record.cardiovascular'),
                    'foot_disease' => $request->input('physician_record.foot_disease'),
                    'others' => $request->input('physician_record.others', []),
                    'others_details' => ($request->input('physician_record.others_details')) ? trim($request->input('physician_record.others_details')) : null,
                    'hba1c_range' => $request->input('physician_record.hba1c_range')
                ]);

                \Log::info('Physician record created successfully with ID: ' . $physicianRecord->id);

                // Redirect to medical records page
                return redirect()->route('doctor.patients.medical-records', $appointment->patient_id)
                    ->with('success', 'Patient updated, appointment created, and medical record saved successfully.');
            } else {
                // For ophthalmologists, create the medical record directly
                \Log::info('Creating ophthalmologist record for doctor type: ' . Auth::user()->doctor_type);
                \Log::info('Ophthalmologist record data: ' . json_encode($request->input('ophthalmologist_record')));

                $patientMedicalRecord = \App\Models\PatientMedicalRecord::create([
                    'patient_id' => $appointment->patient_id,
                    'appointment_id' => $appointment->id,
                    'record_type' => 'ophthalmologist'
                ]);

                $dr = $request->input('ophthalmologist_record.diabetic_retinopathy');
                $dr_re = $request->input('ophthalmologist_record.diabetic_retinopathy_re');

                $dme = $request->input('ophthalmologist_record.diabetic_macular_edema');
                $dme_re = $request->input('ophthalmologist_record.diabetic_macular_edema_re');

                // Create ophthalmologist record
                $ophthalmologistRecord = \App\Models\OphthalmologistMedicalRecord::create([
                    'patient_medical_record_id' => $patientMedicalRecord->id,
                    'diabetic_retinopathy' => $request->input('ophthalmologist_record.diabetic_retinopathy'),
                    'diabetic_macular_edema' => $request->input('ophthalmologist_record.diabetic_macular_edema'),

                    'investigations' => $request->input('ophthalmologist_record.investigations'),
                    'investigations_others' => $request->input('ophthalmologist_record.investigations_others'),
                    'advised' => $request->input('ophthalmologist_record.advised'),
                    'treatment_done_date' => $request->input('ophthalmologist_record.treatment_done_date'),
                    'review_date' => $request->input('ophthalmologist_record.review_date'),
                    'other_remarks' => $request->input('ophthalmologist_record.other_remarks'),



                    'diabetic_retinopathy_re' => $request->input('ophthalmologist_record.diabetic_retinopathy_re') == '1' || $request->input('ophthalmologist_record.diabetic_retinopathy_re') === 1 || $request->input('ophthalmologist_record.diabetic_retinopathy_re') === true,



                    'diabetic_macular_edema_re' => $request->input('ophthalmologist_record.diabetic_macular_edema_re') == '1' || $request->input('ophthalmologist_record.diabetic_macular_edema_re') === 1 || $request->input('ophthalmologist_record.diabetic_macular_edema_re') === true,
                    'type_of_dr'     => $dr == '1' ? $request->input('ophthalmologist_record.type_of_dr') : null,
                    'type_of_dr_re'  => $dr_re == '1' ? $request->input('ophthalmologist_record.type_of_dr_re') : null,

                    // --------------------------------------------------------------------------------------
                    // DME TYPE: Only store value if YES (1), otherwise NULL
                    // --------------------------------------------------------------------------------------
                    'type_of_dme'    => $dme == '1' ? $request->input('ophthalmologist_record.type_of_dme') : null,
                    'type_of_dme_re' => $dme_re == '1' ? $request->input('ophthalmologist_record.type_of_dme_re') : null,


                    'ucva_re' => $request->input('ophthalmologist_record.ucva_re'),
                    'ucva_le' => $request->input('ophthalmologist_record.ucva_le'),
                    'bcva_re' => $request->input('ophthalmologist_record.bcva_re'),
                    'bcva_le' => $request->input('ophthalmologist_record.bcva_le'),
                    'anterior_segment_re' => $request->input('ophthalmologist_record.anterior_segment_re'),
                    'anterior_segment_le' => $request->input('ophthalmologist_record.anterior_segment_le'),
                    'iop_re' => $request->input('ophthalmologist_record.iop_re'),
                    'iop_le' => $request->input('ophthalmologist_record.iop_le'),


                    'advised_re' => $request->input('ophthalmologist_record.advised_re'),
                ]);

                \Log::info('Ophthalmologist record created successfully with ID: ' . $ophthalmologistRecord->id);

                // Redirect to medical records page
                return redirect()->route('doctor.patients.medical-records', $appointment->patient_id)
                    ->with('success', 'Patient updated, appointment created, and medical entry saved successfully.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update patient and create appointment. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show patient list for doctor - Shows only patients with whom the doctor has appointments
     */
    public function index(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        // Show only patients where the current doctor has appointments
        $query = Patient::query()
            ->whereHas('appointments', function ($appointmentQuery) {
                // Only show patients that have at least one appointment with current doctor
                $appointmentQuery->where('doctor_id', Auth::id());
            })
            ->with(['appointments' => function ($appointmentQuery) {
                // Only load appointments created by the current doctor
                $appointmentQuery->where('doctor_id', Auth::id());
            }]);

        // Apply filters as per Requirement.md
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%")
                    ->orWhere('sssp_id', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
        }

        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }

        // Last visit date range filter (based on appointments by current doctor)
        // if ($request->filled('last_visit_from')) {
        //     $query->whereHas('appointments', function ($appointmentQuery) use ($request) {
        //         $appointmentQuery->where('doctor_id', Auth::id())
        //             ->whereDate('visit_date_time', '>=', $request->last_visit_from);
        //     });
        // }

        // if ($request->filled('last_visit_to')) {
        //     $query->whereHas('appointments', function ($appointmentQuery) use ($request) {
        //         $appointmentQuery->where('doctor_id', Auth::id())
        //             ->whereDate('visit_date_time', '<=', $request->last_visit_to);
        //     });
        // }

        if ($request->filled('last_visit_date')) {
    $lastVisitDate = $request->last_visit_date;

    // Convert from d-m-Y to Y-m-d for database query
    try {
        $lastVisitDateDb = \Carbon\Carbon::createFromFormat('d-m-Y', $lastVisitDate)->format('Y-m-d');
    } catch (\Exception $e) {
        // Fallback if conversion fails
        $lastVisitDateDb = now()->format('Y-m-d');
    }
    
    $query->whereHas('appointments', function ($appointmentQuery) use ($lastVisitDateDb) {
        $appointmentQuery->where('doctor_id', Auth::id())
            ->whereDate('visit_date_time', $lastVisitDateDb);  // Exact date match
    });
}

        // Handle sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // Apply sorting based on column
        switch ($sortBy) {
            case 'name':
            case 'mobile_number':
            case 'sssp_id':
            case 'age':
            case 'sex':
                $query->orderBy($sortBy, $sortDirection);
                break;
            case 'last_visit':
                // For last visit, we need to use a subquery filtered by current doctor
                $query->orderBy(
                    \DB::table('patient_appointments')
                        ->select('visit_date_time')
                        ->whereColumn('patient_appointments.patient_id', 'patients.id')
                        ->where('doctor_id', Auth::id())
                        ->orderBy('visit_date_time', 'desc')
                        ->limit(1),
                    $sortDirection
                );
                break;
            case 'total_appointments':
                // For total appointments, count only appointments by current doctor
                $query->withCount(['appointments' => function ($appointmentQuery) {
                    $appointmentQuery->where('doctor_id', Auth::id());
                }])
                    ->orderBy('appointments_count', $sortDirection);
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $patients = $query->paginate(10)->appends($request->except('page'));

        return view('doctor.patients.index', [
            'title' => 'My Patients',
            'breadcrumb' => 'My Patients',
            'patients' => $patients
        ]);
    }

    /**
     * Show patient's medical records - Shows only appointments created by current doctor
     */
  public function showMedicalRecords($patientId, Request $request)
{
    $patient = Patient::findOrFail($patientId);

    $appointmentsQuery = $patient->appointments()
        ->where('doctor_id', Auth::id())
        ->with([
            'doctor',
            'medicalRecords.physicianRecord',
            'medicalRecords.ophthalmologistRecord'
        ]);

    // -------------------------
    // END VALIDATION
    // -------------------------

    // 🔍 Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $appointmentsQuery->where(function ($q) use ($search) {
            $q->where('visit_date_time', 'like', "%{$search}%")
                ->orWhere('appointment_type', 'like', "%{$search}%");
        });
    }

    // 🩺 Appointment type filter
    if ($request->filled('appointment_type')) {
        $appointmentsQuery->where('appointment_type', $request->appointment_type);
    }

   // 📅 Single Date Filtering
if ($request->filled('appointment_date')) {
    $appointmentDate = trim($request->appointment_date);
    
    // Convert from d-m-Y to Y-m-d for database query
    try {
        $appointmentDateDb = \Carbon\Carbon::createFromFormat('d-m-Y', $appointmentDate)->format('Y-m-d');
    } catch (\Exception $e) {
        // Fallback if conversion fails
        $appointmentDateDb = now()->format('Y-m-d');
    }
    
    // Filter by exact date
    $appointmentsQuery->whereDate('visit_date_time', $appointmentDateDb);
}

    // Sorting
    $sortBy = $request->get('sort_by', 'visit_date_time');
    $sortDirection = $request->get('sort_direction', 'desc');

    if (!in_array($sortDirection, ['asc', 'desc'])) {
        $sortDirection = 'desc';
    }

    switch ($sortBy) {
        case 'visit_date_time':
        case 'date':
            $appointmentsQuery->orderBy('visit_date_time', $sortDirection);
            break;
        default:
            $appointmentsQuery->orderBy('visit_date_time', 'desc');
    }

    $appointments = $appointmentsQuery->paginate(10);
    $appointments->appends($request->query());

    $latestAppointment = $patient->appointments()
        ->where('doctor_id', Auth::id())
        ->orderBy('visit_date_time', 'desc')
        ->first();

    $latestBmi = $latestAppointment ? $latestAppointment->patient_bmi_snapshot : null;

    $title = 'View Appointments - ' . $patient->name;

    return view('doctor.patients.medical-records', compact('patient', 'appointments', 'title', 'latestBmi'));
}

    /**
     * Show patient edit form - Any doctor can edit any patient
     */
    public function edit($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $title = 'Edit Patient - ' . $patient->name;

        return view('doctor.patients.edit', compact('patient', 'title'));
    }

    /**
     * Update patient - Any doctor can update any patient
     */
   public function update(Request $request, $patientId)
{
    $patient = Patient::findOrFail($patientId);

    // Base validation rules
    $validationRules = [
        'name' => 'required|string|max:255',
        'diabetes_from' => 'nullable|date_format:m-Y',
        'diabetes_years' => 'nullable|integer|min:0|max:100',
        'diabetes_months' => 'nullable|integer|min:0|max:11',
        'date_of_birth' => 'nullable|date|before:today',
        'age' => 'required|integer|min:0|max:150',
        'short_address' => 'required|string|max:500',
        'sex' => 'required|in:male,female,other',
        'hospital_id' => 'nullable|string|max:100',
        'on_treatment' => 'boolean',
        'type_of_treatment' => 'array|nullable',
        'type_of_treatment.*' => 'in:allopathic,diet_control,ayurvedic,others',
        'type_of_treatment_other' => in_array('others', $request->type_of_treatment ?? []) ? 'required|string|max:255' : 'nullable|string|max:255',
        'bp' => 'boolean',
        'bp_since' =>'nullable',
        'bp_years' => 'nullable|integer|min:0|max:100',
        'bp_months' => 'nullable|integer|min:0|max:11',
        'other_diseases' => 'array|nullable',
        'other_diseases.*' => 'in:heart_disease,cholesterol,thyroid,stroke,others',
        'other_diseases_other' => in_array('others', $request->other_diseases ?? []) ? 'required|string|max:255' : 'nullable|string|max:255',
        'other_input' => 'nullable|string|max:1000',
        'height_unit' => 'required|in:meter,feet',
        'weight' => 'nullable|numeric|min:1|max:500',
        'email' => 'nullable|email|max:255'
    ];

    // Add conditional validation for height based on unit
    if ($request->input('height_unit') === 'feet') {
        $validationRules['height'] = 'nullable|numeric|min:2|max:9.0'; // 2.0 to 9.0 feet
    } else {
        $validationRules['height'] = 'nullable|numeric|min:0.5|max:3.0'; // 0.5 to 3.0 meters
    }

    $validator = Validator::make($request->all(), $validationRules, [
        'date_of_birth.before' => 'Date of Birth must be before today.',
        'bp_years.required' => 'BP Years is required when BP is Yes.',
        'bp_months.required' => 'BP Months is required when BP is Yes.',
        'type_of_treatment_other.required' => 'Please specify other type of treatment.',
        'other_diseases_other.required' => 'Please specify other disease.',
        'height.min' => 'Height must be at least :min ' . ($request->input('height_unit') === 'feet' ? 'feet' : 'meters') . '.',
        'height.max' => 'Height cannot exceed :max ' . ($request->input('height_unit') === 'feet' ? 'feet' : 'meters') . '.',
    ]);


    // Then manually validate diabetes duration
    if (empty($request->diabetes_years) && empty($request->diabetes_months)) {
        return redirect()->back()
            ->withErrors([
                'diabetes_years' => 'Please enter either diabetes years or months.',
                'diabetes_months' => 'Please enter either diabetes years or months.'
            ])
            ->withInput();
    }

    // Validate BP duration if BP is checked
    if ($request->bp == '1') {
        if (empty($request->bp_years) && empty($request->bp_months)) {
            return redirect()->back()
                ->withErrors([
                    'bp_years' => 'Please enter either BP years or months.',
                    'bp_months' => 'Please enter either BP years or months.'
                ])
                ->withInput();
        }
    }

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }




    try {
         // Handle date format conversions
        $diabetesFrom = null;
        if ($request->filled('diabetes_from')) {
            try {
                $diabetesFrom = \Carbon\Carbon::createFromFormat('m-Y', $request->diabetes_from)->format('Y-m-01');
            } catch (\Exception $e) {
                \Log::error('Error parsing diabetes_from: ' . $request->diabetes_from . ' - ' . $e->getMessage());
                $diabetesFrom = null;
            }
        }

        $bpSince = null;
        if ($request->filled('bp_since')) {
            try {
                $bpSince = \Carbon\Carbon::createFromFormat('m-Y', $request->bp_since)->format('Y-m-01');
            } catch (\Exception $e) {
                \Log::error('Error parsing bp_since: ' . $request->bp_since . ' - ' . $e->getMessage());
                $bpSince = null;
            }
        }

        $dateOfBirth = null;
        if ($request->filled('date_of_birth')) {
            try {
                $dateOfBirth = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
            } catch (\Exception $e) {
                \Log::error('Error parsing date_of_birth: ' . $request->date_of_birth . ' - ' . $e->getMessage());
                $dateOfBirth = null;
            }
        }
        // Handle height and BMI calculation - SAME METHOD as storeAppointmentExistingStep1
        $height = $request->filled('height') ? (float) $request->height : null;
        $heightUnit = $request->input('height_unit', 'meter');
        $weight = $request->filled('weight') ? (float) $request->weight : null;

        // Calculate BMI using the SAME method as JavaScript and storeAppointmentExistingStep1
        $bmi = null;
        if ($height !== null && $weight !== null && $height > 0 && $weight > 0) {
            // Convert height to meters for BMI calculation if needed (same as JavaScript)
            $heightInMeters = $heightUnit === 'feet' ? $height * 0.3048 : $height;
            $bmi = round($weight / ($heightInMeters * $heightInMeters), 2);
        }

        // Normalize arrays
        $typeOfTreatment = $request->input('type_of_treatment', []);
        if (!is_array($typeOfTreatment)) {
            $typeOfTreatment = [];
        }

        $otherDiseases = $request->input('other_diseases', []);
        if (!is_array($otherDiseases)) {
            $otherDiseases = [];
        }

        // Process "other" fields
        $typeOfTreatmentOther = $request->filled('type_of_treatment_other') ? trim($request->type_of_treatment_other) : null;
        $otherDiseasesOther = $request->filled('other_diseases_other') ? trim($request->other_diseases_other) : null;

        // Prepare patient update data with BMI calculation
        $updateData = [
            'name' => $request->name,
             'diabetes_from' => $diabetesFrom, // ADD THIS - was missing
            'date_of_birth' => $dateOfBirth,
            'age' => $request->age,
            'short_address' => $request->short_address,
            'sex' => $request->sex,
            'hospital_id' => $request->hospital_id,
            'on_treatment' => $request->on_treatment,
            'type_of_treatment' => $typeOfTreatment,
            'type_of_treatment_other' => $typeOfTreatmentOther,
            'bp' => $request->bp,
            'other_diseases' => $otherDiseases,
            'other_diseases_other' => $otherDiseasesOther,
            'other_input' => $request->other_input,
            'email' => $request->email,
            'height' => $height,
            'height_unit' => $heightUnit,
            'weight' => $weight,
            'bmi' => $bmi,
            'diabetes_years' => $request->diabetes_years, // ADD THIS
            'diabetes_months' => $request->diabetes_months, // ADD THIS
            'bp_years' => $request->bp_years, // Add BP fields
            'bp_months'=> $request->bp_months, // Add BP fields // Store the calculated BMI
            'bp_since' => $bpSince
        ];


        // Log for debugging
        \Log::info('PATIENT UPDATE - BMI CALCULATION:', [
            'patient_id' => $patientId,
            'height_input' => $height,
            'height_unit' => $heightUnit,
            'weight_input' => $weight,
            'bmi_calculated' => $bmi,
            'calculation' => $height !== null && $weight !== null ?
                "BMI = $weight / (" . ($heightUnit === 'feet' ? $height * 0.3048 : $height) . " * " . ($heightUnit === 'feet' ? $height * 0.3048 : $height) . ")" :
                'No BMI calculation - missing height or weight'
        ]);

        $patient->update($updateData);

        return redirect()->route('doctor.patients.index')
            ->with('success', 'Patient updated successfully!');
    } catch (\Exception $e) {
        \Log::error('Failed to update patient: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return redirect()->back()
            ->with('error', 'Failed to update patient. Please try again.')
            ->withInput();
    }
}
    /**
     * Show edit appointment form
     */
    public function editAppointment($appointmentId)
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        $appointment = PatientAppointment::with([
            'patient',
            'medicalRecords.physicianRecord',
            'medicalRecords.ophthalmologistRecord'
        ])
            ->where('doctor_id', Auth::id())
            ->findOrFail($appointmentId);

        return view('doctor.patients.edit-appointment', [
            'title' => 'Edit Appointment',
            'breadcrumb' => 'Edit Appointment',
            'appointment' => $appointment
        ]);
    }

    /**
     * Update appointment
     */
    public function updateAppointment(Request $request, $appointmentId)
{
    
    if (!Auth::check() || !Auth::user()->isDoctor()) {
        return redirect('/doctor/login');
    }

    $appointment = PatientAppointment::with(['medicalRecords.physicianRecord', 'medicalRecords.ophthalmologistRecord', 'patient'])
        ->where('doctor_id', Auth::id())
        ->findOrFail($appointmentId);

    // Normalize checkbox inputs - ensure arrays are always present
    if (Auth::user()->doctor_type === 'diabetes_treating') {
        $physicianRecord = $request->input('physician_record', []);
        $needsMerge = false;

        // Ensure current_treatment is always an array
        if (
            !isset($physicianRecord['current_treatment']) ||
            !is_array($physicianRecord['current_treatment'])
        ) {
            $physicianRecord['current_treatment'] = [];
            $needsMerge = true;
        }

        // Ensure others is always an array
        if (!isset($physicianRecord['others']) || !is_array($physicianRecord['others'])) {
            $physicianRecord['others'] = [];
            $needsMerge = true;
        }

        // Merge back to request only if we made changes
        if ($needsMerge) {
            $request->merge(['physician_record' => $physicianRecord]);
        }
    }

    // Base validation rules
    $validationRules = [
        'visit_date_time' => 'required|date',
        'appointment_type' => 'required|in:new,follow_up',
        // Patient profile fields
        'name' => 'required|string|max:255',
        'diabetes_from' => 'nullable|date_format:Y-m',
        'diabetes_years' => 'required|integer|min:0|max:100',
        'diabetes_months' => 'required|integer|min:0|max:11',
        'date_of_birth' => 'nullable|date|before:today',
        'age' => 'required|integer|min:0|max:150',
        'short_address' => 'required|string|max:500',
        'sex' => 'required|in:male,female,other',
        'hospital_id' => 'nullable|string|max:100',
        'on_treatment' => 'boolean',
        'type_of_treatment' => 'array|nullable',
        'type_of_treatment.*' => 'in:allopathic,diet_control,ayurvedic,others',
        'type_of_treatment_other' => in_array('others', $request->type_of_treatment ?? []) ? 'required|string|max:255' : 'nullable|string|max:255',
        'bp' => 'boolean',
        'bp_since' => $request->bp == '1' ? 'nullable' : 'nullable',
        'bp_years' => $request->bp == '1' ? 'required|integer|min:0|max:100' : 'nullable|integer|min:0|max:100',
        'bp_months' => $request->bp == '1' ? 'required|integer|min:0|max:11' : 'nullable|integer|min:0|max:11',
        'other_diseases' => 'array|nullable',
        'other_diseases.*' => 'in:heart_disease,cholesterol,thyroid,stroke,others',
        'other_diseases_other' => in_array('others', $request->other_diseases ?? []) ? 'required|string|max:255' : 'nullable|string|max:255',
        'other_input' => 'nullable|string|max:1000',
        'height_unit' => 'required|in:meter,feet',
        'weight' => 'nullable|numeric|min:1|max:500',
        'email' => 'nullable|email|max:255',
        // Physician record validation
        'physician_record.type_of_diabetes' => 'nullable|in:type1,type2,other',
        'physician_record.family_history_diabetes' => 'nullable|boolean',
        'physician_record.compliance' => 'nullable|in:good,irregular,poor',
        'physician_record.blood_sugar_type' => 'nullable|in:rbs,fbs,ppbs,hba1c',
        'physician_record.blood_sugar_value' => 'nullable|numeric|min:0|max:1000',
        'physician_record.current_treatment' => 'nullable|array',
        'physician_record.current_treatment.*' => 'in:lifestyle,oha,insulin,glp1,ayurvedic_homeopathy,others',
        'physician_record.current_treatment_other' => 'nullable|string|max:500',
        'physician_record.other_data' => 'nullable|string|max:1000',
        'physician_record.hypertension' => 'boolean',
        'physician_record.dyslipidemia' => 'boolean',
        'physician_record.retinopathy' => 'nullable|string|max:1000',
        'physician_record.neuropathy' => 'nullable|in:peripheral,autonomic,no',
        'physician_record.nephropathy' => 'nullable|in:no,microalbuminuria,proteinuria,ckd,on_dialysis',
        'physician_record.cardiovascular' => 'nullable|in:no,ihd,stroke,pvd',
        'physician_record.foot_disease' => 'nullable|in:no,ulcer,gangrene,deformity',
        'physician_record.others' => 'array',
        'physician_record.others.*' => 'in:infections,dental_problems,erectile_dysfunction,other',
        'physician_record.others_details' => 'nullable|string|max:1000',
        'physician_record.hba1c_range' => 'nullable|in:less_than_7,7_to_9,greater_than_9',
        // Ophthalmologist record validation
        'ophthalmologist_record.diabetic_retinopathy' => 'required|boolean',
        'ophthalmologist_record.diabetic_macular_edema' => 'required|boolean',
        'ophthalmologist_record.diabetic_retinopathy_re' => 'required|boolean',
        'ophthalmologist_record.diabetic_macular_edema_re' => 'required|boolean',

        // DR TYPE LE
        'ophthalmologist_record.type_of_dr' => [
            Rule::requiredIf(function () use ($request) {
                return $request->ophthalmologist_record['diabetic_retinopathy'] == '1';
            }),
            'nullable',
            Rule::in([
                'npdr_mild',
                'npdr_moderate',
                'npdr_severe',
                'npdr_very_severe',
                'pdr_non_high_risk',
                'pdr_high_risk'
            ]),
        ],

        // DR TYPE RE
        'ophthalmologist_record.type_of_dr_re' => [
            Rule::requiredIf(function () use ($request) {
                return $request->ophthalmologist_record['diabetic_retinopathy_re'] == '1';
            }),
            'nullable',
            Rule::in([
                'npdr_mild',
                'npdr_moderate',
                'npdr_severe',
                'npdr_very_severe',
                'pdr_non_high_risk',
                'pdr_high_risk'
            ]),
        ],

        // DME TYPE LE
        'ophthalmologist_record.type_of_dme' => [
            Rule::requiredIf(function () use ($request) {
                return $request->ophthalmologist_record['diabetic_macular_edema'] == '1';
            }),
            'nullable',
            Rule::in(['nil_absent', 'present', 'mild', 'moderate', 'severe']),
        ],

        // DME TYPE RE
        'ophthalmologist_record.type_of_dme_re' => [
            Rule::requiredIf(function () use ($request) {
                return $request->ophthalmologist_record['diabetic_macular_edema_re'] == '1';
            }),
            'nullable',
            Rule::in(['nil_absent', 'present', 'mild', 'moderate', 'severe']),
        ],

        'ophthalmologist_record.investigations' => 'nullable|array',
        'ophthalmologist_record.investigations_others' => 'nullable|string|max:255',
        'ophthalmologist_record.advised' => 'nullable|in:no_treatment,close_watch,drops,medications,focal_laser,prp_laser,intravit_inj,steroid,surgery',
        'ophthalmologist_record.treatment_done_date' => 'nullable|date',
        'ophthalmologist_record.review_date' => 'nullable|date',
        'ophthalmologist_record.other_remarks' => 'nullable|string|max:1000'
    ];

    // Add conditional validation for height based on unit
    if ($request->input('height_unit') === 'feet') {
        $validationRules['height'] = 'nullable|numeric|min:2|max:9.0'; // 2.0 to 9.0 feet
    } else {
        $validationRules['height'] = 'nullable|numeric|min:0.5|max:3.0'; // 0.5 to 3.0 meters
    }

    $validator = Validator::make($request->all(), $validationRules, [
        'date_of_birth.before' => 'Date of Birth must be before today.',
        'bp_years.required' => 'BP Years is required when BP is Yes.',
        'bp_months.required' => 'BP Months is required when BP is Yes.',
        'type_of_treatment_other.required' => 'Please specify other type of treatment.',
        'other_diseases_other.required' => 'Please specify other disease.',
        'height.min' => 'Height must be at least :min ' . ($request->input('height_unit') === 'feet' ? 'feet' : 'meters') . '.',
        'height.max' => 'Height cannot exceed :max ' . ($request->input('height_unit') === 'feet' ? 'feet' : 'meters') . '.',
        'physician_record.current_treatment_other.required' => 'Specify Other Treatment is required.',
        'physician_record.current_treatment_other.string' => 'Specify Other Treatment must be a valid text.',
        'physician_record.current_treatment_other.max' => 'Specify Other Treatment may not be greater than 500 characters.',
    ]);

    // Add conditional validation for current_treatment_other
    $validator->sometimes('physician_record.current_treatment_other', 'required|string|max:500', function ($input) use ($request) {
        $currentTreatment = $request->input('physician_record.current_treatment', []);
        if (!is_array($currentTreatment)) {
            $currentTreatment = [];
        }
        return in_array('others', $currentTreatment);
    });

    // Add conditional validation for investigations_others
    $validator->sometimes('ophthalmologist_record.investigations_others', 'required|string|max:255', function ($input) use ($request) {
        $investigations = $request->input('ophthalmologist_record.investigations', []);
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
        // Handle height and BMI calculation
        $height = $request->filled('height') ? (float) $request->height : null;
        $heightUnit = $request->input('height_unit', 'meter');
        $weight = $request->filled('weight') ? (float) $request->weight : null;

        // Calculate BMI using the SAME method as JavaScript
        $bmi = null;
        if ($height !== null && $weight !== null && $height > 0 && $weight > 0) {
            // Convert height to meters for BMI calculation if needed (same as JavaScript)
            $heightInMeters = $heightUnit === 'feet' ? $height * 0.3048 : $height;
            $bmi = round($weight / ($heightInMeters * $heightInMeters), 2);
        }


        // Update the actual patient record
        if ($appointment->patient) {
            $patientData = [
                'name' => $request->input('name'),
                'diabetes_from' => $request->input('diabetes_from') ? $request->input('diabetes_from') . '-01' : null,
                'date_of_birth' => $request->input('date_of_birth'),
                'age' => $request->input('age'),
                'short_address' => $request->input('short_address'),
                'sex' => $request->input('sex'),
                'hospital_id' => $request->input('hospital_id'),
                'on_treatment' => $request->input('on_treatment'),
                'type_of_treatment' => $request->input('type_of_treatment', []),
                'treatment_other' => $request->input('type_of_treatment_other'),
                'bp' => $request->input('bp'),
                'bp_since' => $request->input('bp_since') ? $request->input('bp_since') . '-01' : null,
                'other_diseases' => $request->input('other_diseases', []),
                'disease_other' => $request->input('other_diseases_other'),
                'other_input' => $request->input('other_input'),
                'height' => $height,
                'height_unit' => $heightUnit, // This was missing - now saving to patient table
                'weight' => $weight,
                'bmi' => $bmi,
                'email' => $request->input('email'),
            ];

            $appointment->patient->update($patientData);
        }

        // Update appointment with patient details snapshot - USE THE SAME BMI
        $appointmentData = [
            'visit_date_time' => $request->visit_date_time,
            'appointment_type' => $request->appointment_type,
            // Store patient details snapshot
            'patient_name' => $request->input('name'),
            'patient_diabetes_from' => $request->input('diabetes_from') ? $request->input('diabetes_from') . '-01' : null,
            'patient_date_of_birth' => $request->input('date_of_birth'),
            'patient_age' => $request->input('age'),
            'patient_short_address' => $request->input('short_address'),
            'patient_sex' => $request->input('sex'),
            'patient_hospital_id' => $request->input('hospital_id'),
            'patient_on_treatment' => $request->input('on_treatment'),
            'patient_type_of_treatment' => $request->input('type_of_treatment', []),
            'patient_treatment_other' => $request->input('type_of_treatment_other'),
            'patient_bp' => $request->input('bp'),
            'patient_bp_since' => $request->input('bp_since') ? $request->input('bp_since') . '-01' : null,
            'patient_other_diseases' => $request->input('other_diseases', []),
            'patient_disease_other' => $request->input('other_diseases_other'),
            'patient_other_input' => $request->input('other_input'),
            'patient_height' => $height,
            'patient_height_unit' => $heightUnit, // Make sure this is also in snapshot
            'patient_weight' => $weight,
            'patient_bmi' => $bmi, // Store the SAME BMI
            'patient_email' => $request->input('email'),
            'patient_mobile_number' => $request->input('mobile_number'),
            'patient_sssp_id' => $request->input('sssp_id') ?? $appointment->patient_sssp_id,
        ];


        $appointment->update($appointmentData);

        // Log for debugging
        \Log::info('APPOINTMENT UPDATE - BMI CALCULATION:', [
            'appointment_id' => $appointmentId,
            'height_input' => $height,
            'height_unit' => $heightUnit,
            'weight_input' => $weight,
            'bmi_calculated' => $bmi,
            'calculation' => $height !== null && $weight !== null ?
                "BMI = $weight / (" . ($heightUnit === 'feet' ? $height * 0.3048 : $height) . " * " . ($heightUnit === 'feet' ? $height * 0.3048 : $height) . ")" :
                'No BMI calculation - missing height or weight'
        ]);

        // Handle physician record
        if ($request->has('physician_record') && Auth::user()->doctor_type === 'diabetes_treating') {
            $patientMedicalRecord = $appointment->medicalRecords->where('record_type', 'physician')->first();

            if (!$patientMedicalRecord) {
                // Create new patient medical record
                $patientMedicalRecord = \App\Models\PatientMedicalRecord::create([
                    'patient_id' => $appointment->patient_id,
                    'appointment_id' => $appointment->id,
                    'record_type' => 'physician'
                ]);
            }

            $physicianRecord = $patientMedicalRecord->physicianRecord;
            if (!$physicianRecord) {
                // Create new physician record
                $physicianRecord = \App\Models\PhysicianMedicalRecord::create([
                    'patient_medical_record_id' => $patientMedicalRecord->id
                ]);
            }

            // Get current_treatment from request - use normalized value from earlier normalization
            // The normalization already ensures it's an array, so use that
            $currentTreatment = $request->input('physician_record.current_treatment');
            if (!is_array($currentTreatment)) {
                $currentTreatment = [];
            }

            $updateData = [
                'type_of_diabetes' => $request->input('physician_record.type_of_diabetes'),
                'family_history_diabetes' => $request->boolean('physician_record.family_history_diabetes'),
                'compliance' => $request->input('physician_record.compliance'),
                'blood_sugar_type' => $request->input('physician_record.blood_sugar_type'),
                'blood_sugar_value' => $request->input('physician_record.blood_sugar_value'),
                'current_treatment' => $currentTreatment,
                'other_data' => ($request->input('physician_record.other_data')) ? trim($request->input('physician_record.other_data')) : null,
                'hypertension' => $request->boolean('physician_record.hypertension'),
                'dyslipidemia' => $request->boolean('physician_record.dyslipidemia'),
                'retinopathy' => ($request->input('physician_record.retinopathy')) ? trim($request->input('physician_record.retinopathy')) : null,
                'neuropathy' => $request->input('physician_record.neuropathy'),
                'nephropathy' => $request->input('physician_record.nephropathy'),
                'cardiovascular' => $request->input('physician_record.cardiovascular'),
                'foot_disease' => $request->input('physician_record.foot_disease'),
                'others' => $request->input('physician_record.others', []),
                'others_details' => ($request->input('physician_record.others_details')) ? trim($request->input('physician_record.others_details')) : null,
                'hba1c_range' => $request->input('physician_record.hba1c_range')
            ];

            // Handle current_treatment_other with proper trimming
            // Only save if "others" is selected in current_treatment AND value is provided
            $currentTreatmentOther = $request->input('physician_record.current_treatment_other');
            if (is_array($currentTreatment) && in_array('others', $currentTreatment) && !empty($currentTreatmentOther) && trim($currentTreatmentOther) !== '') {
                $updateData['current_treatment_other'] = trim($currentTreatmentOther);
            } else {
                // Clear if others is not selected or value is empty
                $updateData['current_treatment_other'] = null;
            }

            $physicianRecord->update($updateData);
            // Refresh to ensure we have the latest data
            $physicianRecord->refresh();
        }

        // Handle ophthalmologist record
        if ($request->has('ophthalmologist_record') && Auth::user()->doctor_type === 'ophthalmologist') {
            $patientMedicalRecord = $appointment->medicalRecords->where('record_type', 'ophthalmologist')->first();

            if (!$patientMedicalRecord) {
                // Create new patient medical record
                $patientMedicalRecord = \App\Models\PatientMedicalRecord::create([
                    'patient_id' => $appointment->patient_id,
                    'appointment_id' => $appointment->id,
                    'record_type' => 'ophthalmologist'
                ]);
            }

            $ophthalmologistRecord = $patientMedicalRecord->ophthalmologistRecord;
            if (!$ophthalmologistRecord) {
                // Create new ophthalmologist record
                $ophthalmologistRecord = \App\Models\OphthalmologistMedicalRecord::create([
                    'patient_medical_record_id' => $patientMedicalRecord->id
                ]);
            }
            $dr = $request->input('ophthalmologist_record.diabetic_retinopathy');
            $dr_re = $request->input('ophthalmologist_record.diabetic_retinopathy_re');

            $dme = $request->input('ophthalmologist_record.diabetic_macular_edema');
            $dme_re = $request->input('ophthalmologist_record.diabetic_macular_edema_re');

            $ophthalmologistRecord->update([
                'diabetic_retinopathy' => $request->boolean('ophthalmologist_record.diabetic_retinopathy'),
                'diabetic_macular_edema' => $request->boolean('ophthalmologist_record.diabetic_macular_edema'),

                'investigations' => $request->input('ophthalmologist_record.investigations'),
                'investigations_others' => $request->input('ophthalmologist_record.investigations_others'),
                'advised' => $request->input('ophthalmologist_record.advised'),
                'treatment_done_date' => $request->input('ophthalmologist_record.treatment_done_date') ?: null,
                'review_date' => $request->input('ophthalmologist_record.review_date') ?: null,
                'other_remarks' => $request->input('ophthalmologist_record.other_remarks') ? trim($request->input('ophthalmologist_record.other_remarks')) : null,

                'diabetic_retinopathy_re' => $request->input('ophthalmologist_record.diabetic_retinopathy_re') == '1' || $request->input('ophthalmologist_record.diabetic_retinopathy_re') === 1 || $request->input('ophthalmologist_record.diabetic_retinopathy_re') === true,

                'diabetic_macular_edema_re' => $request->input('ophthalmologist_record.diabetic_macular_edema_re') == '1' || $request->input('ophthalmologist_record.diabetic_macular_edema_re') === 1 || $request->input('ophthalmologist_record.diabetic_macular_edema_re') === true,

                'type_of_dr'     => $dr == '1' ? $request->input('ophthalmologist_record.type_of_dr') : null,
                'type_of_dr_re'  => $dr_re == '1' ? $request->input('ophthalmologist_record.type_of_dr_re') : null,

                // --------------------------------------------------------------------------------------
                // DME TYPE: Only store value if YES (1), otherwise NULL
                // --------------------------------------------------------------------------------------
                'type_of_dme'    => $dme == '1' ? $request->input('ophthalmologist_record.type_of_dme') : null,
                'type_of_dme_re' => $dme_re == '1' ? $request->input('ophthalmologist_record.type_of_dme_re') : null,

                'ucva_re' => $request->input('ophthalmologist_record.ucva_re'),
                'ucva_le' => $request->input('ophthalmologist_record.ucva_le'),
                'bcva_re' => $request->input('ophthalmologist_record.bcva_re'),
                'bcva_le' => $request->input('ophthalmologist_record.bcva_le'),
                'anterior_segment_re' => $request->input('ophthalmologist_record.anterior_segment_re'),
                'anterior_segment_le' => $request->input('ophthalmologist_record.anterior_segment_le'),
                'iop_re' => $request->input('ophthalmologist_record.iop_re'),
                'iop_le' => $request->input('ophthalmologist_record.iop_le'),
                'advised_re' => $request->input('ophthalmologist_record.advised_re'),
            ]);
        }

        return redirect()->route('doctor.patients.medical-records', $appointment->patient_id)
            ->with('success', 'Appointment details updated successfully.');
    } catch (\Exception $e) {
        \Log::error('Failed to update appointment: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return redirect()->back()
            ->with('error', 'Failed to update appointment. Please try again.')
            ->withInput();
    }
}

    /**
     * Delete appointment
     */
    public function deleteAppointment($appointmentId)
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        $appointment = PatientAppointment::where('doctor_id', Auth::id())
            ->findOrFail($appointmentId);

        try {
            $patientId = $appointment->patient_id;
            $appointment->delete();

            return redirect()->route('doctor.patients.medical-records', $patientId)
                ->withFragment('appointments-section')
                ->with('success', 'Appointment deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withFragment('appointments-section')
                ->with('error', 'Failed to delete appointment. Please try again.');
        }
    }

    /**
     * Delete patient - Only deletes if no other doctors have appointments with this patient
     */


   public function destroy($id){

   
    $patient = Patient::where('id', $id)
        ->where('created_by_doctor_id', Auth::id())
        ->firstOrFail();

    try {
        DB::transaction(function () use ($patient) {
            // Check if other doctors have appointments with this patient
            $hasOtherDoctorAppointments = PatientAppointment::where('patient_id', $patient->id)
                ->where('doctor_id', '!=', Auth::id())
                ->exists();

            if ($hasOtherDoctorAppointments) {
                // Only remove current doctor's appointments
                PatientAppointment::where('patient_id', $patient->id)
                    ->where('doctor_id', Auth::id())
                    ->delete();

                session()->flash('warning', 'Patient has appointments with other doctors. Only your appointments were deleted.');
            } else {
                // Safe to delete entire patient + all data
                $patient->delete(); // This triggers boot::deleting → deletes everything
                session()->flash('success', 'Patient and all associated records deleted successfully!');
            }
        });

        return redirect()->route('doctor.patients.index');

    } catch (\Exception $e) {
        \Log::error('Patient Delete Failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to delete patient. Please try again.');
    }

   }
public function deletePatient($patientId)
{
    

    $patient = Patient::where('id', $patientId)
        ->where('created_by_doctor_id', Auth::id())
        ->firstOrFail();

    try {
        DB::transaction(function () use ($patient) {
            // Check if other doctors have appointments with this patient
            $hasOtherDoctorAppointments = PatientAppointment::where('patient_id', $patient->id)
                ->where('doctor_id', '!=', Auth::id())
                ->exists();

            if ($hasOtherDoctorAppointments) {
                // Only remove current doctor's appointments
                PatientAppointment::where('patient_id', $patient->id)
                    ->where('doctor_id', Auth::id())
                    ->delete();

                session()->flash('warning', 'Patient has appointments with other doctors. Only your appointments were deleted.');
            } else {
                // Safe to delete entire patient + all data
                $patient->delete(); // This triggers boot::deleting → deletes everything
                session()->flash('success', 'Patient and all associated records deleted successfully!');
            }
        });

        return redirect()->route('doctor.patients.index');

    } catch (\Exception $e) {
        \Log::error('Patient Delete Failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to delete patient. Please try again.');
    }
}

    /**
     * Update appointment with patient information
     */
    public function updateAppointmentWithPatient(Request $request, $appointmentId)
{
    if (!Auth::check() || !Auth::user()->isDoctor()) {
        return redirect('/doctor/login');
    }

  $validator = Validator::make($request->all(), [
    'diabetes_from' => 'nullable|date_format:m-Y',
    'diabetes_years' => 'nullable|integer|min:0|max:100',
    'diabetes_months' => 'nullable|integer|min:0|max:11',
    'bp_since' => 'nullable',
    'bp_years' => 'nullable|integer|min:0|max:100',
    'bp_months' => 'nullable|integer|min:0|max:11',
    'on_treatment' => 'boolean',
    'type_of_treatment' => 'array|nullable',
    'type_of_treatment.*' => 'in:allopathic,diet_control,ayurvedic,others',
    'type_of_treatment_other' => in_array('others', $request->type_of_treatment ?? []) ? 'required|string|max:255' : 'nullable|string|max:255',
    'other_diseases' => 'array|nullable',
    'other_diseases.*' => 'in:heart_disease,cholesterol,thyroid,stroke,others',
    'other_diseases_other' => in_array('others', $request->other_diseases ?? []) ? 'required|string|max:255' : 'nullable|string|max:255',
    
    // PHYSICIAN VALIDATION - Conditionally add these rules
     // ADD THIS MISSING VALIDATION
    'physician_record.type_of_diabetes' => $request->has('physician_record.type_of_diabetes') ? 'required|in:type1,type2,other' : 'nullable',
    'physician_record.current_treatment' => $request->has('physician_record.type_of_diabetes') ? 'required|array|min:1' : 'nullable|array',
    'physician_record.current_treatment.*' => $request->has('physician_record.type_of_diabetes') ? 'in:lifestyle,oha,insulin,glp1,ayurvedic_homeopathy,others' : 'nullable',
   // FIXED: Proper validation for current_treatment_other
'physician_record.current_treatment_other' => [
    'nullable',
    'string',
    'max:500',
    function ($attribute, $value, $fail) use ($request) {
        if ($request->has('physician_record.type_of_diabetes')) {
            $currentTreatment = $request->input('physician_record.current_treatment', []);
            if (in_array('others', $currentTreatment) && empty(trim($value ?? ''))) {
                $fail('Please specify the other current treatment.');
            }
        }
    },
],
     // ADD THIS MISSING VALIDATION RULE FOR OTHERS_DETAILS
    'physician_record.others_details' => function ($attribute, $value, $fail) use ($request) {
        if ($request->has('physician_record.type_of_diabetes')) {
            $others = $request->input('physician_record.others', []);
            if (is_array($others) && in_array('other', $others) && empty(trim($value ?? ''))) {
                $fail('Please specify the other details.');
            }
        }
    },
    // Add these validation rules to your existing ophthalmologist validation section
'ophthalmologist_record.type_of_dr' => [
    Rule::requiredIf(function () use ($request) {
        $ophthalmologistRecord = $request->input('ophthalmologist_record', []);
        return isset($ophthalmologistRecord['diabetic_retinopathy']) && 
               $ophthalmologistRecord['diabetic_retinopathy'] == '1';
    }),
    'nullable',
    Rule::in([
        'npdr_mild',
        'npdr_moderate',
        'npdr_severe',
        'npdr_very_severe',
        'pdr_non_high_risk',
        'pdr_high_risk'
    ]),
],

'ophthalmologist_record.type_of_dr_re' => [
    Rule::requiredIf(function () use ($request) {
        $ophthalmologistRecord = $request->input('ophthalmologist_record', []);
        return isset($ophthalmologistRecord['diabetic_retinopathy_re']) && 
               $ophthalmologistRecord['diabetic_retinopathy_re'] == '1';
    }),
    'nullable',
    Rule::in([
        'npdr_mild',
        'npdr_moderate',
        'npdr_severe',
        'npdr_very_severe',
        'pdr_non_high_risk',
        'pdr_high_risk'
    ]),
],

'ophthalmologist_record.type_of_dme' => [
    Rule::requiredIf(function () use ($request) {
        $ophthalmologistRecord = $request->input('ophthalmologist_record', []);
        return isset($ophthalmologistRecord['diabetic_macular_edema']) && 
               $ophthalmologistRecord['diabetic_macular_edema'] == '1';
    }),
    'nullable',
    Rule::in(['nil_absent', 'present', 'mild', 'moderate', 'severe']),
],

'ophthalmologist_record.type_of_dme_re' => [
    Rule::requiredIf(function () use ($request) {
        $ophthalmologistRecord = $request->input('ophthalmologist_record', []);
        return isset($ophthalmologistRecord['diabetic_macular_edema_re']) && 
               $ophthalmologistRecord['diabetic_macular_edema_re'] == '1';
    }),
    'nullable',
    Rule::in(['nil_absent', 'present', 'mild', 'moderate', 'severe']),
],
],[
     // ✅ ADD CUSTOM ERROR MESSAGES HERE
    'type_of_treatment_other.required' => 'Please specify the other treatment type.',
    'other_diseases_other.required' => 'Please specify the other disease.',
     // ADD THIS CUSTOM ERROR MESSAGE
    'physician_record.others_details' => 'Please specify the other details.',
     // ADD THIS CUSTOM ERROR MESSAGE FOR CURRENT TREATMENT OTHER
      'physician_record.current_treatment.required' => 'Please select at least one Current Treatment option.',
    'physician_record.current_treatment_other' => 'Please specify the other current treatment.',
     'physician_record.current_treatment.min' => 'Please select at least one Current Treatment option.',
    'physician_record.type_of_diabetes.required' => 'Please select Type of Diabetes.',
    'physician_record.type_of_diabetes.in' => 'Please select a valid Type of Diabetes.',
]);

// ADD ATTRIBUTE NAMES HERE
$attributeNames = [
    'ophthalmologist_record.diabetic_retinopathy' => 'Diabetic Retinopathy (DR) LE',
    'ophthalmologist_record.diabetic_macular_edema' => 'Diabetic Macular Edema (DME) LE',
    'ophthalmologist_record.diabetic_retinopathy_re' => 'Diabetic Retinopathy (DR) RE',
    'ophthalmologist_record.diabetic_macular_edema_re' => 'Diabetic Macular Edema (DME) RE',
    'ophthalmologist_record.type_of_dr' => 'Type of DR',
    'ophthalmologist_record.type_of_dr_re' => 'Type of DR RE',
    'ophthalmologist_record.type_of_dme' => 'Type of DME',
    'ophthalmologist_record.type_of_dme_re' => 'Type of DME RE',
    
    // Add existing attribute names if you have any
    'type_of_treatment_other' => 'Specify Other Treatment',
    'other_diseases_other' => 'Specify Other Disease',
    // ADD THIS ATTRIBUTE NAME
     // ADD THIS ATTRIBUTE NAME
    'physician_record.current_treatment_other' => 'Specify Other Treatment',
    'physician_record.others_details' => 'Other Details',
];


// Set the custom attribute names
$validator->setAttributeNames($attributeNames);
     
    $validator->after(function ($validator) use ($request) {
        // Validate diabetes duration
        if (empty($request->diabetes_years) && empty($request->diabetes_months)) {
            $validator->errors()->add(
                'diabetes_years',
                'Please enter either diabetes years or months.'
            );
            $validator->errors()->add(
                'diabetes_months',
                'Please enter either diabetes years or months.'
            );
        }

        // Validate BP duration if BP is checked
        if ($request->bp == '1') {
            if (empty($request->bp_years) && empty($request->bp_months)) {
                $validator->errors()->add(
                    'bp_years',
                    'Please enter either BP years or months.'
                );
                $validator->errors()->add(
                    'bp_months',
                    'Please enter either BP years or months.'
                );
            }
        }
    });
      
    if ($validator->fails()) {
      
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    

    $appointment = PatientAppointment::where('doctor_id', Auth::id())
        ->findOrFail($appointmentId);

    // Normalize checkbox inputs - ensure arrays are always present
    if (Auth::user()->doctor_type === 'diabetes_treating') {
        $physicianRecord = $request->input('physician_record', []);
        $needsMerge = false;

        // Ensure current_treatment is always an array
        if (
            !isset($physicianRecord['current_treatment']) ||
            !is_array($physicianRecord['current_treatment'])
        ) {
            $physicianRecord['current_treatment'] = [];
            $needsMerge = true;
        }

        // Ensure others is always an array
        if (!isset($physicianRecord['others']) || !is_array($physicianRecord['others'])) {
            $physicianRecord['others'] = [];
            $needsMerge = true;
        }

        // Merge back to request only if we made changes
        if ($needsMerge) {
            $request->merge(['physician_record' => $physicianRecord]);
        }
    }

    try {
        DB::beginTransaction();

        // Handle height and BMI calculation - ADD THIS SECTION
        $height = $request->filled('height') ? (float) $request->height : null;
        $heightUnit = $request->input('height_unit', 'meter');
        $weight = $request->filled('weight') ? (float) $request->weight : null;

        // Calculate BMI using the SAME method as JavaScript
        $bmi = null;
        if ($height !== null && $weight !== null && $height > 0 && $weight > 0) {
            // Convert height to meters for BMI calculation if needed (same as JavaScript)
            $heightInMeters = $heightUnit === 'feet' ? $height * 0.3048 : $height;
            $bmi = round($weight / ($heightInMeters * $heightInMeters), 2);
        }

        // Normalize arrays for appointment snapshot
        $typeOfTreatment = $request->input('type_of_treatment', []);
        if (!is_array($typeOfTreatment)) {
            $typeOfTreatment = [];
        }
     
        $otherDiseases = $request->input('other_diseases', []);
        if (!is_array($otherDiseases)) {
            $otherDiseases = [];
        }


// Handle date format conversions - Convert from database format (Y-m-d) to display format (d-m-Y)
$diabetesFrom = null;
if ($request->filled('diabetes_from')) {
    // Convert from m-Y format to database format (Y-m-01)
    try {
        $diabetesFrom = \Carbon\Carbon::createFromFormat('m-Y', $request->diabetes_from)->format('Y-m-01');
    } catch (\Exception $e) {
        \Log::error('Error parsing diabetes_from: ' . $request->diabetes_from . ' - ' . $e->getMessage());
        $diabetesFrom = null;
    }
} elseif ($appointment->patient_diabetes_from_snapshot) {
    $diabetesFrom = $appointment->patient_diabetes_from_snapshot;
}

$bpSince = null;
if ($request->filled('bp_since')) {
    // Convert from m-Y format to database format (Y-m-01)
    try {
        $bpSince = \Carbon\Carbon::createFromFormat('m-Y', $request->bp_since)->format('Y-m-01');
    } catch (\Exception $e) {
        \Log::error('Error parsing bp_since: ' . $request->bp_since . ' - ' . $e->getMessage());
        $bpSince = null;
    }
} elseif ($appointment->patient_bp_since_snapshot) {
    $bpSince = $appointment->patient_bp_since_snapshot;
}

$visitDateTime = null;
if ($request->filled('visit_date_time')) {
    try {
        $visitDateTime = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->visit_date_time)->format('Y-m-d H:i:s');
    } catch (\Exception $e) {
        \Log::error('Error parsing visit_date_time: ' . $request->visit_date_time . ' - ' . $e->getMessage());
        $visitDateTime = $appointment->visit_date_time;
    }
} else {
    $visitDateTime = $appointment->visit_date_time;
}

$dateOfBirth = null;
if ($request->filled('date_of_birth')) {
    try {
        $dateOfBirth = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
    } catch (\Exception $e) {
        \Log::error('Error parsing date_of_birth: ' . $request->date_of_birth . ' - ' . $e->getMessage());
        $dateOfBirth = $appointment->patient_date_of_birth_snapshot;
    }
} elseif ($appointment->patient_date_of_birth_snapshot) {
    $dateOfBirth = $appointment->patient_date_of_birth_snapshot;
}

        // Get "other" values directly from request - SIMPLE and DIRECT
        // ALWAYS get the value, trim it, and save if it has content
        $typeOtherInput = $request->input('type_of_treatment_other', '');
        $typeOtherValue = (!empty($typeOtherInput)) ? trim((string)$typeOtherInput) : null;

        $diseasesOtherInput = $request->input('other_diseases_other', '');
        $diseasesOtherValue = (!empty($diseasesOtherInput)) ? trim((string)$diseasesOtherInput) : null;

        // Log for debugging
        \Log::info('Update Appointment - Request values:', [
            'type_of_treatment_other' => $request->input('type_of_treatment_other'),
            'other_diseases_other' => $request->input('other_diseases_other'),
            'processed_type_other' => $typeOtherValue,
            'processed_diseases_other' => $diseasesOtherValue,
            'height' => $height,
            'height_unit' => $heightUnit,
            'weight' => $weight,
            'bmi_calculated' => $bmi,
        ]);

        // Update appointment details including patient snapshot - save ALL fields directly from request
        // IMPORTANT: Include the "other" fields DIRECTLY in the array, not conditionally
        $appointmentUpdateData = [
            'visit_date_time' => $visitDateTime,
            'appointment_type' => $request->input('appointment_type', 'follow_up'),
            // Update appointment's patient snapshot directly from request
            'patient_name' => $request->input('name'),
            'patient_diabetes_from' => $diabetesFrom,
            'patient_diabetes_years' => $request->input('diabetes_years'), // Add diabetes duration
            'patient_diabetes_months' => $request->input('diabetes_months'),
            'patient_date_of_birth' => $dateOfBirth,
            'patient_age' => $request->input('age'),
            'patient_short_address' => $request->input('short_address'),
            'patient_sex' => $request->input('sex'),
            'patient_hospital_id' => $request->input('hospital_id'),
            'patient_on_treatment' => $request->input('on_treatment'),
            'patient_type_of_treatment' => $typeOfTreatment,
            'patient_treatment_other' => $typeOtherValue, // ALWAYS include
            'patient_bp' => $request->input('bp'),
            'patient_bp_since' => $bpSince,
            'patient_bp_years' => $request->input('bp_years'), // Add BP duration
            'patient_bp_months' => $request->input('bp_months'), // Add BP duration
            'patient_other_diseases' => $otherDiseases,
            'patient_disease_other' => $diseasesOtherValue, // ALWAYS include
            'patient_other_input' => $request->input('other_input'),
            'patient_height' => $height, // Use calculated height
            'patient_height_unit' => $heightUnit, // ADD HEIGHT UNIT to appointment
            'patient_weight' => $weight, // Use calculated weight
            'patient_bmi' => $bmi, // Use calculated BMI
            'patient_email' => $request->input('email'),
            'patient_mobile_number' => $request->input('mobile_number'),
            'patient_sssp_id' => $request->input('sssp_id'),
            'physician_record.current_treatment' => 'nullable|array',
        'physician_record.current_treatment.*' => 'in:lifestyle,oha,insulin,glp1,ayurvedic_homeopathy,others',
        'physician_record.current_treatment_other' => 'nullable|string|max:500',
        ];

        \Log::info('Update Appointment - Final update data:', [
            'patient_treatment_other' => $appointmentUpdateData['patient_treatment_other'] ?? 'NOT SET',
            'patient_disease_other' => $appointmentUpdateData['patient_disease_other'] ?? 'NOT SET',
            'patient_height' => $appointmentUpdateData['patient_height'],
            'patient_height_unit' => $appointmentUpdateData['patient_height_unit'],
            'patient_weight' => $appointmentUpdateData['patient_weight'],
            'patient_bmi' => $appointmentUpdateData['patient_bmi'],
        ]);

        $appointment->update($appointmentUpdateData);

        // Verify the update worked
        $appointment->refresh();
        \Log::info('Update Appointment - After update verification:', [
            'appointment_id' => $appointment->id,
            'patient_treatment_other' => $appointment->patient_treatment_other,
            'patient_disease_other' => $appointment->patient_disease_other,
            'patient_height' => $appointment->patient_height,
            'patient_height_unit' => $appointment->patient_height_unit,
            'patient_weight' => $appointment->patient_weight,
            'patient_bmi' => $appointment->patient_bmi,
        ]);

        // Update patient master record - save ALL fields from request
        $patient = $appointment->patient;

        // Get values directly from request (same as appointment)
        $patientTypeOtherValue = $request->input('type_of_treatment_other', '');
        $patientTypeOtherValue = !empty(trim($patientTypeOtherValue)) ? trim($patientTypeOtherValue) : null;

        $patientDiseasesOtherValue = $request->input('other_diseases_other', '');
        $patientDiseasesOtherValue = !empty(trim($patientDiseasesOtherValue)) ? trim($patientDiseasesOtherValue) : null;

        // Handle date format conversions for patient
        $patientDiabetesFrom = null;
if ($request->filled('diabetes_from')) {
    $patientDiabetesFrom = \Carbon\Carbon::createFromFormat('m-Y', $request->diabetes_from)->format('Y-m-01');
}

$patientBpSince = null;
if ($request->filled('bp_since')) {
    $patientBpSince = \Carbon\Carbon::createFromFormat('m-Y', $request->bp_since)->format('Y-m-01');
}

$patientDateOfBirth = null;
if ($request->filled('date_of_birth')) {
    $patientDateOfBirth = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
}

        $patient->update([
            'name' => $request->input('name'),
            'diabetes_from' => $patientDiabetesFrom,
            'diabetes_years' => $request->input('diabetes_years'), // Add diabetes duration
            'diabetes_months' => $request->input('diabetes_months'), // Add diabetes duration
            'date_of_birth' => $patientDateOfBirth,
            'age' => $request->input('age'),
            'short_address' => $request->input('short_address'),
            'sex' => $request->input('sex'),
            'hospital_id' => $request->input('hospital_id'),
            'email' => $request->input('email'),
            'bmi' => $bmi, // Use calculated BMI
            'height' => $height, // Use calculated height
            'height_unit' => $heightUnit, // ADD HEIGHT UNIT to patient table
            'weight' => $weight, // Use calculated weight
            'on_treatment' => $request->input('on_treatment'),
            'type_of_treatment' => $typeOfTreatment,
            'type_of_treatment_other' => $patientTypeOtherValue,
            'bp' => $request->input('bp'),
            'bp_since' => $patientBpSince,
            'bp_years' => $request->input('bp_years'), // Add BP duration
            'bp_months' => $request->input('bp_months'), // Add BP duration
            'other_diseases' => $otherDiseases,
            'other_diseases_other' => $patientDiseasesOtherValue,
            'other_input' => $request->input('other_input')
        ]);

        // Refresh patient to ensure latest data
        $patient->refresh();

        // Log patient update for debugging
        \Log::info('Update Appointment - Patient update verification:', [
            'patient_id' => $patient->id,
            'height' => $patient->height,
            'height_unit' => $patient->height_unit,
            'weight' => $patient->weight,
            'bmi' => $patient->bmi,
        ]);

        // Update or create physician record
        if ($request->has('physician_record.type_of_diabetes')) {
            try {
                $physicianRecord = $appointment->medicalRecords->where('record_type', 'physician')->first()?->physicianRecord;

                if ($physicianRecord) {
                    // Get current_treatment - use normalized value from earlier normalization
                    $currentTreatment = $request->input('physician_record.current_treatment', []);
                    if (!is_array($currentTreatment)) {
                        $currentTreatment = [];
                    }

                    $updateData = [
                        'type_of_diabetes' => $request->input('physician_record.type_of_diabetes'),
                        'family_history_diabetes' => $request->boolean('physician_record.family_history_diabetes'),
                        'compliance' => $request->input('physician_record.compliance'),
                        'blood_sugar_type' => $request->input('physician_record.blood_sugar_type'),
                        'blood_sugar_value' => $request->input('physician_record.blood_sugar_value'),
                        'current_treatment' => $currentTreatment,
                        'other_data' => ($request->input('physician_record.other_data')) ? trim($request->input('physician_record.other_data')) : null,
                        'hypertension' => $request->boolean('physician_record.hypertension'),
                        'dyslipidemia' => $request->boolean('physician_record.dyslipidemia'),
                        'retinopathy' => ($request->input('physician_record.retinopathy')) ? trim($request->input('physician_record.retinopathy')) : null,
                        'neuropathy' => $request->input('physician_record.neuropathy'),
                        'nephropathy' => $request->input('physician_record.nephropathy'),
                        'cardiovascular' => $request->input('physician_record.cardiovascular'),
                        'foot_disease' => $request->input('physician_record.foot_disease'),
                        'others' => $request->input('physician_record.others', []),
                        'others_details' => ($request->input('physician_record.others_details')) ? trim($request->input('physician_record.others_details')) : null,
                        'hba1c_range' => $request->input('physician_record.hba1c_range')
                    ];

                    // Handle current_treatment_other with proper trimming
                    $currentTreatmentOther = $request->input('physician_record.current_treatment_other');
                    if (is_array($currentTreatment) && in_array('others', $currentTreatment) && !empty($currentTreatmentOther) && trim($currentTreatmentOther) !== '') {
                        $updateData['current_treatment_other'] = trim($currentTreatmentOther);
                    } else {
                        $updateData['current_treatment_other'] = null;
                    }

                    $physicianRecord->update($updateData);
                    $physicianRecord->refresh();
                } else {
                    // Create new physician record
                    $patientMedicalRecord = PatientMedicalRecord::create([
                        'patient_id' => $patient->id,
                        'appointment_id' => $appointment->id,
                        'record_type' => 'physician'
                    ]);

                    // Get current_treatment - use normalized value from earlier normalization
                    $currentTreatment = $request->input('physician_record.current_treatment', []);
                    if (!is_array($currentTreatment)) {
                        $currentTreatment = [];
                    }

                    $createData = [
                        'type_of_diabetes' => $request->input('physician_record.type_of_diabetes'),
                        'family_history_diabetes' => $request->boolean('physician_record.family_history_diabetes'),
                        'compliance' => $request->input('physician_record.compliance'),
                        'blood_sugar_type' => $request->input('physician_record.blood_sugar_type'),
                        'blood_sugar_value' => $request->input('physician_record.blood_sugar_value'),
                        'current_treatment' => $currentTreatment,
                        'other_data' => ($request->input('physician_record.other_data')) ? trim($request->input('physician_record.other_data')) : null,
                        'hypertension' => $request->boolean('physician_record.hypertension'),
                        'dyslipidemia' => $request->boolean('physician_record.dyslipidemia'),
                        'retinopathy' => ($request->input('physician_record.retinopathy')) ? trim($request->input('physician_record.retinopathy')) : null,
                        'neuropathy' => $request->input('physician_record.neuropathy'),
                        'nephropathy' => $request->input('physician_record.nephropathy'),
                        'cardiovascular' => $request->input('physician_record.cardiovascular'),
                        'foot_disease' => $request->input('physician_record.foot_disease'),
                        'others' => $request->input('physician_record.others', []),
                        'others_details' => ($request->input('physician_record.others_details')) ? trim($request->input('physician_record.others_details')) : null,
                        'hba1c_range' => $request->input('physician_record.hba1c_range')
                    ];

                    // Handle current_treatment_other with proper trimming
                    $currentTreatmentOther = $request->input('physician_record.current_treatment_other');
                    if (is_array($currentTreatment) && in_array('others', $currentTreatment) && !empty($currentTreatmentOther) && trim($currentTreatmentOther) !== '') {
                        $createData['current_treatment_other'] = trim($currentTreatmentOther);
                    }

                    $patientMedicalRecord->physicianRecord()->create($createData);
                }
            } catch (\Exception $e) {
                \Log::error('Physician record update error: ' . $e->getMessage());
                // Continue with other updates even if medical record fails
            }
        }

        // Update or create ophthalmologist record
        if ($request->has('ophthalmologist_record.diabetic_retinopathy')) {
            try {
                $ophthalmologistRecord = $appointment->medicalRecords->where('record_type', 'ophthalmologist')->first()?->ophthalmologistRecord;

                if ($ophthalmologistRecord) {
                    $dr = $request->input('ophthalmologist_record.diabetic_retinopathy');
                    $dr_re = $request->input('ophthalmologist_record.diabetic_retinopathy_re');

                    $dme = $request->input('ophthalmologist_record.diabetic_macular_edema');
                    $dme_re = $request->input('ophthalmologist_record.diabetic_macular_edema_re');

                    $ophthalmologistRecord->update([
                        'diabetic_retinopathy' => $request->input('ophthalmologist_record.diabetic_retinopathy'),
                        'diabetic_macular_edema' => $request->input('ophthalmologist_record.diabetic_macular_edema'),

                        'investigations' => $request->input('ophthalmologist_record.investigations'),
                        'investigations_others' => $request->input('ophthalmologist_record.investigations_others'),
                        'advised' => $request->input('ophthalmologist_record.advised'),
                        'treatment_done_date' => $request->input('ophthalmologist_record.treatment_done_date'),
                        'review_date' => $request->input('ophthalmologist_record.review_date'),
                        'other_remarks' => $request->input('ophthalmologist_record.other_remarks'),

                        'diabetic_retinopathy_re' => $request->input('ophthalmologist_record.diabetic_retinopathy_re') == '1' || $request->input('ophthalmologist_record.diabetic_retinopathy_re') === 1 || $request->input('ophthalmologist_record.diabetic_retinopathy_re') === true,

                        'diabetic_macular_edema_re' => $request->input('ophthalmologist_record.diabetic_macular_edema_re') == '1' || $request->input('ophthalmologist_record.diabetic_macular_edema_re') === 1 || $request->input('ophthalmologist_record.diabetic_macular_edema_re') === true,

                        'type_of_dr'     => $dr == '1' ? $request->input('ophthalmologist_record.type_of_dr') : null,
                        'type_of_dr_re'  => $dr_re == '1' ? $request->input('ophthalmologist_record.type_of_dr_re') : null,

                        // --------------------------------------------------------------------------------------
                        // DME TYPE: Only store value if YES (1), otherwise NULL
                        // --------------------------------------------------------------------------------------
                        'type_of_dme'    => $dme == '1' ? $request->input('ophthalmologist_record.type_of_dme') : null,
                        'type_of_dme_re' => $dme_re == '1' ? $request->input('ophthalmologist_record.type_of_dme_re') : null,

                        'ucva_re' => $request->input('ophthalmologist_record.ucva_re'),
                        'ucva_le' => $request->input('ophthalmologist_record.ucva_le'),
                        'bcva_re' => $request->input('ophthalmologist_record.bcva_re'),
                        'bcva_le' => $request->input('ophthalmologist_record.bcva_le'),
                        'anterior_segment_re' => $request->input('ophthalmologist_record.anterior_segment_re'),
                        'anterior_segment_le' => $request->input('ophthalmologist_record.anterior_segment_le'),
                        'iop_re' => $request->input('ophthalmologist_record.iop_re'),
                        'iop_le' => $request->input('ophthalmologist_record.iop_le'),
                        'advised_re' => $request->input('ophthalmologist_record.advised_re'),
                    ]);
                } else {
                    $dr = $request->input('ophthalmologist_record.diabetic_retinopathy');
                    $dr_re = $request->input('ophthalmologist_record.diabetic_retinopathy_re');

                    $dme = $request->input('ophthalmologist_record.diabetic_macular_edema');
                    $dme_re = $request->input('ophthalmologist_record.diabetic_macular_edema_re');
                    // Create new ophthalmologist record
                    $patientMedicalRecord = PatientMedicalRecord::create([
                        'patient_id' => $patient->id,
                        'appointment_id' => $appointment->id,
                        'record_type' => 'ophthalmologist'
                    ]);

                    $patientMedicalRecord->ophthalmologistRecord()->create([
                        'diabetic_retinopathy' => $request->input('ophthalmologist_record.diabetic_retinopathy'),
                        'diabetic_macular_edema' => $request->input('ophthalmologist_record.diabetic_macular_edema'),

                        'investigations' => $request->input('ophthalmologist_record.investigations'),
                        'investigations_others' => $request->input('ophthalmologist_record.investigations_others'),
                        'advised' => $request->input('ophthalmologist_record.advised'),
                        'treatment_done_date' => $request->input('ophthalmologist_record.treatment_done_date'),
                        'review_date' => $request->input('ophthalmologist_record.review_date'),
                        'other_remarks' => $request->input('ophthalmologist_record.other_remarks'),

                        'diabetic_retinopathy_re' => $request->input('ophthalmologist_record.diabetic_retinopathy_re') == '1' || $request->input('ophthalmologist_record.diabetic_retinopathy_re') === 1 || $request->input('ophthalmologist_record.diabetic_retinopathy_re') === true,

                        'diabetic_macular_edema_re' => $request->input('ophthalmologist_record.diabetic_macular_edema_re') == '1' || $request->input('ophthalmologist_record.diabetic_macular_edema_re') === 1 || $request->input('ophthalmologist_record.diabetic_macular_edema_re') === true,

                        'type_of_dr'     => $dr == '1' ? $request->input('ophthalmologist_record.type_of_dr') : null,
                        'type_of_dr_re'  => $dr_re == '1' ? $request->input('ophthalmologist_record.type_of_dr_re') : null,

                        // --------------------------------------------------------------------------------------
                        // DME TYPE: Only store value if YES (1), otherwise NULL
                        // --------------------------------------------------------------------------------------
                        'type_of_dme'    => $dme == '1' ? $request->input('ophthalmologist_record.type_of_dme') : null,
                        'type_of_dme_re' => $dme_re == '1' ? $request->input('ophthalmologist_record.type_of_dme_re') : null,

                        'ucva_re' => $request->input('ophthalmologist_record.ucva_re'),
                        'ucva_le' => $request->input('ophthalmologist_record.ucva_le'),
                        'bcva_re' => $request->input('ophthalmologist_record.bcva_re'),
                        'bcva_le' => $request->input('ophthalmologist_record.bcva_le'),
                        'anterior_segment_re' => $request->input('ophthalmologist_record.anterior_segment_re'),
                        'anterior_segment_le' => $request->input('ophthalmologist_record.anterior_segment_le'),
                        'iop_re' => $request->input('ophthalmologist_record.iop_re'),
                        'iop_le' => $request->input('ophthalmologist_record.iop_le'),
                        'advised_re' => $request->input('ophthalmologist_record.advised_re'),
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Ophthalmologist record update error: ' . $e->getMessage());
                // Continue with other updates even if medical record fails
            }
        }

        DB::commit();

        return redirect()->route('doctor.patients.medical-records', $appointment->patient_id)
            ->with('success', 'Appointment details updated successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Appointment update error: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return redirect()->back()
            ->with('error', 'Failed to update appointment. Error: ' . $e->getMessage())
            ->withInput();
    }
}
    /**
     * Show My Appointments page for doctor
     */
public function myAppointments(Request $request)
{
    if (!Auth::check() || !Auth::user()->isDoctor())     {
        return redirect('/doctor/login');
    }

    $query = PatientAppointment::with([
        'patient',
        'doctor',
        'medicalRecords.physicianRecord',
        'medicalRecords.ophthalmologistRecord'
    ])->where('doctor_id', Auth::id());

     // Single date filter
    if ($request->filled('appointment_date')) {
        $appointmentDate = trim($request->appointment_date);
        
        try {
            $appointmentDateDb = \Carbon\Carbon::createFromFormat('d-m-Y', $appointmentDate)->format('Y-m-d');
        } catch (\Exception $e) {
            // Fallback if conversion fails
            $appointmentDateDb = now()->format('Y-m-d');
        }
        
        // Filter by exact date
        $query->whereDate('visit_date_time', $appointmentDateDb);
    }

    // Search filter and sorting (rest remains same)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->whereHas('patient', function ($patientQuery) use ($search) {
                $patientQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%")
                    ->orWhere('sssp_id', 'like', "%{$search}%");
            })
            ->orWhere('appointment_type', 'like', "%{$search}%");
        });
    }

    $sortBy = $request->get('sort_by', 'visit_date_time');
    $sortDirection = $request->get('sort_direction', 'desc');

    if (!in_array($sortDirection, ['asc', 'desc'])) {
        $sortDirection = 'desc';
    }

    switch ($sortBy) {
        case 'name':
        case 'mobile_number':
        case 'sssp_id':
            $query->join('patients', 'patient_appointments.patient_id', '=', 'patients.id')
                ->orderBy('patients.' . $sortBy, $sortDirection)
                ->select('patient_appointments.*');
            break;
        case 'visit_date_time':
        default:
            $query->orderBy($sortBy, $sortDirection);
            break;
    }

    $appointments = $query->paginate(10)->appends($request->except('page'));

    return view('doctor.appointments.my-appointments', [
        'title' => 'My Appointments',
        'breadcrumb' => 'My Appointments',
        'appointments' => $appointments
       
    ]);
}
}



   
