<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\siteadmin\AuthController;
use App\Http\Controllers\siteadmin\ProfileController;
use App\Http\Controllers\siteadmin\UserManagementController;
use App\Http\Controllers\DoctorAuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PhysicianEntryController;
use App\Http\Controllers\OphthalmologistEntryController;
use App\Http\Controllers\MedicalSummaryController;
use App\Http\Controllers\ExcelExportController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminPatientController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\siteadmin\EmailManagementController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route to serve static assets from HTML/assets folder
// MUST be first to catch asset requests before other routes
Route::get('/assets/{path}', function ($assetFilePath) {
    // Security: prevent directory traversal
    $assetFilePath = str_replace('..', '', $assetFilePath);
    $assetFilePath = ltrim($assetFilePath, '/');

    // Try multiple possible paths for assets (same structure as local)
    $possiblePaths = [
        base_path('../HTML/assets/' . $assetFilePath),  // Parent directory (same as local)
        public_path('assets/' . $assetFilePath),          // Fallback: public/assets/
    ];

    $assetPath = null;
    foreach ($possiblePaths as $possiblePath) {
        if (file_exists($possiblePath) && is_file($possiblePath)) {
            $assetPath = $possiblePath;
            break;
        }
    }

    if ($assetPath && file_exists($assetPath)) {
        // Determine content type based on file extension
        $extension = strtolower(pathinfo($assetPath, PATHINFO_EXTENSION));
        $contentTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject',
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'webp' => 'image/webp',
            'jfif' => 'image/jpeg',
        ];

        $contentType = $contentTypes[$extension] ?? 'application/octet-stream';

        try {
            return response()->file($assetPath, [
                'Content-Type' => $contentType,
                'Cache-Control' => 'public, max-age=31536000',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error serving asset', [
                'path' => $assetPath,
                'error' => $e->getMessage(),
            ]);
            abort(500, 'Error serving asset');
        }
    }

    // Log which paths were checked for debugging
    \Log::warning('Asset not found', [
        'requested' => $assetFilePath,
        'checked_paths' => $possiblePaths,
    ]);

    abort(404, 'Asset not found: ' . $assetFilePath);
})->where('path', '.*');

// Public Routes (No Authentication Required)
Route::get('/', [PublicController::class, 'indexHtml'])->name('public.index');

// Route for diabetes.html (served as Laravel Blade view)
Route::get('/diabetes.html', [PublicController::class, 'diabetesHtml'])->name('public.diabetes-html');

Route::get('/diabetes-details', [PublicController::class, 'diabetesDetails'])->name('public.diabetes-details');

