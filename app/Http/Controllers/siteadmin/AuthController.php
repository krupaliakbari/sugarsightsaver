<?php

namespace App\Http\Controllers\siteadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Validator;
use App\Services\MailService;

class AuthController extends Controller
{
    public function updatePasswordCheckValidation(Request $request)
    {
        $updatePassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();
        if($updatePassword){
            $customMessages = [
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email.',
                'email.exists' => 'Email does not exist.',
                'password.required' => 'Password is required.',
                'password.string' => 'Password must be a string.',
                'password.min' => 'Password must be at least 6 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
                'password_confirmation.required' => 'Password confirmation is required.',
            ];
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
            ], $customMessages);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            $checkUser = User::where('email', $request->email)->first();
            return redirect('/siteadmin/login')->with('success', 'Password updated successfully.');   
            }else{  
            return redirect()->back()->with('error', 'Invalid reset token.');
        }
    }

    public function forgetUserPassword()
    {
        if(Auth::check()){return redirect('siteadmin/dashboard');}
        
        $title = 'Password Reset';
        $breadcrumb = 'Home';

        $setRestform = 0;
        $email = '';
        $token = '';

        if(isset($_REQUEST['authenticchk']) && isset($_REQUEST['token']) && $_REQUEST['token'] != '' && $_REQUEST['authenticchk'] != ''){
            $id = base64_decode($_REQUEST['authenticchk']);
            $chkID = User::find($id);
            if($chkID){
                $updatePassword = DB::table('password_resets')->where(['email' => $chkID->email, 'token' => $_REQUEST['token']])->first();
                if($updatePassword){
                    $setRestform = 1;
                    $email = $chkID->email;
                    $token = $_REQUEST['token'];
                }else{
                    return redirect('siteadmin/password-reset')->with('error', 'Invalid reset token.');
                }
            }else{
                return redirect('siteadmin/password-reset')->with('error', 'Invalid reset token.');
            }
        }
        
        return view('pages.authentication.cover.password-reset',compact('breadcrumb','title','setRestform','email','token'));
    }
    
    public function sendVerificationPass(Request $request)
    {
        $customMessages = [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.exists' => 'Email does not exist.',
        ];
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users'
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userDetal = User::where('email',$request->email)->first();
        if($userDetal){
            $token = Str::random(64);
  
            DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
            ]);

            // Send reset email using centralized mail service
            $resetLink = url('siteadmin/password-reset?authenticchk='.base64_encode($userDetal->id).'&token='.$token);
            
            $emailSent = MailService::sendAdminPasswordReset($request->email, $resetLink);
            
            if ($emailSent) {
                return redirect()->back()->with('success', 'Password reset link sent to your email.');
            } else {
                return redirect()->back()->with('error', 'Failed to send password reset email. Please try again or contact administrator.');
            }
            }else{
            return redirect()->back()->with('error', 'Email not found.');
        }
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check if user is an admin
            if (!$user->isAdmin()) {
                    Auth::logout(); 
                return redirect()->back()->with('error', 'Access denied. This area is for administrators only.');
            }

            if($user->status == 'active'){
                return redirect('/siteadmin/dashboard');
            } else {
                Auth::logout(); 
                return redirect()->back()->with('error', 'Your account is deactivated.');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }
    }
}