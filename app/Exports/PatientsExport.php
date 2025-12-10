<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PatientsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $doctorId;
    protected $filters;
    protected $sortBy;
    protected $sortDirection;

    public function __construct($doctorId = null, $filters = [], $sortBy = 'created_at', $sortDirection = 'desc')
    {
        $this->doctorId = $doctorId;
        $this->filters = $filters;
        $this->sortBy = $sortBy;
        $this->sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'desc';
    }

    public function collection()
    {
        $query = Patient::query();

        // Eager load necessary relations
        if ($this->doctorId) {
            $query->with(['appointments' => function ($q) {
                $q->where('doctor_id', $this->doctorId)
                  ->orderBy('visit_date_time', 'desc');
            }]);
            $query->whereHas('appointments', fn($q) => $q->where('doctor_id', $this->doctorId));
        } else {
            $query->with(['appointments' => fn($q) => $q->orderBy('visit_date_time', 'desc')]);
        }

        $query->with('createdByDoctor');

        // === Filters ===
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('sssp_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['sex'])) {
            $query->where('sex', $this->filters['sex']);
        }

        if (!empty($this->filters['age'])) {
            $query->where('age', $this->filters['age']);
        }

        if (!empty($this->filters['last_visit_from'])) {
            $query->whereHas('appointments', function ($q) {
                if ($this->doctorId) $q->where('doctor_id', $this->doctorId);
                $q->whereDate('visit_date_time', '>=', $this->filters['last_visit_from']);
            });
        }

        if (!empty($this->filters['last_visit_to'])) {
            $query->whereHas('appointments', function ($q) {
                if ($this->doctorId) $q->where('doctor_id', $this->doctorId);
                $q->whereDate('visit_date_time', '<=', $this->filters['last_visit_to']);
            });
        }

        // === Sorting ===
        match ($this->sortBy) {
            'name'            => $query->orderBy('name', $this->sortDirection),
            'mobile_number'   => $query->orderBy('mobile_number', $this->sortDirection),
            'sssp_id'         => $query->orderBy('sssp_id', $this->sortDirection),
            'age'             => $query->orderBy('age', $this->sortDirection),

            // Sort by latest appointment date (doctor-specific if needed)
            'last_visit'      => $query->withMax(
                $this->doctorId ? 'appointments as doctor_appointments' : 'appointments',
                'visit_date_time'
            )->orderBy('appointments_max_visit_date_time', $this->sortDirection ?: 'desc'),

            // Total appointments (doctor-specific if needed)
            'total_appointments' => $query->withCount(
                $this->doctorId ? ['appointments as doctor_appointments_count' => fn($q) => $q->where('doctor_id', $this->doctorId)]
                                : 'appointments'
            )->orderBy('appointments_count', $this->sortDirection),

            default           => $query->orderBy('created_at', $this->sortDirection),
        };

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'SSSP ID',
            'Name',
            'Mobile Number',
            'Date of Birth',
            'Age',
            'Sex',
            'Address',
            'BMI',
            'Last Visit Date',
        ];
    }

    public function map($patient): array
    {
        // Get the correct latest appointment (already sorted desc in query)
        $appointments = $this->doctorId
            ? $patient->appointments->where('doctor_id', $this->doctorId)
            : $patient->appointments;

        $latestAppointment = $appointments->first();

        return [
            $patient->sssp_id ?? '-',
            $patient->name,
            $patient->mobile_number,
            $patient->date_of_birth?->format('M d, Y') ?? 'Not specified',
            $patient->age ?? '-',
            ucfirst($patient->sex ?? ''),
            $patient->short_address ?? '-',
            $patient->bmi ?? 'Not calculated',
            $latestAppointment
                ? $latestAppointment->visit_date_time->format('M d, Y H:i')
                : 'No appointments',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 25,
            'C' => 15,
            'D' => 14,
            'E' => 8,
            'F' => 8,
            'G' => 30,
            'H' => 10,
            'I' => 20,
        ];
    }
}