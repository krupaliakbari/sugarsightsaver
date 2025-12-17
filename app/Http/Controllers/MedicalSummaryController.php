<?php

namespace App\Http\Controllers;

use App\Models\PatientMedicalRecord;
use App\Services\MedicalReportService;
use App\Services\WatiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MedicalSummaryController extends Controller
{
    protected $medicalReportService;
    protected $watiService;

    public function __construct(MedicalReportService $medicalReportService, WatiService $watiService)
    {
        $this->medicalReportService = $medicalReportService;
        $this->watiService = $watiService;
    }

    /**
     * Show the Appointment summary page
     */
    public function show($patientMedicalRecordId)
    {
        $patientMedicalRecord = PatientMedicalRecord::with([
            'patient',
            'appointment.doctor',
            'physicianRecord',
            'ophthalmologistRecord'
        ])->findOrFail($patientMedicalRecordId);

        // Check if user is authorized to access this record
        if ($patientMedicalRecord->appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this medical record.');
        }

        $title = 'Appointment Summary - ' . $patientMedicalRecord->patient->name;

        return view('doctor.medical.summary', compact('patientMedicalRecord', 'title'));
    }

    /**
     * Show print-friendly version of medical record
     */
    public function print($patientMedicalRecordId)
    {

        $patientMedicalRecord = PatientMedicalRecord::with([
            'patient',
            'appointment.doctor',
            'physicianRecord',
            'ophthalmologistRecord'
        ])->findOrFail($patientMedicalRecordId);

        // Check if user is authorized
        if ($patientMedicalRecord->appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this medical record.');
        }

        $patient = $patientMedicalRecord->patient;
        $appointment = $patientMedicalRecord->appointment;
        $doctor = $appointment->doctor;

        $data = [
            'patient' => $patient,
            'appointment' => $appointment,
            'doctor' => $doctor,
            'medicalRecord' => $patientMedicalRecord,
            'physicianRecord' => $patientMedicalRecord->physicianRecord,
            'ophthalmologistRecord' => $patientMedicalRecord->ophthalmologistRecord,
            'generated_at' => now()->format('M d, Y H:i:s'),
            'report_id' => 'MR-' . $patientMedicalRecord->id . '-' . now()->format('Ymd')
        ];
// dd($patientMedicalRecord->ophthalmologistRecord);
        return view('reports.medical-report-print', $data);
    }

    /**
     * Generate PDF for medical record
     */
    public function generatePdf($patientMedicalRecordId)
    {
        $patientMedicalRecord = PatientMedicalRecord::with([
            'patient',
            'appointment.doctor',
            'physicianRecord',
            'ophthalmologistRecord'
        ])->findOrFail($patientMedicalRecordId);

        // Check if user is authorized
        if ($patientMedicalRecord->appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this medical record.');
        }

        return $this->medicalReportService->generatePDF($patientMedicalRecord);
    }


public function sendWhatsAppMsg(Request $request, $patientMedicalRecordId)
{
    $record = PatientMedicalRecord::with([
        'patient',
        'appointment.doctor',
        'physicianRecord',
        'ophthalmologistRecord'
    ])->findOrFail($patientMedicalRecordId);

    if ($record->appointment->doctor_id !== Auth::id()) {
        return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
    }

    return $this->medicalReportService->generatePDFMsg($record);
}

    /**
     * Send WhatsApp message with PDF via Wati
     */
    public function sendWhatsApp(Request $request, $patientMedicalRecordId)
    {
        $request->validate([
            'phone_number' => 'required|string|max:20'
        ]);

        $patientMedicalRecord = PatientMedicalRecord::with([
            'patient',
            'appointment.doctor',
            'physicianRecord',
            'ophthalmologistRecord'
        ])->findOrFail($patientMedicalRecordId);

        // Check if user is authorized
        if ($patientMedicalRecord->appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this medical record.');
        }

        $phoneNumber = $request->phone_number;

        // Validate phone number
        if (!$this->medicalReportService->validatePhoneNumber($phoneNumber)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone number format. Please enter a valid phone number (10 digits).'
            ], 400);
        }

        // Check if Wati is configured
        if (!$this->watiService->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'WhatsApp service (Wati) is not configured. Please contact administrator.'
            ], 500);
        }

        try {
            // Format phone number for WhatsApp
            $formattedPhone = $this->medicalReportService->formatPhoneNumber($phoneNumber);

            // Generate WhatsApp message
            $message = $this->medicalReportService->generateWhatsAppMessage($patientMedicalRecord, $formattedPhone);

            // Generate PDF file for attachment
            $pdfPath = $this->medicalReportService->generatePDFFile($patientMedicalRecord);
            $pdfFileName = 'Medical_Report_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $patientMedicalRecord->patient->name) . '_' . now()->format('Y-m-d') . '.pdf';

            // Send message with PDF via Wati
            $result = $this->watiService->sendMessageWithPdf($formattedPhone, $message, $pdfPath, $pdfFileName);

            // Clean up temporary PDF file
            if (file_exists($pdfPath)) {
                @unlink($pdfPath);
            }

            if ($result['success']) {
                Log::info('WhatsApp message sent successfully', [
                    'patient_medical_record_id' => $patientMedicalRecordId,
                    'phone_number' => $formattedPhone
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'WhatsApp message with PDF sent successfully to ' . $phoneNumber
                ]);
            } else {
                Log::error('Failed to send WhatsApp message', [
                    'patient_medical_record_id' => $patientMedicalRecordId,
                    'phone_number' => $formattedPhone,
                    'error' => $result['message']
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending WhatsApp message', [
                'patient_medical_record_id' => $patientMedicalRecordId,
                'phone_number' => $phoneNumber,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Clean up temporary PDF file if it exists
            if (isset($pdfPath) && file_exists($pdfPath)) {
                @unlink($pdfPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending WhatsApp message: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Test logo loading for debugging
     */
    public function testLogo()
    {
        $logoPath = public_path('images/logo.png');
        $altLogoPath = resource_path('images/logo.png');

        $result = [
            'public_path_exists' => file_exists($logoPath),
            'public_path' => $logoPath,
            'resource_path_exists' => file_exists($altLogoPath),
            'resource_path' => $altLogoPath,
        ];

        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $result['logo_base64'] = 'data:image/png;base64,' . base64_encode($logoData);
            $result['logo_size'] = strlen($logoData);
        }

        return response()->json($result);
    }
}
