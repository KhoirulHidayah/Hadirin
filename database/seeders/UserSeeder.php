<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'admin',
            'email' => 'ruyya63@gmail.com',
            'email_verified_at' => Carbon::now(), // ← Isi jika ingin email dianggap terverifikasi
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10), // ← Token login remember me
        ]);
    }
}
