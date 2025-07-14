<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PresenceDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel dan reset auto increment
        DB::table('presence_details')->delete();
        DB::statement('ALTER TABLE presence_details AUTO_INCREMENT = 1');

        $this->call([
            PresenceDetailSeeder::class,
        ]);
    }
}
