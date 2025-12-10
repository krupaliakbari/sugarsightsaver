<?php

namespace App\Http\Controllers\siteadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class UserManagementController extends Controller
{
    /**
     * Display a listing of doctors with pagination
     */
    public function index(Request $request)
    {
        $title = 'Doctor Management';
        $breadcrumb = 'Dashboard';
        
        // Build query for doctors only
        $query = User::role('doctor');
        
        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('hospital_name', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }
        
        if ($request->filled('doctor_type')) {
            $query->where('doctor_type', $request->doctor_type);
        }
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // Apply sorting based on column
        switch ($sortBy) {
            case 'name':
            case 'email':
            case 'phone':
            case 'hospital_name':
            case 'doctor_type':
            case 'status':
            case 'approval_status':
                $query->orderBy($sortBy, $sortDirection);
                break;
            default:
                $query->orderBy('created_at', $sortDirection);
                break;
        }
        
        // Add query parameters to pagination links before paginating
        $doctors = $query->paginate(15)->appends($request->query());
        
        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('pages.user-management.index', compact('doctors', 'title', 'breadcrumb'));
        }

        return view('pages.user-management.index', compact('doctors', 'title', 'breadcrumb'));
    }
    
    /**
     * Display the specified doctor
     */
    public function show($id)
    {
        $title = 'Doctor Details';
        $breadcrumb = 'Doctor Management';
        
        $doctor = User::role('doctor')->findOrFail($id);
        
        return view('pages.user-management.show', compact('doctor', 'title', 'breadcrumb'));
    }

   public function edit($id)
{
    $title = 'Edit Doctor';
    $breadcrumb = 'Doctor Management';
    
    $doctor = User::role('doctor')->findOrFail($id);
    
    return view('pages.user-management.edit', compact('doctor', 'title', 'breadcrumb'));
}

public function update(Request $request, $id)
{
    $doctor = User::role('doctor')->findOrFail($id);

    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'phone' => 'required|string|max:20',
        'hospital_name' => 'required|string|max:255',
        'doctor_type' => 'required|in:diabetes_treating,ophthalmologist',
        'medical_council_registration_number' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'address' => 'required|string',
        'qualification' => 'required|string',
        'password' => 'nullable|min:8|confirmed', // Password is optional
    ];

    $request->validate($rules);

    $data = $request->except(['password', 'password_confirmation']);

    // Only update password if provided
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $doctor->update($data);

    return redirect()->route('user-management')
        ->with('success', 'Doctor updated successfully!');
}



public function destroy($id)
{
    try {
        $doctor = User::role('doctor')->findOrFail($id);

        if (auth()->id() == $doctor->id) {
            return redirect()->route('user-management')
                ->with('error', 'You cannot delete your own account!');
        }

        DB::transaction(function () use ($doctor) {
            if ($doctor->profile_image && Storage::disk('public')->exists($doctor->profile_image)) {
                Storage::disk('public')->delete($doctor->profile_image);
            }

            $doctor->delete(); // This triggers the boot::deleting above
        });

        return redirect()->route('user-management')
            ->with('success', 'Doctor and all associated data deleted successfully!');

    } catch (\Exception $e) {
        \Log::error('Delete Doctor Error: ' . $e->getMessage());
        return redirect()->route('user-management')
            ->with('error', 'Failed to delete doctor: ' . $e->getMessage());
    }
}   
    /**
     * Toggle user status (active/deactive)
     */
    public function toggleStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:active,deactive'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided'
            ], 400);
        }
        
        try {
            $user = User::findOrFail($request->user_id);
            
            // Check if user is a doctor
            if (!$user->hasRole('doctor')) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not a doctor'
                ], 400);
            }
            
            $user->status = $request->status;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully',
                'new_status' => $user->status
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user status'
            ], 500);
        }
    }
    
    /**
     * Update doctor approval status
     */
    public function updateApprovalStatus(Request $request)
    {
        // Build validation rules based on approval status
        $rules = [
            'user_id' => 'required|exists:users,id',
            'approval_status' => 'required|in:pending,approved,rejected',
        ];
        
        // If status is rejected, require rejection_reason
        if ($request->approval_status === 'rejected') {
            $rules['rejection_reason'] = 'required|string|max:500';
        } else {
            $rules['rejection_reason'] = 'nullable|string|max:500';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 400);
        }
        
        try {
            $user = User::findOrFail($request->user_id);
            
            // Check if user is a doctor
            if (!$user->hasRole('doctor')) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not a doctor'
                ], 400);
            }
            
            $oldStatus = $user->approval_status;
            $user->approval_status = $request->approval_status;
            
            if ($request->approval_status === 'rejected' && $request->rejection_reason) {
                $user->rejection_reason = $request->rejection_reason;
            } else {
                $user->rejection_reason = null;
            }
            
            $user->save();
            
            // Send email notifications
            $this->sendApprovalEmail($user, $request->approval_status, $request->rejection_reason);
            
            return response()->json([
                'success' => true,
                'message' => 'Doctor approval status updated successfully',
                'new_approval_status' => $user->approval_status
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update approval status'
            ], 500);
        }
    }
    
    /**
     * Send approval/rejection email to doctor
     */
    private function sendApprovalEmail($user, $approvalStatus, $rejectionReason = null)
    {
        try {
            $doctorName = $user->name;
            $email = $user->email;
            
            if ($approvalStatus === 'approved') {
                // Send approval email
                $loginUrl = route('doctor.login');
                MailService::sendDoctorApprovalEmail($email, $doctorName, $loginUrl);
            } elseif ($approvalStatus === 'rejected' && $rejectionReason) {
                // Send rejection email
                MailService::sendDoctorRejectionEmail($email, $doctorName, $rejectionReason);
            }
        } catch (\Exception $e) {
            // Log error but don't fail the approval process
            Log::error("Failed to send approval email to {$user->email}: " . $e->getMessage());
        }
    }
}
