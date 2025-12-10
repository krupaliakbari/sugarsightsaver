<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\ReminderService;
use App\Services\MailService;
use App\Models\Setting;

class AdminSettingsController extends Controller
{
    /**
     * Display general settings page
     */
    public function index()
    {
        $settings = Setting::getAll();
        return view('pages.admin.settings.index', compact('settings'));
    }

    /**
     * Update general settings
     */
    public function updateSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'nullable|string|max:20',
            'site_address' => 'nullable|string|max:500',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|in:tls,ssl',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update settings in database
        Setting::set('site_name', $request->site_name, 'string', 'Site name');
        Setting::set('site_email', $request->site_email, 'string', 'Site email address');
        Setting::set('site_phone', $request->site_phone, 'string', 'Site phone number');
        Setting::set('site_address', $request->site_address, 'string', 'Site address');
        Setting::set('smtp_host', $request->smtp_host, 'string', 'SMTP host');
        Setting::set('smtp_port', $request->smtp_port, 'integer', 'SMTP port');
        Setting::set('smtp_username', $request->smtp_username, 'string', 'SMTP username');
        Setting::set('smtp_password', $request->smtp_password, 'string', 'SMTP password');
        Setting::set('smtp_encryption', $request->smtp_encryption, 'string', 'SMTP encryption');

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Test SMTP configuration
     */
    public function testSmtp(Request $request)
    {
        try {
            $success = MailService::testSmtpConfiguration();
            
            if ($success) {
                return response()->json(['status' => 'success', 'message' => 'SMTP configuration test successful! Check your email.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'SMTP configuration test failed. Please check your settings.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'SMTP test failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Display SMS content management page
     */
    public function smsContent()
    {
        return view('pages.admin.settings.sms-content');
    }

    /**
     * Update SMS content templates
     */
    public function updateSmsContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_registration_sms' => 'required|string|max:500',
            'six_month_reminder_sms' => 'required|string|max:500',
            'three_month_report_reminder_sms' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update SMS templates
        session([
            'patient_registration_sms' => $request->patient_registration_sms,
            'six_month_reminder_sms' => $request->six_month_reminder_sms,
            'three_month_report_reminder_sms' => $request->three_month_report_reminder_sms,
        ]);

        return redirect()->back()->with('success', 'SMS content updated successfully!');
    }

    /**
     * Display admin profile page
     */
    public function profile()
    {
        return view('pages.admin.settings.profile');
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'hospital_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'hospital_name' => $request->hospital_name,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update admin password
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password is incorrect'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    /**
     * Display reminder management page
     */
    public function reminderManagement()
    {
        $reminderService = new ReminderService();
        $stats = $reminderService->getReminderStats();
        
        return view('pages.admin.settings.reminder-management', compact('stats'));
    }

    /**
     * Send reminders manually
     */
    public function sendReminders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:six-month,three-month,all'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $reminderService = new ReminderService();
        $type = $request->type;
        $sentCount = 0;

        try {
            switch ($type) {
                case 'six-month':
                    $sentCount = $reminderService->sendSixMonthReminders();
                    break;
                case 'three-month':
                    $sentCount = $reminderService->sendThreeMonthReportReminders();
                    break;
                case 'all':
                    $sentCount = $reminderService->sendSixMonthReminders() + 
                                $reminderService->sendThreeMonthReportReminders();
                    break;
            }

            return redirect()->back()->with('success', "Successfully sent {$sentCount} reminders!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send reminders: ' . $e->getMessage());
        }
    }
}
