<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $default_email = 'user@pace.test';
        $admin = User::where('email', $default_email)->first();

        if(!$admin){
            $admin_new = User::create([
                'name' => 'Pace Admin',
                'email' => $default_email,
                'password' => Hash::make('String1234!'),
                'type' => 'user' 
            ]);
        }
    }
}
