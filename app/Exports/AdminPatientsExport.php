<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdminPatientsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $patients;

    public function __construct($patients = null)
    {
        $this->patients = $patients;
    }

    public function collection()
    {
        if ($this->patients) {
            return $this->patients;
        }
        
        // If no patients provided, return all patients
        return Patient::with(['createdByDoctor'])->get();
    }

    public function headings(): array
    {
		return [
			// Required leading fields in exact order
			'SSSP ID',
			'Name',
			'Mobile Number',
			'Date of Birth',
			'Age',
			'Sex',
			'Address',
			'BMI',
			'Last visit Date'
		];
    }

	public function map($patient): array
    {
        $latestAppointment = $patient->latestAppointment();
		
		return [
			// Required leading fields
			$patient->sssp_id,
			$patient->name,
			$patient->mobile_number,
			$patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'Not specified',
			$patient->age,
			ucfirst($patient->sex),
			$patient->short_address,
			$patient->bmi ?? 'Not calculated',
			$latestAppointment ? $latestAppointment->visit_date_time->format('M d, Y H:i') : 'No appointments'
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
			'A' => 15, // SSSP ID
			'B' => 25, // Name
			'C' => 15, // Mobile Number
			'D' => 14, // Date of Birth
			'E' => 8,  // Age
			'F' => 8,  // Sex
			'G' => 30, // Address
			'H' => 10, // BMI
			'I' => 18, // Last visit Date
		];
    }
}
