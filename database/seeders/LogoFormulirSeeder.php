<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LogoFormulir;

class LogoFormulirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LogoFormulir::create([
            'app_name' => 'ABSENSI ONLINE',
            'header_title' => 'PT PLN (Persero) UPT Malang',
            'logo_left' => null,
            'logo_right' => null,
        ]);
    }
}