// Route for manifest.json
Route::get('/manifest.json', function () {
    $possiblePaths = [
        public_path('HTML/manifest.json'),
        public_path('manifest.json'),
        base_path('HTML/manifest.json'),
        base_path('../HTML/manifest.json'),
    ];

    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            return response()->file($path, [
                'Content-Type' => 'application/manifest+json',
            ]);
        }
    }

    abort(404);
});


    // Admin Routes
    Route::prefix('siteadmin')->group(function () {



    // Redirect to login if not authenticated
    Route::get('/', function () {
        if(Auth::check() && Auth::user()->isAdmin()) {
            return redirect('siteadmin/dashboard');
        } else {
            return redirect('siteadmin/login');
        }
    });

    // Authentication Routes
    Route::get('/login', function () {
        if(Auth::check() && Auth::user()->isAdmin()) {
            return redirect('siteadmin/dashboard');
        }
        return view('pages.authentication.boxed.signin', ['title' => 'Admin Login', 'breadcrumb' => 'Signin']);
    })->name('admin-login');

    Route::post('/user-login', [AuthController::class, 'userLogin'])->name('user-login');

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('siteadmin/login');
    })->name('admin-logout');

    // Password Reset Routes
    Route::get('/password-reset', [AuthController::class, 'forgetUserPassword'])->name('password-reset');
    Route::post('/user-password-reset', [AuthController::class, 'sendVerificationPass'])->name('user-password-reset');
    Route::post('/user-password-reset-request', [AuthController::class, 'updatePasswordCheckValidation'])->name('user-password-reset-request');

    // Protected Admin Routes
    Route::middleware(['auth', 'role:admin'])->group(function () {

        // Admin Patient Management Routes
        Route::prefix('patients')->name('admin.patients.')->group(function () {
            Route::get('/', [AdminPatientController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminPatientController::class, 'show'])->name('show');
            Route::delete('/{patient}', [AdminPatientController::class, 'destroy'])->name('delete');
            Route::get('/{patientId}/medical-record/{medicalRecordId}', [AdminPatientController::class, 'showMedicalRecord'])->name('medical-record');
            Route::delete('/{patientId}/medical-record/{medicalRecordId}', [AdminPatientController::class, 'deleteMedicalRecord'])->name('medical-record.delete');
            Route::get('/export/all', [AdminPatientController::class, 'export'])->name('export');
            Route::get('/export/filtered', [AdminPatientController::class, 'exportFiltered'])->name('export.filtered');
        });

        // Admin Appointments Routes
        Route::prefix('appointments')->name('admin.appointments.')->group(function () {
            Route::get('/', [AdminPatientController::class, 'appointments'])->name('index');
        });

        // Admin Settings Routes
        Route::prefix('settings')->name('admin.settings.')->group(function () {
            Route::get('/', [AdminSettingsController::class, 'index'])->name('index');
            Route::post('/update', [AdminSettingsController::class, 'updateSettings'])->name('update');
            Route::post('/test-smtp', [AdminSettingsController::class, 'testSmtp'])->name('test-smtp');
            Route::get('/sms-content', [AdminSettingsController::class, 'smsContent'])->name('sms-content');
            Route::post('/sms-content/update', [AdminSettingsController::class, 'updateSmsContent'])->name('sms-content.update');
            // Route::get('/profile', [AdminSettingsController::class, 'profile'])->name('profile');
            // Route::post('/profile/update', [AdminSettingsController::class, 'updateProfile'])->name('profile.update');
            Route::post('/password/update', [AdminSettingsController::class, 'updatePassword'])->name('password.update');
            //Route::get('/reminder-management', [AdminSettingsController::class, 'reminderManagement'])->name('reminder-management');
            Route::post('/reminders/send', [AdminSettingsController::class, 'sendReminders'])->name('reminders.send');
        });

        // Dashboard
        Route::get('/dashboard', function () {
            return view('pages.dashboard.admin-dashboard', [
                'title' => 'Dashboard',
                'breadcrumb' => 'Dashboard'
            ]);
        })->name('admin-dashboard');

        // Profile Management
        // Route::prefix('user')->group(function () {
        //     Route::get('/profile', [ProfileController::class, 'profile'])->name('admin-profile');
        //     Route::get('/settings', [ProfileController::class, 'setting'])->name('admin-settings');
        //     Route::post('/update-user-profile', [ProfileController::class, 'updateProfile'])->name('update-user-profile');
        //     Route::post('/profile-image-store', [ProfileController::class, 'updateAvatar'])->name('profile-image-store');
        //     Route::post('/avatar-delete', [ProfileController::class, 'deleteAvatar'])->name('avatar-delete');
        //     Route::post('/user-update-password', [ProfileController::class, 'updateUserPassword'])->name('user-update-password');
        // });

        // User Management Routes
        Route::prefix('user-management')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('user-management');
            Route::get('/{id}', [UserManagementController::class, 'show'])->name('user-management.show');
             Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('user-management.edit');
             Route::put('/{id}', [UserManagementController::class, 'update'])->name('user-management.update');
            Route::post('/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('user-management.toggle-status');
            Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('user-management.delete');
            Route::post('/update-approval-status', [UserManagementController::class, 'updateApprovalStatus'])->name('user-management.update-approval-status');
        });

        // Email Management Routes
        Route::prefix('email-management')->name('admin.email-management.')->group(function () {
            Route::get('/', [EmailManagementController::class, 'index'])->name('index');
            Route::get('/{id}', [EmailManagementController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [EmailManagementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [EmailManagementController::class, 'update'])->name('update');
            Route::get('/{id}/preview', [EmailManagementController::class, 'preview'])->name('preview');
        });
    });
});

