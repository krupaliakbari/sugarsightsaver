<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeder uses firstOrCreate to only create templates if they don't exist
        // This prevents overwriting custom email templates
        
        $templates = [
            [
                'template_key' => 'admin_doctor_registration_notification',
                'name' => 'Admin Doctor Registration Notification',
                'subject' => 'New Doctor Registration Received',
                'body' => '<style type="text/css">body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
</style>
<div class="container">
<div class="header">
<h2>{portal_name}</h2>
</div>

<div class="content">Hello Administrator,<br />
<br />
A new doctor has registered on the {portal_name}. Please review their details below:<br />
<strong>Name</strong>: {doctor_name}<br />
<strong>Email</strong>: {doctor_email}<br />
<strong>State</strong>: {state}<br />
<strong>Hospital name:</strong> {hospital_name}<br />
<strong>Contact Number:</strong>: {phone_number}<br />
<strong>Specialization:</strong> {specialization}<br />
<strong>Registration Date:</strong> {registration_date}<br />
<br />
Please verify and approve the doctor\'s account at your earliest convenience.<br />
Thank you,<br />
{portal_name}</div>
</div>',
                'description' => 'Email sent to admin when a new doctor registers',
                'variables' => ['portal_name', 'doctor_name', 'doctor_email', 'state', 'hospital_name', 'phone_number', 'specialization', 'registration_date', 'site_email'],
                'is_active' => true,
            ],
            [
                'template_key' => 'admin_password_reset',
                'name' => 'Admin Password Reset',
                'subject' => 'Password Reset Request – {portal_name}',
                'body' => '<style type="text/css">body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
</style>
<div class="container">
<div class="header">
<h2>{portal_name}</h2>
</div>

<div class="content">Dear Administrator,<br />
<br />
We received a request to reset your password.<br />
To proceed, click the link below:<br />
<br />
{reset_link}<br />
<br />
Stay secure,<br />
Team {portal_name}</div>
</div>',
                'description' => 'Email sent to admin when they request a password reset',
                'variables' => ['site_name', 'reset_link', 'site_email'],
                'is_active' => true,
            ],
            [
                'template_key' => 'doctor_approval',
                'name' => 'Doctor Approval',
                'subject' => 'Congratulations Dr. {doctor_name} – Your Account Has Been Approved!',
                'body' => '<style type="text/css">body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                        .button { display: inline-block; background: #634299; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                        .text-white { color: white !important; }
</style>
<div class="container">
<div class="header">
<h2>{portal_name}</h2>
</div>

<div class="content">Dear Dr. {doctor_name},<br />
<br />
We are pleased to inform you that your account has been approved successfully.<br />
You can now log in and start managing your profile and appointments.<br />
<br />
Login Now: {login_url}<br />
<br />
Welcome aboard,<br />
Team {portal_name}</div>
</div>',
                'description' => 'Email sent to doctor when their account is approved',
                'variables' => ['site_name', 'doctor_name', 'login_url', 'site_email'],
                'is_active' => true,
            ],
            [
                'template_key' => 'doctor_password_reset',
                'name' => 'Doctor Password Reset',
                'subject' => 'Password Reset Request – {portal_name}',
                'body' => '<style type="text/css">body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
</style>
<div class="container">
<div class="header">
<h2>{portal_name}</h2>
</div>

<div class="content">Dear Dr. {doctor_name},<br />
<br />
We received a request to reset your password.<br />
To proceed, click the link below:<br />
<br />
{reset_link}<br />
Stay secure,<br />
<br />
Team {portal_name}</div>
</div>',
                'description' => 'Email sent to doctor when they request a password reset',
                'variables' => ['site_name', 'reset_link', 'site_email'],
                'is_active' => true,
            ],
            [
                'template_key' => 'doctor_registration',
                'name' => 'Doctor Registration Confirmation',
                'subject' => 'Welcome Dr. {doctor_name} – Your Registration is Pending Approval',
                'body' => '<style type="text/css">body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
</style>
<div class="container">
<div class="header">
<h2>{portal_name}</h2>
</div>

<div class="content">Dear Dr. {doctor_name},<br />
Thank you for registering with {portal_name}.<br />
Your account is currently under review by our team. Once approved, you will receive a confirmation email to access your dashboard.<br />
<br />
If you have any questions, please contact us at {admin_email}.<br />
<br />
Warm regards,<br />
Team {portal_name}.</div>
</div>',
                'description' => 'Email sent to doctor after registration, informing them their account is pending approval',
                'variables' => ['portal_name', 'doctor_name', 'admin_email'],
                'is_active' => true,
            ],
            [
                'template_key' => 'doctor_rejection',
                'name' => 'Doctor Rejection',
                'subject' => 'Update on Your {portal_name} Registration',
                'body' => '<style type="text/css">body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                        .highlight { background: #ffe6e6; padding: 15px; border-left: 4px solid #dc3545; margin: 20px 0; border-radius: 4px; }
</style>
<div class="container">
<div class="header">
<h2>{portal_name}</h2>
</div>

<div class="content">Dear Dr. {doctor_name},<br />
We regret to inform you that your registration could not be approved at this time due to {reason}.<br />
<br />
You may update your profile and reapply for verification<br />
If you believe this was an error, please reach out to us at {admin_email}<br />
<br />
Thank you for your interest in {portal_name}.<br />
<br />
Best regards,<br />
Team {portal_name}</div>
</div>',
                'description' => 'Email sent to doctor when their registration is rejected',
                'variables' => ['site_name', 'doctor_name', 'reason', 'site_email'],
                'is_active' => true,
            ],
            [
                'template_key' => 'patient_registration',
                'name' => 'Patient Registration Confirmation',
                'subject' => 'Welcome to Sugar Sight Saver - Registration Confirmation',
                'body' => '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                        .highlight { background: #e8f4fd; padding: 15px; border-left: 4px solid #634299; margin: 20px 0; border-radius: 4px; }
                    </style>
                </head>
                <body>
                    <div class=\'container\'>
                        <div class=\'header\'>
                            <h2>{site_name}</h2>
                        </div>
                        <div class=\'content\'>
                            <h3>Welcome to {site_name} - Registration Confirmation</h3>
                            <p>Dear {patient_name},</p>
                            <p>Thank you for registering with <strong>{clinic_name}</strong> under the care of <strong>Dr. {doctor_name}</strong>.</p>
                            <div class=\'highlight\'>
                                <p><strong>Your registration is successful!</strong></p>
                            </div>
                            <p>We are committed to providing you with the best diabetes care and management services.</p>
                            <p>If you have any questions or need assistance, please feel free to contact us:</p>
                            <p><strong>Phone:</strong> {site_phone}</p>
                            <p><strong>Email:</strong> <a href=\'mailto:{site_email}\'>{site_email}</a></p>
                            <p>Welcome aboard,<br>Team {site_name}</p>
                        </div>
                        <div class=\'footer\'>
                            <p>This email was sent from {site_name}</p>
                            <p>If you have any questions, please contact us at {site_email}</p>
                        </div>
                    </div>
                </body>
                </html>
            ',
                'description' => 'Email sent to patient after registration',
                'variables' => ['patient_name', 'clinic_name', 'doctor_name', 'site_phone', 'site_email', 'site_name'],
                'is_active' => true,
            ],
            [
                'template_key' => 'six_month_reminder',
                'name' => 'Six Month Follow-up Reminder',
                'subject' => 'Follow-up Reminder - Sugar Sight Saver',
                'body' => '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                        .highlight { background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0; border-radius: 4px; }
                        .button { display: inline-block; background: #634299; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                    </style>
                </head>
                <body>
                    <div class=\'container\'>
                        <div class=\'header\'>
                            <h2>{site_name}</h2>
                        </div>
                        <div class=\'content\'>
                            <h3>Follow-up Reminder</h3>
                            <p>Dear {patient_name},</p>
                            <div class=\'highlight\'>
                                <p><strong>It\'s been 6 months since your last visit.</strong></p>
                            </div>
                            <p>Regular follow-up appointments are essential for better diabetes management and monitoring your health progress.</p>
                            <p>We encourage you to schedule your follow-up appointment at your earliest convenience.</p>
                            <p><strong>Contact Information:</strong></p>
                            <p><strong>Phone:</strong> {site_phone}</p>
                            <p><strong>Email:</strong> <a href=\'mailto:{site_email}\'>{site_email}</a></p>
                            <p>Your health is our priority. We look forward to seeing you soon.</p>
                            <p>Best regards,<br>Team {site_name}</p>
                        </div>
                        <div class=\'footer\'>
                            <p>This email was sent from {site_name}</p>
                            <p>If you have any questions, please contact us at {site_email}</p>
                        </div>
                    </div>
                </body>
                </html>
            ',
                'description' => 'Email sent to patient for 6-month follow-up reminder',
                'variables' => ['patient_name', 'site_phone', 'site_email', 'site_name'],
                'is_active' => true,
            ],
            [
                'template_key' => 'three_month_report_reminder',
                'name' => 'Three Month Report Reminder',
                'subject' => 'Your Diabetes Report is Ready - Sugar Sight Saver',
                'body' => '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                        .highlight { background: #d1ecf1; padding: 15px; border-left: 4px solid #17a2b8; margin: 20px 0; border-radius: 4px; }
                        .info-box { background: #fff; padding: 15px; border: 2px solid #634299; border-radius: 5px; margin: 20px 0; }
                        .info-label { font-weight: bold; color: #634299; }
                    </style>
                </head>
                <body>
                    <div class=\'container\'>
                        <div class=\'header\'>
                            <h2>{site_name}</h2>
                        </div>
                        <div class=\'content\'>
                            <h3>Your Diabetes Report is Ready</h3>
                            <p>Dear {patient_name},</p>
                            <div class=\'highlight\'>
                                <p><strong>Your 3-month diabetes report is ready for collection!</strong></p>
                            </div>
                            <div class=\'info-box\'>
                                <p><span class=\'info-label\'>Your SSSP ID:</span> {sssp_id}</p>
                            </div>
                            <p>Please visit your doctor to collect your report. This report contains important information about your diabetes management progress over the past 3 months.</p>
                            <p><strong>Contact Information:</strong></p>
                            <p><strong>Phone:</strong> {site_phone}</p>
                            <p><strong>Email:</strong> <a href=\'mailto:{site_email}\'>{site_email}</a></p>
                            <p>If you have any questions about your report, please don\'t hesitate to contact us.</p>
                            <p>Best regards,<br>Team {site_name}</p>
                        </div>
                        <div class=\'footer\'>
                            <p>This email was sent from {site_name}</p>
                            <p>If you have any questions, please contact us at {site_email}</p>
                        </div>
                    </div>
                </body>
                </html>
            ',
                'description' => 'Email sent to patient when their 3-month diabetes report is ready',
                'variables' => ['patient_name', 'sssp_id', 'site_phone', 'site_email', 'site_name'],
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            // Only create if template doesn't exist - don't update existing templates
            EmailTemplate::firstOrCreate(
                ['template_key' => $template['template_key']],
                $template
            );
        }

        $this->command->info('Email templates backup restored! (Only new templates were created, existing ones were preserved)');
    }
}
