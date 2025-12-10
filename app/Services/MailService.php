<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Exception;

class MailService
{
    /**
     * Configure mail settings from database
     */
    public static function configureMailSettings()
    {
        $smtpSettings = Setting::getSmtpSettings();
        
        // Only configure if SMTP settings are available
        if (!empty($smtpSettings['smtp_host'])) {
            Config::set('mail.mailers.smtp.host', $smtpSettings['smtp_host']);
            Config::set('mail.mailers.smtp.port', $smtpSettings['smtp_port']);
            Config::set('mail.mailers.smtp.username', $smtpSettings['smtp_username']);
            Config::set('mail.mailers.smtp.password', $smtpSettings['smtp_password']);
            Config::set('mail.mailers.smtp.encryption', $smtpSettings['smtp_encryption']);
            Config::set('mail.from.address', $smtpSettings['site_email']);
            Config::set('mail.from.name', $smtpSettings['site_name']);
        }
    }

    /**
     * Get email template from database and replace variables
     */
    private static function getEmailTemplate($templateKey, $variables = [])
    {
        $template = EmailTemplate::getByKey($templateKey);
        
        if ($template) {
            $processed = $template->replaceVariables($variables);
            $body = $processed['body'];
            
            // Ensure body has complete HTML structure with header
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
            
            return [
                'subject' => $processed['subject'],
                'body' => $body
            ];
        }
        
        // Return null if template not found (caller should use fallback)
        return null;
    }