// Doctor Routes
Route::prefix('doctor')->group(function () {

    // Authentication Routes
    Route::get('/login', [DoctorAuthController::class, 'showLoginForm'])->name('doctor.login');
    Route::post('/login', [DoctorAuthController::class, 'login'])->name('doctor.login');

    Route::get('/register/{type?}', [DoctorAuthController::class, 'showRegisterForm'])->name('doctor.register.show');
    Route::post('/register', [DoctorAuthController::class, 'register'])->name('doctor.register');

    Route::get('/forgot-password', [DoctorAuthController::class, 'showForgotPasswordForm'])->name('doctor.forgot-password');
    Route::post('/forgot-password', [DoctorAuthController::class, 'forgotPassword'])->name('doctor.forgot-password');

    Route::get('/reset-password', [DoctorAuthController::class, 'showResetPasswordForm'])->name('doctor.reset-password');
    Route::post('/reset-password', [DoctorAuthController::class, 'resetPassword'])->name('doctor.reset-password');

    Route::get('/logout', [DoctorAuthController::class, 'logout'])->name('doctor.logout');

    // Protected Doctor Routes
    Route::middleware(['auth', 'role:doctor', 'check.doctor.status'])->group(function () {
        Route::get('/dashboard', [DoctorAuthController::class, 'dashboard'])->name('doctor.dashboard');

        // My Appointments Route
        Route::get('/my-appointments', [PatientController::class, 'myAppointments'])->name('doctor.my-appointments');

        // Patient Management Routes
        Route::prefix('patients')->group(function () {
            Route::get('/', [PatientController::class, 'index'])->name('doctor.patients.index');
            Route::get('/add-appointment', [PatientController::class, 'showAddPatientAppointment'])->name('doctor.patients.add-appointment');
            Route::post('/search', [PatientController::class, 'searchPatient'])->name('doctor.patients.search');
            Route::get('/add-patient', [PatientController::class, 'showAddNewPatient'])->name('doctor.patients.add-patient');
            Route::post('/add-patient', [PatientController::class, 'storePatient'])->name('doctor.patients.store-patient');
            Route::get('/add-medical-entry/{appointmentId}', [PatientController::class, 'showAddMedicalEntry'])->name('doctor.patients.add-medical-entry');
            Route::post('/add-medical-entry/{appointmentId}', [PatientController::class, 'storeMedicalEntry'])->name('doctor.patients.store-medical-entry');
            Route::get('/add-appointment-existing', [PatientController::class, 'showAddNewAppointment'])->name('doctor.patients.add-appointment-existing');
            Route::post('/add-appointment-existing', [PatientController::class, 'storeAppointment'])->name('doctor.patients.store-appointment');
            Route::post('/add-appointment-existing-step1', [PatientController::class, 'storeAppointmentExistingStep1'])->name('doctor.patients.store-appointment-existing-step1');
            Route::post('/store-appointment-with-patient-update', [PatientController::class, 'storeAppointmentWithPatientUpdate'])->name('doctor.patients.store-appointment-with-patient-update');
            Route::get('/{patientId}/medical-records', [PatientController::class, 'showMedicalRecords'])->name('doctor.patients.medical-records');
            Route::get('/{patientId}/edit', [PatientController::class, 'edit'])->name('doctor.patients.edit');
            Route::put('/{patientId}', [PatientController::class, 'update'])->name('doctor.patients.update');
            Route::delete('/{patientId}', [PatientController::class, 'deletePatient'])->name('doctor.patients.delete');

            // Appointment Management Routes
            Route::get('/appointments/{appointmentId}/edit', [PatientController::class, 'editAppointment'])->name('doctor.patients.appointments.edit');
            Route::put('/appointments/{appointmentId}', [PatientController::class, 'updateAppointment'])->name('doctor.patients.appointments.update');
            Route::put('/appointments/{appointmentId}/with-patient', [PatientController::class, 'updateAppointmentWithPatient'])->name('doctor.patients.appointments.update-with-patient');
            Route::delete('/appointments/{appointmentId}', [PatientController::class, 'deleteAppointment'])->name('doctor.patients.appointments.delete');
        });

        // Medical Entry Routes
        Route::prefix('medical')->group(function () {
            Route::get('/physician-entries/{appointmentId}', [PhysicianEntryController::class, 'show'])->name('doctor.medical.physician-entries');
            Route::post('/physician-entries/{appointmentId}', [PhysicianEntryController::class, 'store'])->name('doctor.medical.physician-entries.store');
            Route::get('/ophthalmologist-entries/{appointmentId}', [OphthalmologistEntryController::class, 'show'])->name('doctor.medical.ophthalmologist-entries');
            Route::post('/ophthalmologist-entries/{appointmentId}', [OphthalmologistEntryController::class, 'store'])->name('doctor.medical.ophthalmologist-entries.store');
            Route::get('/summary/{patientMedicalRecordId}', [MedicalSummaryController::class, 'show'])->name('doctor.medical.summary');
            Route::get('/summary/{patientMedicalRecordId}/print', [MedicalSummaryController::class, 'print'])->name('doctor.medical.summary.print');
            Route::get('/summary/{patientMedicalRecordId}/pdf', [MedicalSummaryController::class, 'generatePdf'])->name('doctor.medical.summary.pdf');
            Route::post('/summary/{patientMedicalRecordId}/whatsapp', [MedicalSummaryController::class, 'sendWhatsApp'])->name('doctor.medical.summary.whatsapp');
            Route::post('/summary/{patientMedicalRecordId}/whatsapp/msg', [MedicalSummaryController::class, 'sendWhatsAppMsg'])->name('doctor.medical.summary.whatsappMsg');
          

            Route::get('/test-logo', [MedicalSummaryController::class, 'testLogo'])->name('doctor.medical.test-logo');

            // Excel Export Routes
            Route::get('/export/patients', [ExcelExportController::class, 'exportPatients'])->name('doctor.export.patients');
            Route::get('/export/medical-records', [ExcelExportController::class, 'exportMedicalRecords'])->name('doctor.export.medical-records');
            Route::get('/export/patient/{patientId}/medical-records', [ExcelExportController::class, 'exportPatientMedicalRecords'])->name('doctor.export.patient-medical-records');
        });

    });
});

