<?php

namespace App\Exports;

use App\Models\PatientMedicalRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MedicalRecordsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $doctorId;
    protected $patientId;
    protected $filters;

    public function __construct($doctorId = null, $patientId = null, $filters = [])
    {
        $this->doctorId = $doctorId;
        $this->patientId = $patientId;
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = PatientMedicalRecord::with([
            'patient',
            'appointment.doctor',
            'physicianRecord',
            'ophthalmologistRecord'
        ]);
        
        if ($this->doctorId) {
            $query->whereHas('appointment', function($q) {
                $q->where('doctor_id', $this->doctorId);
            });
        }
        
        if ($this->patientId) {
            $query->where('patient_id', $this->patientId);
        }
        
        // Apply filters to patients
        if (!empty($this->filters)) {
            $query->whereHas('patient', function($q) {
                if (!empty($this->filters['search'])) {
                    $search = $this->filters['search'];
                    $q->where(function($subQ) use ($search) {
                        $subQ->where('name', 'like', "%{$search}%")
                             ->orWhere('mobile_number', 'like', "%{$search}%")
                             ->orWhere('sssp_id', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                    });
                }

                if (!empty($this->filters['sex'])) {
                    $q->where('sex', $this->filters['sex']);
                }

                if (!empty($this->filters['age'])) {
                    $q->where('age', $this->filters['age']);
                }
            });
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Record ID',
            'Patient Name',
            'Patient Mobile',
            'SSSP ID',
            'Appointment Date',
            'Doctor Name',
            'Doctor Type',
            'Hospital',
            'Record Type',
            'Type of Diabetes',
            'Family History Diabetes',
            'Current Treatment',
            'Compliance',
            'Blood Sugar Type',
            'Blood Sugar Value',
            'Diabetic Retinopathy (DR)',
            'Diabetic Macular Edema (DME)',
            'Type of DR',
            'Type of DME',
            'Investigations',
            'Advised Treatment',
            'Treatment Done Date',
            'Review Date',
            'Other Data',
            'Other Remarks',
            'Created Date'
        ];
    }

    public function map($record): array
    {
        $physicianRecord = $record->physicianRecord;
        $ophthalmologistRecord = $record->ophthalmologistRecord;
        
        return [
            'MR-' . $record->id,
            $record->patient->name,
            $record->patient->mobile_number,
            $record->patient->sssp_id,
            $record->appointment->visit_date_time->format('M d, Y H:i'),
            $record->appointment->doctor->name,
            ucfirst(str_replace('_', ' ', $record->appointment->doctor->doctor_type)),
            $record->appointment->doctor->hospital_name ?? 'Not specified',
            ucfirst($record->record_type),
            $physicianRecord ? $physicianRecord->formatted_diabetes_type : 'N/A',
            $physicianRecord ? ($physicianRecord->family_history_diabetes ? 'Yes' : 'No') : 'N/A',
            $physicianRecord ? $physicianRecord->formatted_current_treatment : 'N/A',
            $physicianRecord ? $physicianRecord->formatted_compliance : 'N/A',
            $physicianRecord ? $physicianRecord->formatted_blood_sugar_type : 'N/A',
            $physicianRecord ? $physicianRecord->blood_sugar_value : 'N/A',
            $ophthalmologistRecord ? ($ophthalmologistRecord->diabetic_retinopathy ? 'Yes' : 'No') : 'N/A',
            $ophthalmologistRecord ? ($ophthalmologistRecord->diabetic_macular_edema ? 'Yes' : 'No') : 'N/A',
            $ophthalmologistRecord ? $ophthalmologistRecord->formatted_dr_type : 'N/A',
            $ophthalmologistRecord ? $ophthalmologistRecord->formatted_dme_type : 'N/A',
            $ophthalmologistRecord ? $ophthalmologistRecord->formatted_investigations : 'N/A',
            $ophthalmologistRecord ? $ophthalmologistRecord->formatted_advised : 'N/A',
            $ophthalmologistRecord && $ophthalmologistRecord->treatment_done_date ? $ophthalmologistRecord->treatment_done_date->format('M d, Y') : 'N/A',
            $ophthalmologistRecord && $ophthalmologistRecord->review_date ? $ophthalmologistRecord->review_date->format('M d, Y') : 'N/A',
            $physicianRecord ? $physicianRecord->other_data : 'N/A',
            $ophthalmologistRecord ? $ophthalmologistRecord->other_remarks : 'N/A',
            $record->created_at->format('M d, Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Record ID
            'B' => 25, // Patient Name
            'C' => 15, // Patient Mobile
            'D' => 15, // SSSP ID
            'E' => 18, // Appointment Date
            'F' => 20, // Doctor Name
            'G' => 15, // Doctor Type
            'H' => 20, // Hospital
            'I' => 12, // Record Type
            'J' => 15, // Type of Diabetes
            'K' => 20, // Family History Diabetes
            'L' => 20, // Current Treatment
            'M' => 12, // Compliance
            'N' => 15, // Blood Sugar Type
            'O' => 15, // Blood Sugar Value
            'P' => 20, // Diabetic Retinopathy (DR)
            'Q' => 25, // Diabetic Macular Edema (DME)
            'R' => 15, // Type of DR
            'S' => 15, // Type of DME
            'T' => 20, // Investigations
            'U' => 20, // Advised Treatment
            'V' => 18, // Treatment Done Date
            'W' => 15, // Review Date
            'X' => 30, // Other Data
            'Y' => 30, // Other Remarks
            'Z' => 18, // Created Date
        ];
    }
}