    /**
     * Send password reset email for admin
     */
    public static function sendAdminPasswordReset($email, $resetLink)
    {
        try {
            self::configureMailSettings();
            
            $siteName = Setting::get('site_name', 'Sugar Sight Saver');
            $siteEmail = Setting::get('site_email', 'test.wtd3@gmail.com');
            
            // Try to get template from database
            $templateData = self::getEmailTemplate('admin_password_reset', [
                'site_name' => $siteName,
                'reset_link' => $resetLink,
                'site_email' => $siteEmail
            ]);
            
            if ($templateData) {
                $subject = $templateData['subject'];
                $message = $templateData['body'];
            } else {
                // Fallback to hardcoded template
                $subject = "Password Reset Request - {$siteName}";
                $message = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                            .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                            .button { display: inline-block; background: #634299; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                            .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>{$siteName}</h2>
                            </div>
                            <div class='content'>
                                <h3>Password Reset Request</h3>
                                <p>Hello,</p>
                                <p>You have requested to reset your password for your admin account. Click the button below to reset your password:</p>
                                <p style='text-align: center;'>
                                    <a href='{$resetLink}' class='button'>Reset Password</a>
                                </p>
                                <p>If the button doesn't work, copy and paste this link into your browser:</p>
                                <p style='word-break: break-all; background: #eee; padding: 10px; border-radius: 4px;'>{$resetLink}</p>
                                <p><strong>This link will expire in 1 hour for security reasons.</strong></p>
                                <p>If you didn't request this password reset, please ignore this email.</p>
                            </div>
                            <div class='footer'>
                                <p>This email was sent from {$siteName}</p>
                                <p>If you have any questions, please contact us at {$siteEmail}</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";
            }
            
            Mail::html($message, function($mail) use ($email, $subject, $siteEmail, $siteName) {
                $mail->to($email)
                     ->subject($subject)
                     ->from($siteEmail, $siteName);
            });
            
            Log::info("Admin password reset email sent to: {$email}");
            return true;
            
        } catch (Exception $e) {
            Log::error("Failed to send admin password reset email to {$email}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send password reset email for doctor
     */
    public static function sendDoctorPasswordReset($email, $resetLink)
    {
        try {
            self::configureMailSettings();
            
            $siteName = Setting::get('site_name', 'Sugar Sight Saver');
            $siteEmail = Setting::get('site_email', 'test.wtd3@gmail.com');
            
            // Try to get template from database
            $templateData = self::getEmailTemplate('doctor_password_reset', [
                'site_name' => $siteName,
                'reset_link' => $resetLink,
                'site_email' => $siteEmail
            ]);
            
            if ($templateData) {
                $subject = $templateData['subject'];
                $message = $templateData['body'];
            } else {
                // Fallback to hardcoded template
                $subject = "Password Reset Request - {$siteName}";
                $message = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                            .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                            .button { display: inline-block; background: #634299; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                            .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>{$siteName}</h2>
                            </div>
                            <div class='content'>
                                <h3>Password Reset Request</h3>
                                <p>Hello Doctor,</p>
                                <p>You have requested to reset your password for your doctor account. Click the button below to reset your password:</p>
                                <p style='text-align: center;'>
                                    <a href='{$resetLink}' class='button'>Reset Password</a>
                                </p>
                                <p>If the button doesn't work, copy and paste this link into your browser:</p>
                                <p style='word-break: break-all; background: #eee; padding: 10px; border-radius: 4px;'>{$resetLink}</p>
                                <p><strong>This link will expire in 1 hour for security reasons.</strong></p>
                                <p>If you didn't request this password reset, please ignore this email.</p>
                            </div>
                            <div class='footer'>
                                <p>This email was sent from {$siteName}</p>
                                <p>If you have any questions, please contact us at {$siteEmail}</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";
            }
            
            Mail::html($message, function($mail) use ($email, $subject, $siteEmail, $siteName) {
                $mail->to($email)
                     ->subject($subject)
                     ->from($siteEmail, $siteName);
            });
            
            Log::info("Doctor password reset email sent to: {$email}");
            return true;
            
        } catch (Exception $e) {
            Log::error("Failed to send doctor password reset email to {$email}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send doctor registration confirmation email
     */
    public static function sendDoctorRegistrationEmail($email, $doctorName)
    {
        try {
            self::configureMailSettings();
            
            $portalName = Setting::get('site_name', 'Sugar Sight Saver');
            $adminEmail = Setting::get('site_email', 'test.wtd3@gmail.com');
            
            // Try to get template from database
            $templateData = self::getEmailTemplate('doctor_registration', [
                'portal_name' => $portalName,
                'doctor_name' => $doctorName,
                'admin_email' => $adminEmail
            ]);
            
            if ($templateData) {
                $subject = $templateData['subject'];
                $message = $templateData['body'];
            } else {
                // Fallback to hardcoded template
                $subject = "Welcome Dr. {$doctorName} – Your Registration is Pending Approval";
                $message = "
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
                        <div class='container'>
                            <div class='header'>
                                <h2>{$portalName}</h2>
                            </div>
                            <div class='content'>
                                <p>Dear Dr. {$doctorName},</p>
                                <p>Thank you for registering with {$portalName}.</p>
                                <p>Your account is currently under review by our team. Once approved, you will receive a confirmation email to access your dashboard.</p>
                                <p>If you have any questions, please contact us at <a href='mailto:{$adminEmail}'>{$adminEmail}</a>.</p>
                                <p>Warm regards,<br>Team {$portalName}.</p>
                            </div>
                            <div class='footer'>
                                <p>This email was sent from {$portalName}</p>
                                <p>If you have any questions, please contact us at {$adminEmail}</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";
            }
            
            Mail::html($message, function($mail) use ($email, $subject, $adminEmail, $portalName) {
                $mail->to($email)
                     ->subject($subject)
                     ->from($adminEmail, $portalName);
            });
            
            Log::info("Doctor registration email sent to: {$email}");
            return true;
            
        } catch (Exception $e) {
            Log::error("Failed to send doctor registration email to {$email}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send admin notification email when a doctor registers
     */
    public static function sendAdminDoctorRegistrationNotification($doctorName, $doctorEmail, $doctorData = [])
    {
        try {
            self::configureMailSettings();
            
            $portalName = Setting::get('site_name', 'Sugar Sight Saver');
            $siteEmail = Setting::get('site_email', 'test.wtd3@gmail.com');
            $adminEmail = $siteEmail; // Admin notification email from Site Email setting
            
            // Format doctor type for specialization
            $specialization = 'N/A';
            if (isset($doctorData['doctor_type'])) {
                $specialization = match($doctorData['doctor_type']) {
                    'diabetes_treating' => 'Diabetes-Treating Physician',
                    'ophthalmologist' => 'Ophthalmologist',
                    default => ucfirst(str_replace('_', ' ', $doctorData['doctor_type']))
                };
            }
            
            // Get phone number (if available)
            $phoneNumber = isset($doctorData['phone']) && !empty($doctorData['phone']) ? $doctorData['phone'] : 'N/A';
            
            // Format registration date
            $registrationDate = isset($doctorData['created_at']) ? date('F d, Y h:i A', strtotime($doctorData['created_at'])) : date('F d, Y h:i A');
            
            // Get state
            $state = isset($doctorData['state']) ? $doctorData['state'] : 'N/A';
            
            // Get hospital name
            $hospitalName = isset($doctorData['hospital_name']) ? $doctorData['hospital_name'] : 'N/A';
            
            // Try to get template from database
            $templateData = self::getEmailTemplate('admin_doctor_registration_notification', [
                'portal_name' => $portalName,
                'doctor_name' => $doctorName,
                'doctor_email' => $doctorEmail,
                'state' => $state,
                'hospital_name' => $hospitalName,
                'phone_number' => $phoneNumber,
                'specialization' => $specialization,
                'registration_date' => $registrationDate,
                'site_email' => $siteEmail
            ]);
            
            if ($templateData) {
                $subject = $templateData['subject'];
                $message = $templateData['body'];
            } else {
                // Fallback to hardcoded template
                $subject = "New Doctor Registration Received";
                $message = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                            .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                            .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                            .info-item { margin: 0; padding: 0; }
                            .info-label { font-weight: bold; }
                            p { margin: 0 0 0 0; }
                            p:not(.info-item) { margin: 0 0 1em 0; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>{$portalName}</h2>
                            </div>
                            <div class='content'>
                                <h3>New Doctor Registration Received</h3>
                                <p style='margin: 0;'>Hello Administrator,</p>
                                <p style='margin: 0;'>A new doctor has registered on the {$portalName}. Please review their details below:</p>
                                <p class='info-item' style='margin: 0;'><span class='info-label'>Name:</span> {$doctorName}</p>
                                <p class='info-item' style='margin: 0;'><span class='info-label'>Email:</span> {$doctorEmail}</p>
                                <p class='info-item' style='margin: 0;'><span class='info-label'>State:</span> {$state}</p>
                                <p class='info-item' style='margin: 0;'><span class='info-label'>Hospital name:</span> {$hospitalName}</p>
                                <p class='info-item' style='margin: 0;'><span class='info-label'>Contact Number:</span> {$phoneNumber}</p>
                                <p class='info-item' style='margin: 0;'><span class='info-label'>Specialization:</span> {$specialization}</p>
                                <p class='info-item' style='margin: 0;'><span class='info-label'>Registration Date:</span> {$registrationDate}</p>
                                <p style='margin: 0;'>&nbsp;</p>
                                <p style='margin: 0;'>Please verify and approve the doctor's account at your earliest convenience.</p>
                                <p style='margin: 0;'>Thank you,<br>{$portalName}</p>
                            </div>
                            <div class='footer'>
                                <p>This email was sent from {$portalName}</p>
                                <p>If you have any questions, please contact us at {$siteEmail}</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";
            }
            
            Mail::html($message, function($mail) use ($adminEmail, $subject, $siteEmail, $portalName) {
                $mail->to($adminEmail)
                     ->subject($subject)
                     ->from($siteEmail, $portalName);
            });
            
            Log::info("Admin notification email sent for doctor registration: {$doctorName} ({$doctorEmail})");
            return true;
            
        } catch (Exception $e) {
            Log::error("Failed to send admin notification email for doctor registration {$doctorEmail}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send general email with custom content
     */
    public static function sendEmail($to, $subject, $message, $fromEmail = null, $fromName = null)
    {
        try {
            self::configureMailSettings();
            
            $siteEmail = $fromEmail ?: Setting::get('site_email', 'test.wtd3@gmail.com');
            $siteName = $fromName ?: Setting::get('site_name', 'Sugar Sight Saver');
            
            // Ensure message has complete HTML structure if it contains HTML
            $isHtml = strip_tags($message) !== $message;
            if ($isHtml && stripos($message, '<html') === false) {
                // Extract style if it exists separately
                $styleContent = '';
                if (preg_match('/<style[^>]*>(.*?)<\/style>/is', $message, $styleMatches)) {
                    $styleContent = trim($styleMatches[1]);
                    // Remove style tag from message
                    $message = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $message);
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
                $message = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        ' . $styleContent . '
    </style>
</head>
<body>
    ' . trim($message) . '
</body>
</html>';
            }
            
            Mail::html($message, function($mail) use ($to, $subject, $siteEmail, $siteName) {
                $mail->to($to)
                     ->subject($subject)
                     ->from($siteEmail, $siteName);
            });
            
            Log::info("Email sent to: {$to} with subject: {$subject}");
            return true;
            
        } catch (Exception $e) {
            Log::error("Failed to send email to {$to}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send doctor approval email
     */
    public static function sendDoctorApprovalEmail($email, $doctorName, $loginUrl)
    {
        try {
            self::configureMailSettings();
            
            $siteName = Setting::get('site_name', 'Sugar Sight Saver');
            $siteEmail = Setting::get('site_email', 'test.wtd3@gmail.com');
            
            // Try to get template from database
            $templateData = self::getEmailTemplate('doctor_approval', [
                'site_name' => $siteName,
                'doctor_name' => $doctorName,
                'login_url' => $loginUrl,
                'site_email' => $siteEmail
            ]);
            
            if ($templateData) {
                $subject = $templateData['subject'];
                $message = $templateData['body'];
            } else {
                // Fallback to hardcoded template
                $subject = "Congratulations Dr. {$doctorName} – Your SSS Account Has Been Approved!";
                $message = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                            .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                            .button { display: inline-block; background: #634299; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                            .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                            .text-white { color: white !important; }
                            .highlight { background: #e8f4fd; padding: 15px; border-left: 4px solid #634299; margin: 20px 0; border-radius: 4px; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>{$siteName}</h2>
                            </div>
                            <div class='content'>
                                <h3>Congratulations Dr. {$doctorName} – Your SSS Account Has Been Approved!</h3>
                                <p>Dear Dr. {$doctorName},</p>
                                <p>We are pleased to inform you that your account has been approved successfully.</p>
                                <p>You can now log in and start managing your profile and appointments.</p>
                                <p style='text-align: center;'>
                                    <a href='{$loginUrl}' class='button text-white'>Login Now</a>
                                </p>
                                <p>Welcome aboard,<br>Team {$siteName}</p>
                            </div>
                            <div class='footer'>
                                <p>This email was sent from {$siteName}</p>
                                <p>If you have any questions, please contact us at {$siteEmail}</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";
            }
            
            Mail::html($message, function($mail) use ($email, $subject, $siteEmail, $siteName) {
                $mail->to($email)
                     ->subject($subject)
                     ->from($siteEmail, $siteName);
            });
            
            Log::info("Doctor approval email sent to: {$email}");
            return true;
            
        } catch (Exception $e) {
            Log::error("Failed to send doctor approval email to {$email}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send doctor rejection email
     */
    public static function sendDoctorRejectionEmail($email, $doctorName, $reason)
    {
        try {
            self::configureMailSettings();
            
            $siteName = Setting::get('site_name', 'Sugar Sight Saver');
            $siteEmail = Setting::get('site_email', 'test.wtd3@gmail.com');
            
            // Try to get template from database
            $templateData = self::getEmailTemplate('doctor_rejection', [
                'site_name' => $siteName,
                'doctor_name' => $doctorName,
                'reason' => $reason,
                'site_email' => $siteEmail
            ]);
            
            if ($templateData) {
                $subject = $templateData['subject'];
                $message = $templateData['body'];
            } else {
                // Fallback to hardcoded template
                $subject = "Update on Your {$siteName} Registration";
                $message = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                            .header { background: #634299; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
                            .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                            .highlight { background: #ffe6e6; padding: 15px; border-left: 4px solid #dc3545; margin: 20px 0; border-radius: 4px; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>{$siteName}</h2>
                            </div>
                            <div class='content'>
                                <h3>Update on Your {$siteName} Registration</h3>
                                <p>Dear Dr. {$doctorName},</p>
                                <div class='highlight'>
                                    <p>We regret to inform you that your registration could not be approved at this time due to <strong>{$reason}</strong>.</p>
                                </div>
                                <p>You may update your profile and reapply for verification.</p>
                                <p>If you believe this was an error, please reach out to us at <a href='mailto:{$siteEmail}'>{$siteEmail}</a></p>
                                <p>Thank you for your interest in {$siteName}.</p>
                                <p>Best regards,<br>Team {$siteName}</p>
                            </div>
                            <div class='footer'>
                                <p>This email was sent from {$siteName}</p>
                                <p>If you have any questions, please contact us at {$siteEmail}</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";
            }
            
            Mail::html($message, function($mail) use ($email, $subject, $siteEmail, $siteName) {
                $mail->to($email)
                     ->subject($subject)
                     ->from($siteEmail, $siteName);
            });
            
            Log::info("Doctor rejection email sent to: {$email}");
            return true;
            
        } catch (Exception $e) {
            Log::error("Failed to send doctor rejection email to {$email}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Test SMTP configuration
     */
    public static function testSmtpConfiguration()
    {
        try {
            self::configureMailSettings();
            
            $siteEmail = Setting::get('site_email', 'test.wtd3@gmail.com');
            $siteName = Setting::get('site_name', 'Sugar Sight Saver');
            
            $testMessage = "
                <html>
                <body>
                    <h3>SMTP Configuration Test</h3>
                    <p>This is a test email to verify that your SMTP configuration is working correctly.</p>
                    <p>If you receive this email, your SMTP settings are properly configured.</p>
                    <p>Time: " . now() . "</p>
                </body>
                </html>
            ";
            
            Mail::html($testMessage, function($mail) use ($siteEmail, $siteName) {
                $mail->to($siteEmail)
                     ->subject('SMTP Configuration Test - ' . $siteName)
                     ->from($siteEmail, $siteName);
            });
            
            return true;
            
        } catch (Exception $e) {
            Log::error("SMTP test failed: " . $e->getMessage());
            return false;
        }
    }
}