// Centralized Profile Routes (for both Admin and Doctor)
Route::middleware(['auth'])->group(function () {
    // Profile routes accessible by both admin and doctor
    Route::get('/settings', [ProfileController::class, 'setting'])->name('settings');
    Route::post('/update-user-profile', [ProfileController::class, 'updateProfile'])->name('update-user-profile');
    Route::post('/profile-image-store', [ProfileController::class, 'updateAvatar'])->name('profile-image-store');
    Route::post('/avatar-delete', [ProfileController::class, 'deleteAvatar'])->name('avatar-delete');
    Route::post('/user-update-password', [ProfileController::class, 'updateUserPassword'])->name('user-update-password');
});

// Test routes for email templates (only for development/testing)
Route::get('/test-approval-email', function () {
    $email = 'test@example.com';
    $doctorName = 'John Doe';
    $loginUrl = route('doctor.login');

    $result = \App\Services\MailService::sendDoctorApprovalEmail($email, $doctorName, $loginUrl);

    return response()->json([
        'success' => $result,
        'message' => $result ? 'Approval email sent successfully' : 'Failed to send approval email'
    ]);
});

Route::get('/test-rejection-email', function () {
    $email = 'test@example.com';
    $doctorName = 'Jane Smith';
    $reason = 'Incomplete documentation provided';

    $result = \App\Services\MailService::sendDoctorRejectionEmail($email, $doctorName, $reason);

    return response()->json([
        'success' => $result,
        'message' => $result ? 'Rejection email sent successfully' : 'Failed to send rejection email'
    ]);
});
