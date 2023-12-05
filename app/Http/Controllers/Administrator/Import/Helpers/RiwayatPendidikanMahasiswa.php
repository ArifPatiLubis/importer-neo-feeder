<?php

namespace App\Http\Controllers\Administrator\Import\Helpers;

use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RiwayatPendidikanMahasiswa implements
    ToCollection,
    WithHeadingRow,
    WithValidation,
    SkipsOnError,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }

    public function headingRow(): int
    {
        return 3;
    }

    public function rules(): array
    {
        
        return [ 

            '*.id_mahasiswa' => '',
            '*.nim' => '',
            '*.id_jenis_daftar' => '',
            '*.id_jalur_daftar' => '',
            '*.id_periode_masuk' => '',
            '*.tanggal_daftar' => '',
            '*.id_perguruan_tinggi' => '',
            '*.id_prodi' => '',
            '*.id_bidang_minat' => '',
            '*.sks_diakui' => '',
            '*.id_perguruan_tinggi_asal' => '',
            '*.id_prodi_asal' => '',
            '*.id_pembiayaan' => '',
            '*.biaya_masuk' => '',
        ];
    }
}
