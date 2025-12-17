<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\PatientAppointment;

class SendWhatsAppFollowup extends Command
{
    protected $signature = 'patients:send-whatsapp-followups';
    protected $description = 'Send WhatsApp follow-up reminders 6 months after last visit';

    public function handle()
    {
        $today = Carbon::today()->toDateString();


        $this->info("Running followup WhatsApp job for {$today}");

        $appointments = PatientAppointment::whereRaw('patient_appointments.id = (
                SELECT p2.id FROM patient_appointments p2
                WHERE p2.patient_id = patient_appointments.patient_id
                ORDER BY p2.visit_date_time DESC
                LIMIT 1
            )')
            ->whereRaw('DATE(DATE_ADD(patient_appointments.visit_date_time, INTERVAL 6 MONTH)) = ?', [$today])
            ->with(['patient', 'doctor'])
            ->get();

        foreach ($appointments as $pa) {

            $patient = $pa->patient;
            $doctor  = $pa->doctor;

            if (!$patient || empty($patient->mobile_number)) {
                $this->warn("No patient/mobile for appointment {$pa->id}. Skipping.");
                continue;
            }

            // Build +91 format
            $mobile = "91" . preg_replace('/\D+/', '', $patient->mobile_number);

            // YOUR WHATSAPP TEMPLATE NAME
            $templateName = "appointment_followup";

            // Components for template
            $components = [
                    "body_1" => ["type" => "text", "value" => $patient->name],
                    "body_2" => ["type" => "text", "value" => $doctor->hospital_name],
                    "body_3" => ["type" => "text", "value" => $doctor->name],
            ];

            // Send WhatsApp using your existing helper
            sendWhatsapp($mobile, $templateName, $components);

            

            $this->info("WhatsApp sent to {$mobile} for appointment {$pa->id}");
        }

        $this->info("Job completed.");
    }
}
