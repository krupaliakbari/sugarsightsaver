<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\MailService;
use App\Models\Setting;

class DoctorAuthController extends Controller
{
    /**
     * Show doctor login form
     */
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->isDoctor()) {
            return redirect('/doctor/dashboard');
        }

        return view('doctor.auth.login', [
            'title' => 'Doctor Login',
            'breadcrumb' => 'Login'
        ]);
    }

    /**
     * Handle doctor login
     */
public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ], [
        'email.required' => 'Email is required.',
        'email.email' => 'Please enter a valid email.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 6 characters.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');

    if (Auth::attempt($credentials, $remember)) {
        $user = Auth::user();

        // Get system admin email from settings table
        $adminEmail = Setting::get('site_email', 'admin@sugarsightsaver.com');

        // Check if user is a doctor
        if (!$user->isDoctor()) {
            Auth::logout();
            return redirect()->back()
                ->with('error', 'Access denied. This area is for doctors only.');
        }

        // Check if doctor is approved
        if (!$user->isApproved()) {
            Auth::logout();
            if ($user->isPending()) {
                return redirect()->back()
                    ->with('error', 'Your account is pending approval. Please wait for admin approval.');
            } else {
                return redirect()->back()
                    ->with('error', "Your account has been rejected. Please contact the administrator at {$adminEmail}.");
            }
        }

        // Check if account is active
        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()->back()
                ->with('error', "Your account has been deactivated by the administrator. Please contact the administrator at {$adminEmail}.");
        }

        // Success — redirect to dashboard
        return redirect('/doctor/dashboard');
    }

    // Invalid login
    return redirect()->back()->with('error', 'Invalid email or password.');
}

    /**
     * Show doctor registration form
     */
 public function showRegisterForm(Request $request,$type = null)
    {
        if (Auth::check() && Auth::user()->isDoctor()) {
            return redirect('/doctor/dashboard');
        }

        return view('doctor.auth.register', [
            'title' => 'Doctor Registration',
            'breadcrumb' => 'Register',
            'type' => $type
        ]);
    }

    /**
     * Handle doctor registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|digits:10',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'hospital_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'doctor_type' => 'required|in:diabetes_treating,ophthalmologist',
            'qualification' => 'required|string|max:500',
            'medical_council_registration_number' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ], [
            'name.required' => 'Name is required.',
            'name.max' => 'Name may not be greater than 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter valid email.',
            'email.unique' => 'Email has already been taken.',
            'phone.required' => 'Phone number is required.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',
            'password.required' => 'Password required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password and confirm password does not match.',
            'password_confirmation.required' => 'Confirm password is required.',
            'hospital_name.required' => 'Hospital name is required.',
            'address.required' => 'Address is required.',
            'doctor_type.required' => 'Doctor type is required.',
            'doctor_type.in' => 'Please select a valid doctor type.',
            'qualification.required' => 'Qualification is required.',
            'medical_council_registration_number.required' => 'Medical Council Registration Number is required.',
            'medical_council_registration_number.max' => 'Medical Council Registration Number may not be greater than 255 characters.',
            'state.required' => 'State is required.',
            'state.max' => 'State may not be greater than 255 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'user_type' => 'doctor',
                'hospital_name' => $request->hospital_name,
                'address' => $request->address,
                'doctor_type' => $request->doctor_type,
                'qualification' => $request->qualification,
                'medical_council_registration_number' => $request->medical_council_registration_number,
                'state' => $request->state,
                'status' => 'active',
                'approval_status' => 'approved',
            ]);

            // Assign doctor role
            $user->assignRole('doctor');

            // Send registration confirmation email to doctor
            $emailSent = MailService::sendDoctorRegistrationEmail($user->email, $user->name);

            // Send admin notification email
            $doctorData = [
                'hospital_name' => $user->hospital_name,
                'doctor_type' => $user->doctor_type,
                'qualification' => $user->qualification,
                'medical_council_registration_number' => $user->medical_council_registration_number,
                'state' => $user->state,
                'address' => $user->address,
                'phone' => $user->phone,
                'created_at' => $user->created_at,
            ];
            MailService::sendAdminDoctorRegistrationNotification($user->name, $user->email, $doctorData);

            if ($emailSent) {
                return redirect('/doctor/login')->with('success', 'Registration completed successfully. Please log in here to continue.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error',$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show doctor forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('doctor.auth.forgot-password', [
            'title' => 'Forgot Password',
            'breadcrumb' => 'Forgot Password'
        ]);
    }

    /**
     * Handle doctor forgot password
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.exists' => 'Email does not exist.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();

        // Check if user is a doctor
        if (!$user->isDoctor()) {
            return redirect()->back()->with('error', 'This email is not registered as a doctor.');
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Send reset email using centralized mail service
        $resetLink = url('doctor/reset-password?email=' . urlencode($request->email) . '&token=' . $token);

        $emailSent = MailService::sendDoctorPasswordReset($request->email, $resetLink);

        if ($emailSent) {
            return redirect()->back()->with('success', 'Password reset link sent to your email.');
        } else {
            return redirect()->back()->with('error', 'Failed to send password reset email. Please try again or contact administrator.');
        }
    }

    /**
     * Show doctor reset password form
     */
    public function showResetPasswordForm(Request $request)
    {
        $updatePassword = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if (!$updatePassword) {
            return redirect('/doctor/forgot-password')->with('error', 'Invalid reset token.');
        }

        return view('doctor.auth.reset-password', [
            'title' => 'Reset Password',
            'breadcrumb' => 'Reset Password',
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    /**
     * Handle doctor reset password
     */
    public function resetPassword(Request $request)
    {
        $updatePassword = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if (!$updatePassword) {
            return redirect()->back()->with('error', 'Invalid reset token.');
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.exists' => 'Email does not exist.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password_confirmation.required' => 'Password confirmation is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect('/doctor/login')->with('success', 'Password updated successfully.');
    }

    /**
     * Handle doctor logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/doctor/login');
    }

    /**
     * Show doctor dashboard
     */
    public function dashboard()
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            return redirect('/doctor/login');
        }

        return view('doctor.dashboard', [
            'title' => 'Doctor Dashboard',
            'breadcrumb' => 'Dashboard'
        ]);
    }
}
