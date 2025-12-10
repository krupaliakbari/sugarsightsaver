<?php

namespace App\Services;

use App\Models\PatientMedicalRecord;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MedicalReportService
{
    /**
     * Generate PDF for medical record
     */
    public function generatePDF(PatientMedicalRecord $patientMedicalRecord): Response
    {
        $patient = $patientMedicalRecord->patient;
        $appointment = $patientMedicalRecord->appointment;
        $doctor = $appointment->doctor;

        // Load relationships
        $patientMedicalRecord->load(['physicianRecord', 'ophthalmologistRecord']);

        // Get logo as base64 for better PDF compatibility
        $logoPath = public_path('images/logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        } else {
            // Try alternative path
            $altLogoPath = resource_path('images/logo.png');
            if (file_exists($altLogoPath)) {
                $logoData = file_get_contents($altLogoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }
        }

        $data = [
            'patient' => $patient,
            'appointment' => $appointment,
            'doctor' => $doctor,
            'medicalRecord' => $patientMedicalRecord,
            'physicianRecord' => $patientMedicalRecord->physicianRecord,
            'ophthalmologistRecord' => $patientMedicalRecord->ophthalmologistRecord,
            'generated_at' => now()->format('M d, Y H:i:s'),
            'report_id' => 'MR-' . $patientMedicalRecord->id . '-' . now()->format('Ymd'),
            'logo_base64' => $logoBase64
        ];

        $type = $doctor->doctor_type == 'ophthalmologist' ? ' Eye Report' : ' Physician Report';

// dd($patientMedicalRecord->ophthalmologistRecord->iop_re);
        // Use updated medical-report template for single-page PDF
        $pdf = Pdf::loadView('reports.medical-report', $data);

        // Configure PDF options for single page with minimal margins
        $pdf->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'isPhpEnabled' => false,
                'defaultFont' => 'Arial',
                'dpi' => 150,
                'isFontSubsettingEnabled' => true,
                'isUnicode' => true,
                'debugKeepTemp' => false,
                'debugCss' => false,
                'debugLayout' => false,
                'debugLayoutLines' => false,
                'debugLayoutBlocks' => false,
                'debugLayoutInline' => false,
                'debugLayoutPaddingBox' => false,
                'marginTop' => 3,
                'marginRight' => 3,
                'marginBottom' => 3,
                'marginLeft' => 3,
            ]);

        $filename = $appointment->patient_sssp_id.$type.'_' . $appointment->visit_date_time->format('d-m-Y') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate PDF file and save to temporary storage for attachment
     */
    public function generatePDFFile(PatientMedicalRecord $patientMedicalRecord): string
    {
        $patient = $patientMedicalRecord->patient;
        $appointment = $patientMedicalRecord->appointment;
        $doctor = $appointment->doctor;

        // Load relationships
        $patientMedicalRecord->load(['physicianRecord', 'ophthalmologistRecord']);

        // Get logo as base64 for better PDF compatibility
        $logoPath = public_path('images/logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        } else {
            // Try alternative path
            $altLogoPath = resource_path('images/logo.png');
            if (file_exists($altLogoPath)) {
                $logoData = file_get_contents($altLogoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }
        }

        $data = [
            'patient' => $patient,
            'appointment' => $appointment,
            'doctor' => $doctor,
            'medicalRecord' => $patientMedicalRecord,
            'physicianRecord' => $patientMedicalRecord->physicianRecord,
            'ophthalmologistRecord' => $patientMedicalRecord->ophthalmologistRecord,
            'generated_at' => now()->format('M d, Y H:i:s'),
            'report_id' => 'MR-' . $patientMedicalRecord->id . '-' . now()->format('Ymd'),
            'logo_base64' => $logoBase64
        ];

        // Use updated medical-report template for single-page PDF
        $pdf = Pdf::loadView('reports.medical-report', $data);

        // Configure PDF options for single page with minimal margins
        $pdf->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'isPhpEnabled' => false,
                'defaultFont' => 'Arial',
                'dpi' => 150,
                'isFontSubsettingEnabled' => true,
                'isUnicode' => true,
                'debugKeepTemp' => false,
                'debugCss' => false,
                'debugLayout' => false,
                'debugLayoutLines' => false,
                'debugLayoutBlocks' => false,
                'debugLayoutInline' => false,
                'debugLayoutPaddingBox' => false,
                'marginTop' => 3,
                'marginRight' => 3,
                'marginBottom' => 3,
                'marginLeft' => 3,
            ]);

        $filename = 'Medical_Report_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $patient->name) . '_' . now()->format('Y-m-d') . '_' . uniqid() . '.pdf';

        // Save to temporary storage
        $tempPath = storage_path('app/temp/' . $filename);

        // Ensure temp directory exists
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        // Save PDF to file
        file_put_contents($tempPath, $pdf->output());

        return $tempPath;
    }

    /**
     * Generate print-friendly HTML for medical record
     */
    public function generatePrintView(PatientMedicalRecord $patientMedicalRecord): string
    {
        $patient = $patientMedicalRecord->patient;
        $appointment = $patientMedicalRecord->appointment;
        $doctor = $appointment->doctor;

        // Load relationships
        $patientMedicalRecord->load(['physicianRecord', 'ophthalmologistRecord']);

        // Get logo as base64 for better PDF compatibility
        $logoPath = public_path('images/logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        } else {
            // Try alternative path
            $altLogoPath = resource_path('images/logo.png');
            if (file_exists($altLogoPath)) {
                $logoData = file_get_contents($altLogoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }
        }

        $data = [
            'patient' => $patient,
            'appointment' => $appointment,
            'doctor' => $doctor,
            'medicalRecord' => $patientMedicalRecord,
            'physicianRecord' => $patientMedicalRecord->physicianRecord,
            'ophthalmologistRecord' => $patientMedicalRecord->ophthalmologistRecord,
            'generated_at' => now()->format('M d, Y H:i:s'),
            'report_id' => 'MR-' . $patientMedicalRecord->id . '-' . now()->format('Ymd'),
            'logo_base64' => $logoBase64
        ];

        return view('reports.medical-report-print', $data)->render();
    }

    /**
     * Generate WhatsApp message for medical record with custom template
     */
    public function generateWhatsAppMessage(PatientMedicalRecord $patientMedicalRecord, string $phoneNumber): string
    {
        $patient = $patientMedicalRecord->patient;
        $appointment = $patientMedicalRecord->appointment;
        $doctor = $appointment->doctor;

        // Get portal name from settings
        $portalName = Setting::get('site_name', 'Sugar Sight Saver');

        // Get hospital name (from doctor or settings)
        $hospitalName = $doctor->hospital_name ?? Setting::get('site_name', 'N/A');

        // Format appointment date and time
        $appointmentDateTime = $appointment->visit_date_time->format('M d, Y H:i');

        // Build message with dynamic variables
        $message = "Hello " . $patient->name . ",\n\n";
        $message .= "Here's a summary of your appointment with Dr. " . $doctor->name . "\n";
        $message .= "Hospital: " . $hospitalName . "\n";
        $message .= "Appointment Date And Time: " . $appointmentDateTime . "\n\n";
        $message .= "Download your summary here: [PDF attached]\n\n";
        $message .= "Stay healthy,\n";
        $message .= "Team " . $portalName;

        return $message;
    }

    /**
     * Validate phone number for WhatsApp
     */
    public function validatePhoneNumber(string $phoneNumber): bool
    {
        // Remove all non-digit characters
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Check if it's a valid phone number (exactly 10 digits)
        return strlen($cleaned) === 10;
    }

    /**
     * Format phone number for WhatsApp
     */
    public function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove all non-digit characters
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Add country code if not present (assuming India +91)
        if (strlen($cleaned) === 10) {
            $cleaned = '91' . $cleaned;
        }

        return $cleaned;
    }
}
