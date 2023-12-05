<?php

namespace App\Http\Controllers\Administrator\Import\Antrian;

use App\Models\ImportLog;
use App\Helpers\NeoFeeder;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class BiodataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;

    }

    public function handle()
    {
        foreach ($this->data as $key => $data) {
            try {
                $recordInsertBiodataMahasiswa = [
                    'nama_mahasiswa' => $data['nama_mahasiswa'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tempat_lahir' => $data['tempat_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'id_agama' => $data['id_agama'],
                    'nik' => $data['nik'],
                    'nisn' => $data['nisn'],
                    'npwp' => $data['npwp'] ?? '',
                    'kewarganegaraan' => $data['kewarganegaraan'],
                    'jalan' => $data['jalan'] ?? '',
                    'dusun' => $data['dusun'] ?? '',
                    'rt' => $data['rt'] ?? '',
                    'rw' => $data['rw'] ?? '',
                    'kelurahan' => $data['kelurahan'],
                    'kode_pos' => $data['kode_pos'] ?? '',
                    'id_wilayah' => $data['id_wilayah'],
                    'id_jenis_tinggal' => $data['id_jenis_tinggal'] ?? '',
                    'id_alat_transportasi' => $data['id_alat_transportasi'] ?? '',
                    'telepon' => $data['telepon'] ?? '',
                    'handphone' => $data['handphone'] ?? '',
                    'email' => $data['email'] ?? '',
                    'penerima_kps' => $data['penerima_kps'],
                    'nomor_kps' => $data['nomor_kps'] ?? '',
                    'nik_ayah' => $data['nik_ayah'] ?? '',
                    'nama_ayah' => $data['nama_ayah'] ?? '',
                    'tanggal_lahir_ayah' => $data['tanggal_lahir_ayah'] ?? '',
                    'id_pendidikan_ayah' => $data['id_pendidikan_ayah'] ?? '',
                    'id_pekerjaan_ayah' => $data['id_pekerjaan_ayah'] ?? '',
                    'id_penghasilan_ayah' => $data['id_penghasilan_ayah'] ?? '',
                    'nik_ibu' => $data['nik_ibu'] ?? '',
                    'nama_ibu_kandung' => $data['nama_ibu_kandung'],
                    'tanggal_lahir_ibu' => $data['tanggal_lahir_ibu'] ?? '',
                    'id_pendidikan_ibu' => $data['id_pendidikan_ibu'] ?? '',
                    'id_pekerjaan_ibu' => $data['id_pekerjaan_ibu'] ?? '',
                    'id_penghasilan_ibu' => $data['id_penghasilan_ibu'] ?? '',
                    'nama_wali' => $data['nama_wali'] ?? '',
                    'tanggal_lahir_wali' => $data['tanggal_lahir_wali'] ?? '',
                    'id_pendidikan_wali' => $data['id_pendidikan_wali'] ?? '',
                    'id_pekerjaan_wali' => $data['id_pekerjaan_wali'] ?? '',
                    'id_penghasilan_wali' => $data['id_penghasilan_wali'] ?? '',
                    'id_kebutuhan_khusus_mahasiswa' => $data['id_kebutuhan_khusus_mahasiswa'] ?? '0',
                    'id_kebutuhan_khusus_ayah' => $data['id_kebutuhan_khusus_ayah'] ?? '0',
                    'id_kebutuhan_khusus_ibu' => $data['id_kebutuhan_khusus_ibu'] ?? '0'
                ];

                $insertBiodataMahasiswa = new NeoFeeder([
                    'act' => 'InsertBiodataMahasiswa',
                    'record' => $recordInsertBiodataMahasiswa
                ]);

                $responseInsertBiodataMahasiswa = $insertBiodataMahasiswa->getData();

                if($responseInsertBiodataMahasiswa['error_code'] == '1209') {

                    $getDetailMahasiswa = new NeoFeeder([
                        'act' => 'GetBiodataMahasiswa',
                        "filter" =>"nik = '".$data['nik']."'"
                    ]);

                    $responDetailMhs = $getDetailMahasiswa->getData();
                    
                    $key = [
                        'id_mahasiswa' => $responDetailMhs['data'][0]['id_mahasiswa']
                    ];

                    $updateBiodata = new NeoFeeder([
                        'act' => 'UpdateBiodataMahasiswa',
                        'key' => $key,
                        'record' => $recordInsertBiodataMahasiswa
                    ]);

                    $responseUpdateBiodataMahasiswa = $updateBiodata->getData();

                    if($responseUpdateBiodataMahasiswa['error_code'] == '0') {

                        $user = Auth::user();
                        $userName = $user->nama_pengguna;

                        ImportLog::create([
                            'act' => 'UpdateBiodataMahasiswa',
                            'nama_pengguna' => $userName,
                            'status' => 'Sukses',
                            'description' => 'Biodata Mahasiswa ' . $data['nama_mahasiswa'] . ' berhasil diubah.'
                        ]);
                    } else {
                        throw new Exception($responseUpdateBiodataMahasiswa['error_desc']);
                    }

                } else {
                    throw new Exception($responseInsertBiodataMahasiswa['error_desc']);
                }
            }catch (Exception $e) {

                $errorLog = $e->getMessage();
                
                $user = Auth::user();
                $userName = $user->nama_pengguna;
                
                ImportLog::create([
                    'act' => 'InsertRiwayatPendidikanMahasiswa',
                    'nama_pengguna' => $userName,
                    'status' => 'Gagal',
                    'description' => 'Mahasiswa dengan nama ' . $data['nama_mahasiswa']  . ' gagal ditambah karena ' . strtolower($errorLog) .'.'
                ]);
            }
        }
    }
}
