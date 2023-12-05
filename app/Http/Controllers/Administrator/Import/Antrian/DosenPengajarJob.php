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

class DosenPengajarJob implements ShouldQueue
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

                $getDataDosen = new NeoFeeder([
                    "act" => 'GetListPenugasanDosen',
                    "filter" => "nidn = '" . $data['nidn'] ."' AND id_tahun_ajaran = '". $data['id_tahun_ajaran']."'",
                    "order" => '',
                    "limit" => '',
                    "offset" => '0'
                ]);
                
                $getKodeMatkul = new NeoFeeder([
                    "act" => 'GetListKelasKuliah',
                    "filter" => "kode_mata_kuliah = '" . $data['kode_mata_kuliah'] ."' AND nama_kelas_kuliah = '" . $data['nama_kelas_kuliah'] ."'
                                    AND id_semester = '" . $data['id_semester'] ."'",
                    "order" => '',
                    "limit" => '',
                    "offset" => '0'
                ]);
                
                $dosenPengajar = $getDataDosen->getData();
                
                
                if(sizeOf($dosenPengajar['data']) == 0) {

                    throw new Exception('Dosen dengan NIP/NIDN : ' .$data['nidn'].' - ' .$data['nama_dosen'].' tidak ditemukan');
                }

                $kodeMatkul = $getKodeMatkul->getData();
                
                if(sizeOf($kodeMatkul['data']) == 0) {

                    throw new Exception('Kelas Perkuliahan dengan kode : ' .$data['kode_mata_kuliah'].' - '.$data['nama_kelas_kuliah'].' tidak ditemukan');
                }

                $recordInsertPesertaKuliah = [
                    'id_registrasi_dosen' => $dosenPengajar['data'][0]['id_registrasi_dosen'],
                    'id_kelas_kuliah' =>  $kodeMatkul['data'][0]['id_kelas_kuliah'],
                    'sks_substansi_total' => $data['sks_substansi_total'] ,
                    'sks_tm_subst' =>  $data['sks_tm_subst'],
                    'sks_prak_subst' =>   $data['sks_prak_subst'],
                    'sks_prak_lap_subst' =>   $data['sks_prak_lap_subst'],
                    'rencana_minggu_pertemuan' =>   $data['rencana_minggu_pertemuan'],
                    'realisasi_minggu_pertemuan' =>  $data['realisasi_minggu_pertemuan'],
                    'id_jenis_evaluasi' =>   $data['id_jenis_evaluasi'],
                    // 'id_substansi' => $kodeMatkul['data'][0]['id_kelas_kuliah'],
                    // 'sks_sim_subst' =>  $data['sks_sim_subst'],
                ];
                
                $insertPeserta = new NeoFeeder([
                    'act' => 'InsertDosenPengajarKelasKuliah',
                    // 'key' => $recordInsertPesertaKuliah    //key digunakan kalo delete
                    'record' => $recordInsertPesertaKuliah
                ]);
                
                $responseInsertPeserta = $insertPeserta->getData();

                if($responseInsertPeserta['error_code'] == '0') {

                    $user = Auth::user();
                    $userName = $user->nama_pengguna;

                    ImportLog::create([
                        'act' => 'InsertDosenPengajarKelasKuliah',
                        'status' => 'Sukses',
                        'nama_pengguna' => $userName,
                        'description' => 'Dosen dengan nidn : ' .$data['nidn'].' - ' .$data['nama_dosen'].' sukses ditambahkan.'
                    ]);

                } else {

                    throw new Exception($responseInsertPeserta['error_desc']);
                }


            }catch (Exception $e) {

                $errorLog = $e->getMessage();
                
                $user = Auth::user();
                $userName = $user->nama_pengguna;

                ImportLog::create([
                    'act' => 'InsertDosenPengajarKelasKuliah',
                    'nama_pengguna' => $userName,
                    'status' => 'Gagal',
                    'description' => 'Dosen dengan nidn : ' .$data['nidn'].' - ' .$data['nama_dosen'].' gagal ditambah, ' . strtolower($errorLog) .'.'
                ]);
            }
        }
    }
}
