<?php

namespace App\Http\Controllers\siteadmin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EmailManagementController extends Controller
{
    /**
     * Display all email templates
     */
    public function index()
    {
        $templates = EmailTemplate::orderBy('name')->get();
        $title = 'Email Management';
        $breadcrumb = 'Dashboard';
        
        return view('pages.email-management.index', compact('templates', 'title', 'breadcrumb'));
    }
    
    /**
     * Show email template details
     */
    public function show($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $title = 'View Email Template';
        $breadcrumb = 'Email Management';
        
        // Get sample data for preview
        $sampleData = $this->getSampleData($template->template_key);
        $processed = $template->replaceVariables($sampleData);
        
        return view('pages.email-management.show', compact('template', 'processed', 'title', 'breadcrumb'));
    }

    /**
     * Show form to edit email template
     */
    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $title = 'Edit Email Template';
        $breadcrumb = 'Email Management';
        
        return view('pages.email-management.edit', compact('template', 'title', 'breadcrumb'));
    }

    /**
     * Update email template
     */
    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $template->subject = $request->subject;
        $template->body = $request->body;
        // Checkbox: if checked, value is "1", if unchecked, it won't be in the request
        $template->is_active = $request->has('is_active') && $request->is_active == '1';
        $template->save();

        return redirect()->route('admin.email-management.index')
            ->with('success', 'Email template updated successfully!');
    }

    /**
     * Preview email template
     */
    public function preview($id)
    {
        $template = EmailTemplate::findOrFail($id);
        
        // Sample data for preview
        $sampleData = $this->getSampleData($template->template_key);
        $processed = $template->replaceVariables($sampleData);
        
        return response()->json([
            'subject' => $processed['subject'],
            'body' => $processed['body'],
        ]);
    }

    /**
     * Get sample data for preview based on template key
     */
    private function getSampleData($templateKey)
    {
        $samples = [
            'admin_password_reset' => [
                'site_name' => 'Sugar Sight Saver',
                'reset_link' => 'https://example.com/reset-password?token=abc123',
                'site_email' => 'admin@sugarsight.com',
            ],
            'doctor_password_reset' => [
                'site_name' => 'Sugar Sight Saver',
                'reset_link' => 'https://example.com/reset-password?token=abc123',
                'site_email' => 'admin@sugarsight.com',
            ],
            'doctor_registration' => [
                'portal_name' => 'Sugar Sight Saver',
                'doctor_name' => 'Dr. John Doe',
                'admin_email' => 'admin@sugarsight.com',
            ],
            'admin_doctor_registration_notification' => [
                'portal_name' => 'Sugar Sight Saver',
                'doctor_name' => 'Dr. John Doe',
                'doctor_email' => 'doctor@example.com',
                'state' => 'Maharashtra',
                'hospital_name' => 'City Hospital',
                'phone_number' => '+91 9876543210',
                'specialization' => 'Diabetes-Treating Physician',
                'registration_date' => date('F d, Y h:i A'),
                'site_email' => 'admin@sugarsight.com',
            ],
            'doctor_approval' => [
                'site_name' => 'Sugar Sight Saver',
                'doctor_name' => 'Dr. John Doe',
                'login_url' => 'https://example.com/doctor/login',
                'site_email' => 'admin@sugarsight.com',
            ],
            'doctor_rejection' => [
                'site_name' => 'Sugar Sight Saver',
                'doctor_name' => 'Dr. John Doe',
                'reason' => 'Incomplete documentation',
                'site_email' => 'admin@sugarsight.com',
            ],
            'patient_registration' => [
                'patient_name' => 'John Patient',
                'clinic_name' => 'City Hospital',
                'doctor_name' => 'Dr. John Doe',
                'site_phone' => '+91 9876543210',
            ],
            'six_month_reminder' => [
                'patient_name' => 'John Patient',
                'site_phone' => '+91 9876543210',
            ],
            'three_month_report_reminder' => [
                'patient_name' => 'John Patient',
                'sssp_id' => 'SSSP123456',
                'site_phone' => '+91 9876543210',
            ],
        ];

        return $samples[$templateKey] ?? [];
    }
}
