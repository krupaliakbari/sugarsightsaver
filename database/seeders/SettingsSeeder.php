<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Site Information
        Setting::set('site_name', 'Sugar Sight Saver', 'string', 'Site name');
        Setting::set('site_email', 'test.wtd3@gmail.com', 'string', 'Site email address');
        Setting::set('site_phone', '', 'string', 'Site phone number');
        Setting::set('site_address', '', 'string', 'Site address');

        // SMTP Configuration (WTD details)
        Setting::set('smtp_host', 'smtp.gmail.com', 'string', 'SMTP host');
        Setting::set('smtp_port', 465, 'integer', 'SMTP port');
        Setting::set('smtp_username', 'test.wtd3@gmail.com', 'string', 'SMTP username');
        Setting::set('smtp_password', 'xywb lymj tflu nazz', 'string', 'SMTP password');
        Setting::set('smtp_encryption', 'ssl', 'string', 'SMTP encryption');

        // SMS Templates
        Setting::set('patient_registration_sms', 'Dear {patient_name}, thank you for registering with {clinic_name} under the care of Dr. {doctor_name}. Your registration is successful.', 'string', 'Patient registration SMS template');
        Setting::set('six_month_reminder_sms', 'Dear {patient_name}, it\'s been 6 months since your last visit. Please schedule your follow-up appointment for better diabetes management. Contact: {site_phone}', 'string', 'Six month reminder SMS template');
        Setting::set('three_month_report_reminder_sms', 'Dear {patient_name}, your 3-month diabetes report is ready. Please collect it from your doctor. SSSP ID: {sssp_id}. Contact: {site_phone}', 'string', 'Three month report reminder SMS template');
    }
}