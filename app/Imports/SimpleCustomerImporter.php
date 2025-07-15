<?php

namespace App\Imports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SimpleCustomerImporter implements ToModel, WithHeadingRow
{
    protected $processed = 0;
    protected $inserted = 0;
    protected $updated = 0;
    protected $errors = [];

    public function model(array $row)
    {
        $this->processed++;

        try {
            $pegawai = Pegawai::updateOrCreate(
                ['nip' => $row['nip']],
                [
                    'nama' => $row['nama'],
                    'jabatan' => $row['jabatan'],
                    'email' => $row['email'],
                    'no_hp' => $row['no_hp'],
                    'asal_instansi' => $row['asal_instansi'],
                ]
            );

            if ($pegawai->wasRecentlyCreated) {
                $this->inserted++;
            } else {
                $this->updated++;
            }

        } catch (\Exception $e) {
            $this->errors[] = [
                'nip' => $row['nip'] ?? null,
                'error' => $e->getMessage()
            ];
        }

        return null;
    }

    public function getProcessedCount() { return $this->processed; }
    public function getInsertedCount() { return $this->inserted; }
    public function getUpdatedCount() { return $this->updated; }
    public function getErrors() { return $this->errors; }
}
