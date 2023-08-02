<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ADMIN',
            'lastname' => 'ADMIN',
            'email' => 'admin@klein.loc',
            'password' => Hash::make('123123'),
            'status' => User::STATUS_ACTIVE,
            'role' => User::ROLE_ADMIN,
            'phone' => 11111,
            'phone_verified' => true,
        ]);
    }
}
