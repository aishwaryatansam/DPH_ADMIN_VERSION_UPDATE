<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'username' => 'TNDPHPMSA001',
            'user_type_id' => _superAdminUserTypeId(),
            'email' => 'superadmin@tndphpm.com',
            'contact_number' => '99999999999',
            'status' => _active(),
            'password' => Hash::make('SuperAdmin@tndphpm.com'),
        ]);
        User::create([
            'name' => 'Sub Admin',
            'username' => 'TNDPHPMAD001',
            'user_type_id' => _subAdminUserTypeId(),
            'email' => 'subadmin@tndphpm.com',
            'contact_number' => '99999999999',
            'status' => _active(),
            'password' => Hash::make('SubAdmin@tndphpm.com'),
        ]);
        User::create([
            'name' => 'Employee 1',
            'username' => 'TNDPHPMUS001',
            'user_type_id' => _employeeUserTypeId(),
            'email' => 'user_1@tndphpm.com',
            'contact_number' => '99999999999',
            'status' => _active(),
            'password' => Hash::make('User1@tndphpm.com'),
        ]);
    }
}
