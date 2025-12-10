<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\PatientAppointment;
use App\Models\Setting;
use App\Models\EmailTemplate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReminderService
{
    protected $twoFactorService;

    public function __construct()
    {
        $this->twoFactorService = new TwoFactorService();
    }
    /**
     * Send 6-month follow-up reminders
     */
    public function sendSixMonthReminders()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        
        // Find patients who haven't had an appointment in 6 months
        $patients = Patient::whereDoesntHave('appointments', function($query) use ($sixMonthsAgo) {
            $query->where('visit_date_time', '>', $sixMonthsAgo);
        })->get();

        $sentCount = 0;
        
        foreach ($patients as $patient) {
            try {
                $this->sendReminder($patient, 'six_month_reminder');
                $sentCount++;
                Log::info("6-month reminder sent to patient: {$patient->name} (ID: {$patient->id})");
            } catch (\Exception $e) {
                Log::error("Failed to send 6-month reminder to patient {$patient->id}: " . $e->getMessage());
            }
        }

        return $sentCount;
    }

    /**
     * Send 3-month report reminders
     */
    public function sendThreeMonthReportReminders()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);
        
        // Find patients who had appointments 3 months ago
        $patients = Patient::whereHas('appointments', function($query) use ($threeMonthsAgo) {
            $query->where('visit_date_time', '>=', $threeMonthsAgo)
                  ->where('visit_date_time', '<=', $threeMonthsAgo->addDays(7));
        })->get();

        $sentCount = 0;
        
        foreach ($patients as $patient) {
            try {
                $this->sendReminder($patient, 'three_month_report_reminder');
                $sentCount++;
                Log::info("3-month report reminder sent to patient: {$patient->name} (ID: {$patient->id})");
            } catch (\Exception $e) {
                Log::error("Failed to send 3-month report reminder to patient {$patient->id}: " . $e->getMessage());
            }
        }

        return $sentCount;
    }

    /**
     * Send patient registration confirmation
     */
    public function sendPatientRegistrationConfirmation($patient)
    {
        try {
            Log::info("Starting registration confirmation for patient: {$patient->name} (ID: {$patient->id}), Mobile: {$patient->mobile_number}");
            $this->sendReminder($patient, 'patient_registration');
            Log::info("Registration confirmation process completed for patient: {$patient->name} (ID: {$patient->id})");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send registration confirmation to patient {$patient->id}: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send reminder to patient
     */
    private function sendReminder($patient, $reminderType)
    {
        $template = $this->getTemplate($reminderType);
        $message = $this->replaceVariables($template, $patient);
        
        // Send via email if email is available (non-blocking - don't fail if email sending fails)
        if ($patient->email) {
            try {
                $this->sendEmail($patient, $message, $reminderType);
            } catch (\Exception $e) {
                Log::warning("Failed to send email to patient {$patient->id}: " . $e->getMessage());
                // Continue with SMS/WhatsApp even if email fails
            }
        }
        
        // Send via SMS if mobile number is available (for patient registration)
        if ($patient->mobile_number && $reminderType === 'patient_registration') {
            Log::info("Attempting to send SMS to patient {$patient->name} (ID: {$patient->id}), Mobile: {$patient->mobile_number}");
            $this->sendSMS($patient, $message);
        } else {
            if (!$patient->mobile_number) {
                Log::warning("Cannot send SMS to patient {$patient->id}: No mobile number");
            }
        }
        
        // Send via WhatsApp if mobile number is available (for other reminders)
        if ($patient->mobile_number && $reminderType !== 'patient_registration') {
            $this->sendWhatsApp($patient, $message);
        }
    }

    /**
     * Get template content
     */
    private function getTemplate($reminderType)
    {
        $templates = [
            'patient_registration' => Setting::get('patient_registration_sms', 'Dear {patient_name}, thank you for registering with {clinic_name} under the care of Dr. {doctor_name}. Your registration is successful.'),
            'six_month_reminder' => Setting::get('six_month_reminder_sms', 'Dear {patient_name}, it\'s been 6 months since your last visit. Please schedule your follow-up appointment for better diabetes management. Contact: {site_phone}'),
            'three_month_report_reminder' => Setting::get('three_month_report_reminder_sms', 'Dear {patient_name}, your 3-month diabetes report is ready. Please collect it from your doctor. SSSP ID: {sssp_id}. Contact: {site_phone}')
        ];

        return $templates[$reminderType] ?? '';
    }

    /**
     * Replace variables in template
     */
    private function replaceVariables($template, $patient)
    {
        // Get doctor information
        $doctor = $patient->createdByDoctor;
        $doctorName = $doctor ? $doctor->name : 'Doctor';
        
        // Get clinic name from doctor's hospital_name or site_name
        $clinicName = $doctor && $doctor->hospital_name 
            ? $doctor->hospital_name 
            : Setting::get('site_name', 'Sugar Sight Saver');
        
        $variables = [
            '{patient_name}' => $patient->name,
            '{#patient_name#}' => $patient->name, // Support both formats
            '{sssp_id}' => $patient->sssp_id,
            '{doctor_name}' => $doctorName,
            '{#doctor_name#}' => $doctorName, // Support both formats
            '{clinic_name}' => $clinicName,
            '{#clinic_name#}' => $clinicName, // Support both formats
            '{site_phone}' => Setting::get('site_phone', 'Contact us'),
            '{site_email}' => Setting::get('site_email', 'admin@sugarsight.com'),
            '{site_name}' => Setting::get('site_name', 'Sugar Sight Saver'),
        ];

        return str_replace(array_keys($variables), array_values($variables), $template);
    }

    /**
     * Send email reminder
     */
    private function sendEmail($patient, $message, $reminderType)
    {
        try {
            // Get site email from settings for "From" address
            $fromEmail = Setting::get('site_email', config('mail.from.address', 'noreply@sugarsight.com'));
            $fromName = Setting::get('site_name', config('mail.from.name', 'Sugar Sight Saver'));
            
            // Try to get email template from database
            $emailTemplate = EmailTemplate::getByKey($reminderType);
            
            if ($emailTemplate) {
                // Get variables for template
                $doctor = $patient->createdByDoctor;
                $doctorName = $doctor ? $doctor->name : 'Doctor';
                $clinicName = $doctor && $doctor->hospital_name 
                    ? $doctor->hospital_name 
                    : Setting::get('site_name', 'Sugar Sight Saver');
                
                $variables = [
                    'patient_name' => $patient->name,
                    'sssp_id' => $patient->sssp_id,
                    'doctor_name' => $doctorName,
                    'clinic_name' => $clinicName,
                    'site_phone' => Setting::get('site_phone', 'Contact us'),
                    'site_email' => Setting::get('site_email', 'admin@sugarsight.com'),
                    'site_name' => Setting::get('site_name', 'Sugar Sight Saver'),
                ];
                
                // Process template with variables
                $processed = $emailTemplate->replaceVariables($variables);
                $subject = $processed['subject'];
                $emailBody = $processed['body'];
                
                // Check if body contains HTML tags
                $isHtml = strip_tags($emailBody) !== $emailBody;
                
                if ($isHtml) {
                    // Ensure body has complete HTML structure with header
                    if (stripos($emailBody, '<html') === false) {
                        // Extract style if it exists separately
                        $styleContent = '';
                        if (preg_match('/<style[^>]*>(.*?)<\/style>/is', $emailBody, $styleMatches)) {
                            $styleContent = trim($styleMatches[1]);
                            // Remove style tag from body
                            $emailBody = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $emailBody);
                        }
                        
                        // If no style was extracted, use default
                        if (empty($styleContent)) {
                            $styleContent = 'body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }';
                        }
                        
                        // Wrap in complete HTML structure
                        $emailBody = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        ' . $styleContent . '
    </style>
</head>
<body>
    ' . trim($emailBody) . '
</body>
</html>';
                    }
                    
                    Mail::html($emailBody, function($mail) use ($patient, $subject, $fromEmail, $fromName) {
                        $mail->from($fromEmail, $fromName)
                             ->to($patient->email)
                             ->subject($subject);
                    });
                } else {
                    Mail::raw($emailBody, function($mail) use ($patient, $subject, $fromEmail, $fromName) {
                        $mail->from($fromEmail, $fromName)
                             ->to($patient->email)
                             ->subject($subject);
                    });
                }
            } else {
                // Fallback to old method (plain text from settings)
                $subject = $this->getEmailSubject($reminderType);
                Mail::raw($message, function($mail) use ($patient, $subject, $fromEmail, $fromName) {
                    $mail->from($fromEmail, $fromName)
                         ->to($patient->email)
                         ->subject($subject);
                });
            }
            
            Log::info("Email sent successfully to patient {$patient->name} (ID: {$patient->id})");
        } catch (\Exception $e) {
            Log::error("Failed to send email to patient {$patient->id}: " . $e->getMessage());
            throw $e; // Re-throw to be caught by caller
        }
    }

    /**
     * Get email subject based on reminder type (fallback method)
     */
    private function getEmailSubject($reminderType)
    {
        $subjects = [
            'patient_registration' => 'Welcome to Sugar Sight Saver - Registration Confirmation',
            'six_month_reminder' => 'Follow-up Reminder - Sugar Sight Saver',
            'three_month_report_reminder' => 'Your Diabetes Report is Ready - Sugar Sight Saver'
        ];

        return $subjects[$reminderType] ?? 'Reminder from Sugar Sight Saver';
    }

    /**
     * Send SMS via 2Factor.in
     */
    private function sendSMS($patient, $message)
    {
        try {
            Log::info("sendSMS called for patient {$patient->name} (ID: {$patient->id}), Mobile: {$patient->mobile_number}");
            
            if (!$this->twoFactorService->isConfigured()) {
                Log::warning("2Factor.in is not configured. SMS not sent to patient {$patient->name} (ID: {$patient->id})");
                return false;
            }

            Log::info("2Factor service is configured. Calling sendSMS with mobile: {$patient->mobile_number}");
            $result = $this->twoFactorService->sendSMS($patient->mobile_number, $message);
            
            Log::info("2Factor sendSMS result", ['result' => $result]);
            
            if ($result['success']) {
                Log::info("SMS sent successfully to patient {$patient->name} (ID: {$patient->id})");
                return true;
            } else {
                Log::error("Failed to send SMS to patient {$patient->id}: " . ($result['message'] ?? 'Unknown error'));
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Exception while sending SMS to patient {$patient->id}: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send WhatsApp message
     */
    private function sendWhatsApp($patient, $message)
    {
        $phoneNumber = $this->formatPhoneNumber($patient->mobile_number);
        $whatsappUrl = "https://wa.me/{$phoneNumber}?text=" . urlencode($message);
        
        // Log WhatsApp URL for manual sending or integration with WhatsApp API
        Log::info("WhatsApp URL for patient {$patient->name}: {$whatsappUrl}");
        
        // For now, we'll log the URL. In production, you would integrate with WhatsApp Business API
        return $whatsappUrl;
    }

    /**
     * Format phone number for WhatsApp
     */
    private function formatPhoneNumber($phoneNumber)
    {
        // Remove all non-numeric characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Add country code if not present (assuming India +91)
        if (strlen($phoneNumber) == 10) {
            $phoneNumber = '91' . $phoneNumber;
        }
        
        return $phoneNumber;
    }

    /**
     * Get reminder statistics
     */
    public function getReminderStats()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $threeMonthsAgo = Carbon::now()->subMonths(3);
        
        return [
            'patients_due_six_month' => Patient::whereDoesntHave('appointments', function($query) use ($sixMonthsAgo) {
                $query->where('visit_date_time', '>', $sixMonthsAgo);
            })->count(),
            
            'patients_due_three_month' => Patient::whereHas('appointments', function($query) use ($threeMonthsAgo) {
                $query->where('visit_date_time', '>=', $threeMonthsAgo)
                      ->where('visit_date_time', '<=', $threeMonthsAgo->addDays(7));
            })->count(),
            
            'total_patients' => Patient::count()
        ];
    }
}
