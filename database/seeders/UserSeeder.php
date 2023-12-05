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

        $createUser = Permission::create(['page' => 'user', 'name' => 'user.create']);
        $readUser = Permission::create(['page' => 'user', 'name' => 'user.read']);
        $updateUser = Permission::create(['page' => 'user', 'name' => 'user.update']);
        $deleteUser = Permission::create(['page' => 'user', 'name' => 'user.delete']);

        $admin->assignRole(['admin']);
        $admin->givePermissionTo($createUser);
        $admin->givePermissionTo($readUser);
        $admin->givePermissionTo($updateUser);
        $admin->givePermissionTo($deleteUser);
        $roleAdmin->syncPermissions($createUser);
        $roleAdmin->syncPermissions($readUser);
        $roleAdmin->syncPermissions($updateUser);
        $roleAdmin->syncPermissions($deleteUser);

        $direksi->assignRole(['direksi']);
        $direksi->givePermissionTo($createUser);
        $direksi->givePermissionTo($readUser);
        $direksi->givePermissionTo($updateUser);
        $direksi->givePermissionTo($deleteUser);
        $roleDireksi->syncPermissions($createUser);
        $roleDireksi->syncPermissions($readUser);
        $roleDireksi->syncPermissions($updateUser);
        $roleDireksi->syncPermissions($deleteUser);

        $user->assignRole(['user']);
        $user->givePermissionTo($createUser);
        $user->givePermissionTo($readUser);
        $user->givePermissionTo($updateUser);
        $user->givePermissionTo($deleteUser);
        $roleUser->syncPermissions($createUser);
        $roleUser->syncPermissions($readUser);
        $roleUser->syncPermissions($updateUser);
        $roleUser->syncPermissions($deleteUser);
    }
}
