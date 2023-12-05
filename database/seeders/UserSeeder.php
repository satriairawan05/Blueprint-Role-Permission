<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guard = 'web';

        $admin = User::create([
            'name' => 'Muhammad Rois Akbar',
            'email' => 'rois.akbar74@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $roleAdmin = Role::create(['name' => 'admin', 'guard_name' => $guard]);

        $direksi = User::create([
            'name' => 'Muhammad Arya Praptama',
            'email' => 'aryaprd074@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $roleDireksi = Role::create(['name' => 'direksi', 'guard_name' => $guard]);

        $user = User::create([
            'name' => 'Muhammad Wahyu Safiul Alam',
            'email' => 'mwahyu99@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $roleUser = Role::create(['name' => 'user', 'guard_name' => $guard]);

        $readDashboard = Permission::create(['name' => 'read dashboard']);

        $admin->assignRole(['admin']);
        $admin->givePermissionTo($readDashboard);
        $roleAdmin->syncPermissions($readDashboard);

        $direksi->assignRole(['direksi']);
        $direksi->givePermissionTo($readDashboard);
        $roleDireksi->syncPermissions($readDashboard);

        $user->assignRole(['user']);
        $user->givePermissionTo($readDashboard);
        $roleUser->syncPermissions($readDashboard);
    }
}
