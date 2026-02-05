<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('name', 'superadmin')->firstOrFail();
        User::create([
            'name' => 'superadmin',
            'email' => 'super.admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $role->id
        ]);
    }
}
