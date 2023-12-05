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

class PesertaKelasJob implements ShouldQueue
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
                $getDataMahasiswa = new NeoFeeder([
                    "act" => 'GetListMahasiswa',
                    "filter" => "nim = '" . $data['nim'] ."'",
                    "order" => '',
                    "limit" => '',
                    "offset" => '0'
                ]);

                $getKodeMatkul = new NeoFeeder([
                    "act" => 'GetListKelasKuliah',
                    "filter" => "kode_mata_kuliah = '" . $data['kode_mata_kuliah'] ."' AND id_semester = '" . $data['id_semester'] ."' 
                    AND nama_kelas_kuliah = '".$data['nama_kelas_kuliah']."' ",
                    "order" => '',
                    "limit" => '',
                    "offset" => '0'
                ]);
                
                $registrasiMahasiswa = $getDataMahasiswa->getData();
                
                if(sizeOf($registrasiMahasiswa['data']) == 0) {

                    throw new Exception('Mahasiswa dengan NIM : ' .$data['nim'].' tidak ditemukan');
                }

                $kodeMatkul = $getKodeMatkul->getData();
                

                if(sizeOf($kodeMatkul['data']) == 0) {

                    throw new Exception('Kelas Perkuliahan dengan kode : ' .$data['kode_mata_kuliah'].' tidak ditemukan');
                }

                $recordInsertPesertaKuliah = [
                    'id_kelas_kuliah' => $kodeMatkul['data'][0]['id_kelas_kuliah'],
                    'id_registrasi_mahasiswa' =>  $registrasiMahasiswa['data'][0]['id_registrasi_mahasiswa']
                ];
                

                $insertPeserta = new NeoFeeder([
                    'act' => 'InsertPesertaKelasKuliah',
                    'record' => $recordInsertPesertaKuliah
                ]);
                
                $responseInsertPeserta = $insertPeserta->getData();


                if($responseInsertPeserta['error_code'] == '0') {

                    $user = Auth::user();
                    $userName = $user->nama_pengguna;

                    ImportLog::create([
                        'act' => 'InsertPesertaKelasKuliah',
                        'nama_pengguna' => $userName,
                        'status' => 'Sukses',
                        'description' => 'Mahasiswa dengan NIM : ' .$data['nim'].' sukses ditambahkan.'
                    ]);

                } else {

                    throw new Exception($responseInsertPeserta['error_desc']);
                }


            }catch (Exception $e) {

                $errorLog = $e->getMessage();

                $user = Auth::user();
                $userName = $user->nama_pengguna;

                ImportLog::create([
                    'act' => 'InsertPesertaKelasKuliah',
                    'nama_pengguna' => $userName,
                    'status' => 'Gagal',
                    'description' => 'Mahasiswa dengan NIM ' .$data['nim'].' gagal ditambah ,' . strtolower($errorLog) .'.'
                ]);
            }
        }
    }
}
