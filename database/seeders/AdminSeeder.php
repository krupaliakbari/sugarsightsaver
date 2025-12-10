<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $doctorRole = Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web']);
        $patientRole = Role::firstOrCreate(['name' => 'patient', 'guard_name' => 'web']);

        // Create permissions
        $permissions = [
            'view-dashboard',
            'manage-users',
            'manage-doctors',
            'manage-patients',
            'view-profile',
            'edit-profile',
            'change-password'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions);
        $doctorRole->givePermissionTo(['view-dashboard', 'view-profile', 'edit-profile', 'change-password', 'manage-patients']);
        $patientRole->givePermissionTo(['view-profile', 'edit-profile', 'change-password']);

        // Create default admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'phone' => '1234567890',
                'status' => 'active',
                'user_type' => 'admin',
                'approval_status' => 'approved'
            ]
        );
        $adminUser->assignRole('admin');

        // Create default doctor user
        $doctorUser = User::firstOrCreate(
            ['email' => 'doctor@admin.com'],
            [
                'name' => 'Dr. John Smith',
                'email' => 'doctor@admin.com',
                'password' => Hash::make('doctor123'),
                'phone' => '1234567892',
                'status' => 'active',
                'user_type' => 'doctor',
                'hospital_name' => 'City General Hospital',
                'address' => '123 Medical Center, City, State',
                'doctor_type' => 'diabetes_treating',
                'qualification' => 'MD, Internal Medicine',
                'approval_status' => 'approved'
            ]
        );
        $doctorUser->assignRole('doctor');

        // Create default patient user
        $patientUser = User::firstOrCreate(
            ['email' => 'patient@admin.com'],
            [
                'name' => 'Patient',
                'email' => 'patient@admin.com',
                'password' => Hash::make('patient123'),
                'phone' => '1234567893',
                'status' => 'active',
                'user_type' => 'patient',
                'approval_status' => 'approved'
            ]
        );
        $patientUser->assignRole('patient');
    }
}
