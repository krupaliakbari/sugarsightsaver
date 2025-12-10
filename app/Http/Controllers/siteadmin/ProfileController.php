<?php

namespace App\Http\Controllers\siteadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function profile()
    {
        $title = 'Profile';
        $breadcrumb = 'Dashboard';

        // Check if user is authenticated and has proper role
        if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isDoctor())) {
            return redirect('/login');
        }

        if(isset(Auth::user()->profile_image) && Auth::user()->profile_image != ''):
            $profilePath = url(Auth::user()->profile_image);
        else:
            $profilePath = Vite::asset('resources/images/user-profile.jpeg');
        endif;

        return view('pages.user.profile',compact('title','breadcrumb','profilePath'));
    }

    public function setting()
    {
        $title = 'Update Profile';
        $breadcrumb = 'Dashboard';

        // Check if user is authenticated and has proper role
        if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isDoctor())) {
            return redirect('/login');
        }

        $userDetail = User::where('id',Auth::id())->first();
        if(isset(Auth::user()->profile_image) && Auth::user()->profile_image != ''):
            $profilePath =  url(Auth::user()->profile_image);
        else:
            $profilePath = Vite::asset('resources/images/user-profile.jpeg');
        endif;

        return view('pages.user.account-settings',compact('userDetail','title','breadcrumb','profilePath'));
    }

    public function updateAvatar(Request $request)
    {
        // Check if user is authenticated and has proper role
        if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isDoctor())) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized access.']);
        }

        try {
            // Handle simple file upload
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');

                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                if (!in_array($image->getMimeType(), $allowedTypes)) {
                    return response()->json(['error' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed.'], 400);
                }

                // Validate file size (max 5MB)
                if ($image->getSize() > 5 * 1024 * 1024) {
                    return response()->json(['error' => 'File too large. Maximum size is 5MB.'], 400);
                }

                $folder_name = 'images/profile';
                $imagePath = $image->store($folder_name, 'public');
                $saveAvatar = User::find(Auth::id());

                if(trim($saveAvatar->profile_image != '')){
                    Storage::disk('public')->delete($saveAvatar->profile_image);
                }

                $saveAvatar->profile_image = $imagePath;
                $saveAvatar->save();

                return response()->json([
                    'success' => true,
                    'id' => $saveAvatar->id,
                    'path' => $imagePath,
                    'url' => url('storage/' . $imagePath)
                ]);
            } else {
                return response()->json(['error' => 'No file provided'], 400);
            }

        } catch(Exception $ex) {
            \Log::error('Profile image upload error: ' . $ex->getMessage());
            return response()->json(['error' => 'File upload failed: ' . $ex->getMessage()], 500);
        }
    }

    public function deleteAvatar(Request $request)
    {
        // Check if user is authenticated and has proper role
        if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isDoctor())) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized access.']);
        }

        $avtartFile = User::find(Auth::id());
        if($avtartFile){
            $filePath = $avtartFile->profile_image;
            $avtartFile->profile_image = $filePath;
            Storage::disk('public')->delete($filePath);
            $avtartFile->profile_image = '';
            $avtartFile->save();
        }
    }

public function updateProfile(Request $request)
{
    if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isDoctor())) {
        return response()->json(['status' => 'error', 'message' => 'Unauthorized access.']);
    }

    $user = Auth::user();
    $isDoctor = $user->isDoctor();

    // Validation rules
    $validationRules = [
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['nullable', 'regex:/^\d{10}$/'],
        'email' => [
            'required',
            'string',
            'email:rfc,dns',
            'max:255',
            Rule::unique(User::class)->ignore(Auth::id()),
        ],
        'profile_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
    ];

    $customMessages = [
        'name.required' => 'Name is required.',
        'email.required' => 'Email is required.',
        'email.unique' => 'Email has already been taken.',
        'phone.regex' => 'Phone number must be exactly 10 digits.',
        'profile_image.image' => 'Please select valid image format.',
        'profile_image.mimes' => 'Allowed formats: jpeg, jpg, png, gif.',
        'profile_image.max' => 'The profile image must not be larger than 5MB.',
    ];

    if ($isDoctor) {
        $validationRules = array_merge($validationRules, [
            'hospital_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'qualification' => ['required', 'string', 'max:500'],
            'medical_council_registration_number' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
        ]);
    }

    $request->validate($validationRules, $customMessages);

    // Check email uniqueness manually
    $existingEmail = User::where('id', '<>', Auth::id())
        ->where('email', $request->email)
        ->first();
    if ($existingEmail) {
        return redirect()->back()->withInput()->with('error', 'Email already exists.');
    }

    // Check phone uniqueness manually
    if (!empty($request->phone)) {
        $existingPhone = User::where('id', '<>', Auth::id())
            ->where('phone', $request->phone)
            ->first();
        if ($existingPhone) {
            return redirect()->back()->withInput()->with('error', 'Phone already exists.');
        }
    }

    // Update user details
    $saveDetail = User::find(Auth::id());
    $saveDetail->name = $request->name;
    $saveDetail->email = $request->email;
    $saveDetail->phone = !empty($request->phone) ? $request->phone : null;

    if ($isDoctor) {
        $saveDetail->hospital_name = $request->hospital_name;
        $saveDetail->address = $request->address;
        $saveDetail->qualification = $request->qualification;
        $saveDetail->medical_council_registration_number = $request->medical_council_registration_number;
        $saveDetail->state = $request->state;
    }

    // Handle profile image
    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        $folder_name = 'images/profile';
        $imagePath = $image->store($folder_name, 'public');

        if (!empty($saveDetail->profile_image)) {
            Storage::disk('public')->delete($saveDetail->profile_image);
        }

        $saveDetail->profile_image = $imagePath;
    }

    $saveDetail->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}


    public function updateUserPassword(Request $request)
    {
        // Check if user is authenticated and has proper role
        if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isDoctor())) {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized access.']);
            }
            return redirect('/login');
        }

        // Validate fields
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'Password must be at least 8 characters long.',
            'new_password.confirmed' => 'Password and confirm password does not match.',
        ]);

        // Check current password
        $user = Auth::user();
        if (!Hash::check($request->input('current_password'), $user->password)) {
            if ($request->expectsJson()) {
                return response()->json(['status'=> 'false','message' => 'Current password is incorrect.']);
            }
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
        }

        $saveuser = User::find($user->id);
        $saveuser->password = Hash::make($request->input('new_password'));
        $saveuser->save();

        if ($request->expectsJson()) {
            return response()->json(['status'=> 'success','message' => 'Password updated successfully.']);
        }

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
