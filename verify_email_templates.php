<?php

/**
 * Script to verify all email templates by sending test emails
 * Run: php verify_email_templates.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EmailTemplate;
use App\Services\MailService;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

$testEmail = 'divyesh.makwana@gmail.com';

echo "Email Template Verification Script\n";
echo "===================================\n\n";
echo "Sending test emails to: {$testEmail}\n\n";

// Get all email templates
$templates = EmailTemplate::where('is_active', true)->orderBy('name')->get();

if ($templates->isEmpty()) {
    echo "No active email templates found.\n";
    exit(1);
}

// Sample data for variable replacement
$sampleData = [
    'portal_name' => 'Sugar Sight Saver',
    'site_name' => 'Sugar Sight Saver',
    'doctor_name' => 'Dr. John Smith',
    'admin_email' => 'admin@sugarsight.com',
    'site_email' => 'admin@sugarsight.com',
    'reset_link' => 'https://sugar.test/reset-password?token=test-token-12345',
    'login_url' => 'https://sugar.test/doctor/login',
    'reason' => 'Incomplete documentation',
    'doctor_email' => 'doctor@example.com',
    'state' => 'Gujarat',
    'hospital_name' => 'City Hospital',
    'phone_number' => '9876543210',
    'specialization' => 'Diabetes-Treating Physician',
    'registration_date' => date('F d, Y h:i A'),
    'patient_name' => 'Rajesh Kumar',
    'clinic_name' => 'City Clinic',
    'sssp_id' => 'SSSP123456',
    'site_phone' => '+91 9876543210',
];

$successCount = 0;
$failCount = 0;

foreach ($templates as $template) {
    echo "Processing: {$template->name} ({$template->template_key})...\n";
    
    try {
        // Replace variables in subject and body
        $subject = $template->subject;
        $body = $template->body;
        
        foreach ($sampleData as $key => $value) {
            $subject = str_replace('{' . $key . '}', $value, $subject);
            $subject = str_replace('{# ' . $key . ' #}', $value, $subject);
            $body = str_replace('{' . $key . '}', $value, $body);
            $body = str_replace('{# ' . $key . ' #}', $value, $body);
        }
        
        // Add template info to subject for verification
        $subject = "[VERIFICATION] {$subject}";
        
        // Ensure body is HTML - check if it contains HTML tags
        $isHtml = strip_tags($body) !== $body;
        
        if ($isHtml) {
            // Check if body has complete HTML structure
            if (stripos($body, '<html') === false) {
                // Extract style if it exists separately
                $styleContent = '';
                if (preg_match('/<style[^>]*>(.*?)<\/style>/is', $body, $styleMatches)) {
                    $styleContent = trim($styleMatches[1]);
                    // Remove style tag from body
                    $body = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $body);
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
                $body = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        ' . $styleContent . '
    </style>
</head>
<body>
    ' . trim($body) . '
</body>
</html>';
            }
            
            // Send as HTML email
            MailService::configureMailSettings();
            $siteEmail = Setting::get('site_email', 'test.wtd3@gmail.com');
            $siteName = Setting::get('site_name', 'Sugar Sight Saver');
            
            Mail::html($body, function($mail) use ($testEmail, $subject, $siteEmail, $siteName) {
                $mail->to($testEmail)
                     ->subject($subject)
                     ->from($siteEmail, $siteName);
            });
        } else {
            // If no HTML tags, wrap in basic HTML structure
            $htmlBody = '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="header">
                            <h2>' . htmlspecialchars($sampleData['portal_name']) . '</h2>
                        </div>
                        <div class="content">
                            ' . nl2br(htmlspecialchars($body)) . '
                        </div>
                        <div class="footer">
                            <p>This email was sent from ' . htmlspecialchars($sampleData['portal_name']) . '</p>
                        </div>
                    </div>
                </body>
                </html>
            ';
            
            MailService::configureMailSettings();
            $siteEmail = Setting::get('site_email', 'test.wtd3@gmail.com');
            $siteName = Setting::get('site_name', 'Sugar Sight Saver');
            
            Mail::html($htmlBody, function($mail) use ($testEmail, $subject, $siteEmail, $siteName) {
                $mail->to($testEmail)
                     ->subject($subject)
                     ->from($siteEmail, $siteName);
            });
        }
        
        echo "  ✓ Sent successfully\n";
        $successCount++;
        
        // Small delay between emails to avoid rate limiting
        usleep(500000); // 0.5 seconds instead of 2 seconds
        
    } catch (\Exception $e) {
        echo "  ✗ Failed: " . $e->getMessage() . "\n";
        $failCount++;
    }
    
    echo "\n";
}

echo "===================================\n";
echo "Verification Complete!\n";
echo "Total templates: " . $templates->count() . "\n";
echo "Successfully sent: {$successCount}\n";
echo "Failed: {$failCount}\n";
echo "\n";
echo "Please check your email at: {$testEmail}\n";
echo "Each email will have [VERIFICATION] prefix in the subject.\n";

