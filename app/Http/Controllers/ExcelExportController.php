<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PatientsExport;
use App\Exports\MedicalRecordsExport;

class ExcelExportController extends Controller
{
    /**
     * Export patients list to Excel
     */
    public function exportPatients(Request $request)
{
    // Check authorization
    if (!Auth::user()->hasRole(['admin', 'doctor'])) {
        abort(403, 'Unauthorized access.');
    }

    $doctorId = Auth::user()->hasRole('doctor') ? Auth::id() : null;

    // Get filters and sorting from request
    $filters = $request->only(['search', 'sex', 'age', 'last_visit_from', 'last_visit_to']);
    $sortBy = $request->get('sort_by', 'created_at');
    $sortDirection = $request->get('sort_direction', 'desc');

    // Validate sort direction
    $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'desc';

    // Generate filename
    $filename = 'Patients_List_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

    // Pass all necessary data to the Export class
    return Excel::download(
        new PatientsExport($doctorId, $filters, $sortBy, $sortDirection),
        $filename
    );
}

    /**
     * Export medical records to Excel
     */
    public function exportMedicalRecords(Request $request)
    {
        // Check if user is authorized (admin or doctor)
        if (!Auth::user()->hasRole(['admin', 'doctor'])) {
            abort(403, 'Unauthorized access.');
        }

        $doctorId = null;
        if (Auth::user()->hasRole('doctor')) {
            $doctorId = Auth::id();
        }

        // Get filter parameters
        $filters = $request->only(['search', 'sex', 'age']);
        
        $filename = 'Medical_Records_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new MedicalRecordsExport($doctorId, null, $filters), $filename);
    }

    /**
     * Export specific patient's medical records - Shared patient system
     */
    public function exportPatientMedicalRecords($patientId)
    {
        // Check if user is authorized
        if (!Auth::user()->hasRole(['admin', 'doctor'])) {
            abort(403, 'Unauthorized access.');
        }

        $patient = Patient::findOrFail($patientId);
        
        // Check if doctor has any appointments with this patient
        if (Auth::user()->hasRole('doctor')) {
            $hasAppointments = PatientAppointment::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->exists();
                
            if (!$hasAppointments) {
                abort(403, 'You have no appointments with this patient.');
            }
        }

        $filename = 'Medical_Records_' . $patient->name . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        // Pass doctor ID to filter appointments in export (admin sees all, doctor sees only their appointments)
        $doctorId = Auth::user()->hasRole('doctor') ? Auth::id() : null;
        return Excel::download(new MedicalRecordsExport($doctorId, $patientId), $filename);
    }
}