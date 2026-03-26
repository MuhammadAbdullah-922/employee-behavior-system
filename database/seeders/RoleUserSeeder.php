<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Insert roles
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'Employee'], // ✅ Added Employee
            // ['name' => 'Branch Manager'], // ❌ commented
            // ['name' => 'Supervisor'],     // ❌ commented
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        // 2️⃣ Create default admin user
        $adminRoleId = DB::table('roles')->where('name', 'Admin')->first()->id;

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role_id' => $adminRoleId,
                'email_verified_at' => now(),
            ]
        );

        // 3️⃣ Create default Employee user
        $employeeRoleId = DB::table('roles')->where('name', 'Employee')->first()->id;

        User::updateOrCreate(
            ['email' => 'employee@company.com'],
            [
                'name' => 'Employee User',
                'password' => Hash::make('employee123'),
                'role_id' => $employeeRoleId,
                'email_verified_at' => now(),
            ]
        );

        /*
        // ❌ Branch Manager (commented for now)
        $managerRoleId = DB::table('roles')->where('name', 'Branch Manager')->first()->id;

        User::updateOrCreate(
            ['email' => 'manager@branch.com'],
            [
                'name' => 'Branch Manager',
                'password' => Hash::make('manager123'),
                'role_id' => $managerRoleId,
                'email_verified_at' => now(),
            ]
        );

        // ❌ Supervisor (commented for now)
        $supervisorRoleId = DB::table('roles')->where('name', 'Supervisor')->first()->id;

        User::updateOrCreate(
            ['email' => 'supervisor@company.com'],
            [
                'name' => 'Supervisor',
                'password' => Hash::make('supervisor123'),
                'role_id' => $supervisorRoleId,
                'email_verified_at' => now(),
            ]
        );
        */

        $this->command->info('Admin & Employee seeded successfully!');
    }
}