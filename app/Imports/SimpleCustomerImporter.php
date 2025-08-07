<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SimpleCustomerImporter implements ToModel, WithHeadingRow, WithStartRow
{
    protected $processed = 0;
    protected $inserted = 0;
    protected $updated = 0;
    protected $errors = [];

    public function startRow(): int
    {
        return 2; // Skip header row
    }

    public function model(array $row)
    {
        $this->processed++;

        // Map columns based on your Excel structure
        // A=No, B=Nama, C=NIP, D=Email, E=Jabatan, F=No HP, G=Unit(asal_instansi), H=Perusahaan(kategori), I=Tanda Tangan
        
        $no            = trim($row['no'] ?? '');
        $nama          = trim($row['nama'] ?? '');
        $nip           = trim($row['nip'] ?? '');
        $email         = trim($row['email'] ?? '');
        $jabatan       = trim($row['jabatan'] ?? '');
        $no_hp         = trim($row['no_hp'] ?? '');
        $asal_instansi = trim($row['unit'] ?? ''); // Unit column maps to asal_instansi
        $kategori      = trim($row['perusahaan'] ?? ''); // Perusahaan column maps to kategori
        
        // Skip empty rows
        if (!$nama && !$nip && !$email) {
            return null;
        }

        // Validasi wajib isi
        if (!$nip || !$nama || !$jabatan || !$email || !$no_hp || !$asal_instansi || !$kategori) {
            $this->errors[] = [
                'row' => $this->processed + 1, // +1 because we start from row 2
                'nip' => $nip ?: 'NIP Kosong',
                'error' => "Semua field wajib diisi (No, Nama, NIP, Email, Jabatan, No HP, Unit, Perusahaan)."
            ];
            return null;
        }

        // Validasi kategori exists in database
        $kategoriValid = Kategori::where('nama', $kategori)->first();
        if (!$kategoriValid) {
            $this->errors[] = [
                'row' => $this->processed + 1,
                'nip' => $nip,
                'error' => "Perusahaan '{$kategori}' tidak ditemukan di database. Pastikan data perusahaan sudah ada."
            ];
            return null;
        }

        // Validasi email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = [
                'row' => $this->processed + 1,
                'nip' => $nip,
                'error' => "Format email tidak valid: '{$email}'. Gunakan format yang benar seperti user@email.com"
            ];
            return null;
        }

        // Validasi nomor HP (minimal 10 digit dan hanya angka)
        $no_hp_clean = preg_replace('/[^0-9]/', '', $no_hp); // Remove non-numeric characters
        if (strlen($no_hp_clean) < 10) {
            $this->errors[] = [
                'row' => $this->processed + 1,
                'nip' => $nip,
                'error' => "Nomor HP tidak valid: '{$no_hp}'. Minimal 10 digit angka."
            ];
            return null;
        }

        // Validasi NIP unique (kecuali untuk update)
        $existingPegawai = Pegawai::where('nip', $nip)->first();
        if ($existingPegawai) {
            // Check if email conflict with different NIP
            $emailConflict = Pegawai::where('email', $email)->where('nip', '!=', $nip)->first();
            if ($emailConflict) {
                $this->errors[] = [
                    'row' => $this->processed + 1,
                    'nip' => $nip,
                    'error' => "Email '{$email}' sudah digunakan oleh pegawai dengan NIP berbeda."
                ];
                return null;
            }
        }

        try {
            $pegawai = Pegawai::updateOrCreate(
                ['nip' => $nip],
                [
                    'nama'           => $nama,
                    'jabatan'        => $jabatan,
                    'email'          => $email,
                    'no_hp'          => $no_hp_clean, // Use cleaned phone number
                    'asal_instansi'  => $asal_instansi,
                    'kategori'       => $kategori,
                ]
            );

            if ($pegawai->wasRecentlyCreated) {
                $this->inserted++;
            } else {
                $this->updated++;
            }

            return $pegawai;

        } catch (\Exception $e) {
            $this->errors[] = [
                'row' => $this->processed + 1,
                'nip' => $nip,
                'error' => "Database error: " . $e->getMessage()
            ];
            return null;
        }
    }

    public function getProcessedCount() 
    { 
        return $this->processed; 
    }
    
    public function getInsertedCount() 
    { 
        return $this->inserted; 
    }
    
    public function getUpdatedCount() 
    { 
        return $this->updated; 
    }
    
    public function getErrors() 
    { 
        return $this->errors; 
    }
}