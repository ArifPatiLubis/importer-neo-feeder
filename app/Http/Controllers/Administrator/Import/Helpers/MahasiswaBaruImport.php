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

class MahasiswaBaruImport implements
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
            '*.nim' => '',
            '*.nama_mahasiswa' => '',
            '*.jenis_kelamin' => '',
            '*.tempat_lahir' => '',
            '*.tanggal_lahir' => '',
            '*.id_agama' => '',
            '*.nik' => '',
            '*.nisn' => '',
            '*.kewarganegaraan' => '',
            '*.kelurahan' => '',
            '*.id_wilayah' => '',
            '*.penerima_kps' => '',
            '*.nama_ibu_kandung' => '',
            '*.id_jalur_daftar' => '',
            '*.tanggal_daftar' => '',
            '*.id_pembiayaan' => '',
            '*.biaya_masuk' => '',
            '*.email' => '',
            '*.nik_ayah' => '',
            '*.tanggal_lahir_ayah' => '',
            '*.nik_ibu' => '',
            '*.tanggal_lahir_ibu' => '',
            '*.tanggal_lahir_wali' => '',
        ];
    }
}
