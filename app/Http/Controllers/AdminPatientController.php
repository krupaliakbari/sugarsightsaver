<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\PatientAppointment;
use App\Models\PatientMedicalRecord;
use App\Exports\AdminPatientsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPatientController extends Controller
{
    /**
     * Display a listing of all patients for admin
     */
    public function index(Request $request)
    {
        $query = Patient::with(['createdByDoctor', 'appointments']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('sssp_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('doctor_id')) {
            $query->where('created_by_doctor_id', $request->doctor_id);
        }

        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
        }

        // Age filtering
        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        switch ($sortBy) {
            case 'name':
                $query->orderBy('name', $sortDirection);
                break;
            case 'mobile_number':
                $query->orderBy('mobile_number', $sortDirection);
                break;
            case 'sssp_id':
                $query->orderBy('sssp_id', $sortDirection);
                break;
            case 'age':
                $query->orderBy('age', $sortDirection);
                break;
            case 'last_visit':
                $query->orderBy(
                    \App\Models\PatientAppointment::select('visit_date_time')
                        ->whereColumn('patient_id', 'patients.id')
                        ->orderBy('visit_date_time', 'desc')
                        ->limit(1),
                    $sortDirection
                );
                break;
            case 'total_appointments':
                $query->withCount('appointments')->orderBy('appointments_count', $sortDirection);
                break;
            default:
                $query->orderBy('created_at', $sortDirection);
                break;
        }

        // Add query parameters to pagination links before paginating
        $patients = $query->paginate(15)->appends($request->query());
        
        // Get all doctors for filter dropdown
        $doctors = User::whereHas('roles', function($q) {
            $q->where('name', 'doctor');
        })->get();

        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('pages.admin.patients.index', compact('patients', 'doctors'));
        }

        return view('pages.admin.patients.index', compact('patients', 'doctors'));
    }

    /**
     * Display the specified patient details with medical records management (admin)
     */
    public function show($id, Request $request)
    {
        $patient = Patient::with([
            'createdByDoctor', 
            'appointments.doctor', 
            'appointments.medicalRecords.physicianRecord', 
            'appointments.medicalRecords.ophthalmologistRecord'
        ])->findOrFail($id);

        // Get paginated appointments with medical records - All appointments for admin
        $appointmentsQuery = $patient->appointments()
            ->with([
                'doctor', 
                'medicalRecords.physicianRecord', 
                'medicalRecords.ophthalmologistRecord'
            ]);

        // Apply search filter for appointments
        if ($request->filled('search')) {
            $search = $request->search;
            $appointmentsQuery->where(function($q) use ($search) {
                $q->where('visit_date_time', 'like', "%{$search}%")
                  ->orWhere('appointment_type', 'like', "%{$search}%");
            });
        }

        // Apply appointment type filter
        if ($request->filled('appointment_type')) {
            $appointmentsQuery->where('appointment_type', $request->appointment_type);
        }

        // Apply date range filter
        if ($request->filled('date_from')) {
            $appointmentsQuery->whereDate('visit_date_time', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $appointmentsQuery->whereDate('visit_date_time', '<=', $request->date_to);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'visit_date_time');
        $sortDirection = $request->get('sort_direction', 'desc');

        if ($sortBy === 'date') {
            $sortBy = 'visit_date_time';
        }

        $appointmentsQuery->orderBy($sortBy, $sortDirection);

        $appointments = $appointmentsQuery->paginate(10);
        
        // Add query parameters to pagination links
        $appointments->appends($request->query());

        // Get the most recent appointment's BMI snapshot for display
        $latestAppointment = $patient->appointments()
            ->orderBy('visit_date_time', 'desc')
            ->first();
        
        $latestBmi = $latestAppointment ? $latestAppointment->patient_bmi_snapshot : null;

        $title = 'Patient Details - ' . $patient->name;

        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('pages.admin.patients.show', compact('patient', 'appointments', 'title', 'latestBmi'));
        }

        return view('pages.admin.patients.show', compact('patient', 'appointments', 'title', 'latestBmi'));
    }

    /**
     * Export all patients to Excel
     */
    public function export()
    {
        // dd("Export");
                return Excel::download(new AdminPatientsExport(), 'all_patients_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export filtered patients to Excel
     */
    public function exportFiltered(Request $request)
    {
        // dd("ExportFilter");
        $query = null;
        
        try {
            $query = Patient::with(['createdByDoctor', 'appointments']);

            // Apply same filters as index method
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('mobile_number', 'like', "%{$search}%")
                      ->orWhere('sssp_id', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            if ($request->filled('doctor_id')) {
                $query->where('created_by_doctor_id', $request->doctor_id);
            }

            if ($request->filled('sex')) {
                $query->where('sex', $request->sex);
            }

            // Age filtering
            if ($request->filled('age')) {
                $query->where('age', $request->age);
            }

             $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        switch ($sortBy) {
            case 'name':
                $query->orderBy('name', $sortDirection);
                break;
            case 'mobile_number':
                $query->orderBy('mobile_number', $sortDirection);
                break;
            case 'sssp_id':
                $query->orderBy('sssp_id', $sortDirection);
                break;
            case 'age':
                $query->orderBy('age', $sortDirection);
                break;
            case 'last_visit':
                $query->orderBy(
                    \App\Models\PatientAppointment::select('visit_date_time')
                        ->whereColumn('patient_id', 'patients.id')
                        ->orderBy('visit_date_time', 'desc')
                        ->limit(1),
                    $sortDirection
                );
                break;
            case 'total_appointments':
                $query->withCount('appointments')->orderBy('appointments_count', $sortDirection);
                break;
            default:
                $query->orderBy('created_at', $sortDirection);
                break;
        }

            $patients = $query->get();
            
            return Excel::download(new AdminPatientsExport($patients), 'filtered_patients_' . date('Y-m-d_H-i-s') . '.xlsx');
            
        } catch (\Exception $e) {
            Log::error('Export filtered patients error: ' . $e->getMessage());
            Log::error('Request parameters: ' . json_encode($request->all()));
            
            if ($query) {
                Log::error('SQL Query: ' . $query->toSql());
                Log::error('SQL Bindings: ' . json_encode($query->getBindings()));
            }
            
            return redirect()->back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

   public function destroy(Patient $patient)
{
    // dd($patient);
    try {
        
        DB::transaction(function () use ($patient) {
            // Admin deletes EVERYTHING — no checks needed
            $patient->delete(); // This triggers Patient@deleting → deletes all related data
        });

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Patient and all associated records deleted successfully!');

    } catch (\Exception $e) {
        \Log::error('Admin Delete Patient Failed: ' . $e->getMessage());

        return redirect()
            ->back()
            ->with('error', 'Failed to delete patient. Please try again.');
    }
}
    /**
     * Show medical record details for admin (read-only, no print/pdf/whatsapp)
     */
    public function showMedicalRecord($patientId, $medicalRecordId)
    {
        $patient = Patient::findOrFail($patientId);
        
        $patientMedicalRecord = PatientMedicalRecord::with([
            'patient',
            'appointment.doctor',
            'physicianRecord',
            'ophthalmologistRecord'
        ])->where('id', $medicalRecordId)
          ->whereHas('appointment', function($query) use ($patientId) {
              $query->where('patient_id', $patientId);
          })
          ->firstOrFail();

        $title = 'Medical Record Details - ' . $patient->name;

        return view('pages.admin.patients.medical-record', compact('patientMedicalRecord', 'patient', 'title'));
    }

    /**
     * Delete medical record and entire appointment for admin
     */
    public function deleteMedicalRecord($patientId, $medicalRecordId)
    {
        $patient = Patient::findOrFail($patientId);
        
        $patientMedicalRecord = PatientMedicalRecord::where('id', $medicalRecordId)
            ->whereHas('appointment', function($query) use ($patientId) {
                $query->where('patient_id', $patientId);
            })
            ->firstOrFail();

        try {
            // Get the appointment before deleting
            $appointment = $patientMedicalRecord->appointment;
            
            // Delete related records first
            if ($patientMedicalRecord->physicianRecord) {
                $patientMedicalRecord->physicianRecord->delete();
            }
            
            if ($patientMedicalRecord->ophthalmologistRecord) {
                $patientMedicalRecord->ophthalmologistRecord->delete();
            }

            // Delete the medical record
            $patientMedicalRecord->delete();
            
            // Delete the entire appointment
            $appointment->delete();

            return redirect()->route('admin.patients.show', $patientId)
                ->with('success', 'Appointment and medical record deleted successfully.');
                
        } catch (\Exception $e) {
            Log::error('Delete appointment error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete appointment: ' . $e->getMessage());
        }
    }

    /**
     * Show All Appointments page for admin
     */
    public function appointments(Request $request)
    {
        $query = PatientAppointment::with([
            'patient',
            'doctor',
            'medicalRecords.physicianRecord',
            'medicalRecords.ophthalmologistRecord'
        ]);

        // Set today's date as default if no date filters are provided
        $today = now()->format('Y-m-d');
        $dateFrom = $request->filled('date_from') ? $request->date_from : $today;
        $dateTo = $request->filled('date_to') ? $request->date_to : $today;

        // Apply date range filter
        $query->whereDate('visit_date_time', '>=', $dateFrom);
        $query->whereDate('visit_date_time', '<=', $dateTo);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('patient', function($patientQuery) use ($search) {
                    $patientQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('mobile_number', 'like', "%{$search}%")
                                ->orWhere('sssp_id', 'like', "%{$search}%");
                })
                ->orWhere('appointment_type', 'like', "%{$search}%");
            });
        }

        // Handle sorting
        $sortBy = $request->get('sort_by', 'visit_date_time');
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
                // Sort by patient fields - need to join patients table
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

        return view('pages.admin.appointments.index', [
            'title' => 'All Appointments',
            'breadcrumb' => 'All Appointments',
            'appointments' => $appointments,
            'defaultDateFrom' => $dateFrom,
            'defaultDateTo' => $dateTo
        ]);
    }
}
