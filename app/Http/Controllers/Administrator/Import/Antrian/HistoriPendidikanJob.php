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

class HistoriPendidikanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $idProdi;

    public function __construct($data, $idProdi)
    {
        $this->data = $data;
        $this->idProdi = $idProdi;

    }

    public function handle()
    {
        foreach ($this->data as $key => $data) {
            try {

                $getDetailMahasiswa = new NeoFeeder([
                    'act' => 'GetBiodataMahasiswa',

                    "filter" =>"nik = '".$data['nik']."' AND nama_mahasiswa = UPPER('".$data['nama_mahasiswa']."') 
                    OR nama_mahasiswa = LOWER('".$data['nama_mahasiswa']."')"
                
                ]);
                
                $responDetailMhs = $getDetailMahasiswa->getData();
                
                $getProfilPT = new NeoFeeder([
                    'act' => 'GetProfilPT'
                ]);

                $responPT = $getProfilPT->getData();

                $recordInsertRiwayatMahasiswa = [
                    
                    'id_mahasiswa' => strval($responDetailMhs['data'][0]['id_mahasiswa']),
                    'nim' => strval($data['nim']),
                    'id_jenis_daftar' => strval($data['id_jenis_daftar']), #wajib isi 1 = perserta didik baru
                    'id_jalur_daftar' => strval($data['id_jalur_daftar']),
                    'id_periode_masuk' => strval($data['id_periode_masuk']),
                    'tanggal_daftar' => strval($data['tanggal_daftar']),
                    'id_perguruan_tinggi' => $responPT['data'][0]['id_perguruan_tinggi'],
                    'id_prodi' =>$this->idProdi,
                    'id_bidang_minat' => '',
                    'sks_diakui' => '',
                    'id_perguruan_tinggi_asal' => '',
                    'id_prodi_asal' => '',
                    'id_pembiayaan' => $data['id_pembiayaan'],
                    'biaya_masuk' => $data['biaya_masuk']
                ];

                $insertRiwayatPendidikanMahasiswa = new NeoFeeder([
                    'act' => 'InsertRiwayatPendidikanMahasiswa',
                    'record' => $recordInsertRiwayatMahasiswa
                ]);
                
                $responseInsertRiwayatMahasiswa = $insertRiwayatPendidikanMahasiswa->getData();

                // //dd($insertRiwayatPendidikanMahasiswa);

                if ($responseInsertRiwayatMahasiswa['error_code'] == '0') {
    
                    $user = Auth::user();
                    $userName = $user->nama_pengguna;

                    ImportLog::create([
                        'act' => 'InsertRiwayatPendidikanMahasiswa',
                        'nama_pengguna' => $userName,
                        'status' => 'Sukses',
                        'description' => 'Mahasiswa dengan nama ' . $data['nama_mahasiswa']  . '-' . $data['nim'] . ' sukses ditambah.'
                    ]);
                    
                } 
                else {

                    throw new Exception($responseInsertRiwayatMahasiswa['error_desc']);
                }

            } catch (Exception $e) {

                $errorLog = $e->getMessage();
                
                $user = Auth::user();
                $userName = $user->nama_pengguna;

                ImportLog::create([
                    'act' => 'InsertRiwayatPendidikanMahasiswa',
                    'status' => 'Gagal',
                    'nama_pengguna' => $userName,
                    'description' => 'Mahasiswa dengan nama ' . $data['nama_mahasiswa']  . '-' . $data['nim'] . ' gagal ditambah karena ' . strtolower($errorLog) .'.'
                    // 'description' => 'Mahasiswa dengan nama ' . $data['nim'] . ' gagal ditambah karena ' . strtolower($errorLog) .'.'
                ]);
            }
        }
    }
}
