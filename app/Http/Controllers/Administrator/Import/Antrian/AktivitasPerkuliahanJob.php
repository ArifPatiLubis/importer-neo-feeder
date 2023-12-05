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

class AktivitasPerkuliahanJob implements ShouldQueue
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
                    "filter" => "nim = '" . $data['nim'] ."' AND nama_status_mahasiswa='AKTIF'",
                    "order" => '',
                    "limit" => '',
                    "offset" => '0'
                ]);

                $registrasiMahasiswa = $getDataMahasiswa->getData();
                //dd($registrasiMahasiswa);
                $dataMhs = $registrasiMahasiswa['data'][0];

                if(sizeOf($registrasiMahasiswa['data']) == 0) {

                    throw new Exception('Mahasiswa dengan NIM : ' .$data['nim'].' tidak ditemukan;');
                }
                
                $recordInsertPerkuliahanMahasiswa = [
                    'id_registrasi_mahasiswa' => $dataMhs['id_registrasi_mahasiswa'],
                    'id_semester' => strval($data['id_semester']),
                    'id_status_mahasiswa' => strval($data['id_status_mahasiswa']),
                    'ips' => strval($data['ips']),
                    'ipk' => strval($data['ipk']),
                    'sks_semester' => strval($data['sks_semester']),
                    'total_sks' => strval($data['total_sks']),
                    'biaya_kuliah_smt' => strval($data['biaya_kuliah_smt']),
                    'id_pembiayaan' => strval($data['id_pembiayaan'])
                ];
                
                $key = [
                    'id_registrasi_mahasiswa' => $dataMhs['id_registrasi_mahasiswa'],
                    'id_semester' => strval($data['id_semester']),
                ];

                $insertPerkuliahanMahasiswa = new NeoFeeder([
                    'act' => 'InsertPerkuliahanMahasiswa',
                    // 'key' => $key,
                    'record' => $recordInsertPerkuliahanMahasiswa
                ]);

                $responseInsertPerkuliahanMahasiswa = $insertPerkuliahanMahasiswa->getData();
                // dd($responseInsertPerkuliahanMahasiswa);

                if($responseInsertPerkuliahanMahasiswa['error_code'] == '0') {

                    $user = Auth::user();
                    $userName = $user->nama_pengguna;

                    ImportLog::create([
                        'act' => 'InsertPerkuliahanMahasiswa',
                        'nama_pengguna' => $userName,
                        'status' => 'Sukses',
                        'description' => 'Mahasiswa dengan NIM ' . $data['nim'] .  ' berhasil menambah status aktivitas mahasiswa.'
                    ]);
                } 
                if($responseInsertPerkuliahanMahasiswa['error_code'] == '15'){

                    $updatePerkuliahanMahasiswa = new NeoFeeder([
                        'act' => 'UpdatePerkuliahanMahasiswa',
                        'key' => $key,
                        'record' => $recordInsertPerkuliahanMahasiswa
                    ]);
                    
                    $responseUpdatePerkuliahanMahasiswa = $updatePerkuliahanMahasiswa->getData();
                    // dd($updatePerkuliahanMahasiswa);
                    if($responseUpdatePerkuliahanMahasiswa['error_code'] == '0') {

                        $user = Auth::user();
                        $userName = $user->nama_pengguna;

                        ImportLog::create([
                            'act' => 'UpdatePerkuliahanMahasiswa',
                            'nama_pengguna' => $userName,
                            'status' => 'Sukses',
                            'description' => 'Mahasiswa dengan NIM ' . $data['nim'] .  ' berhasil memperbarui status aktivitas mahasiswa.'
                        ]);
                    } 
                    if($responseUpdatePerkuliahanMahasiswa['error_code'] == '1190') {

                        $user = Auth::user();
                        $userName = $user->nama_pengguna;

                        ImportLog::create([
                            'act' => 'InsertPerkuliahanMahasiswa',
                            'nama_pengguna' => $userName,
                            'status' => 'Gagal',
                            'description' => 'Mahasiswa dengan NIM ' . $data['nim'] .  ' - ' .$responseUpdatePerkuliahanMahasiswa['error_desc']. '.'
                        ]);
                    } 
                    else {
                        throw new Exception($responseUpdatePerkuliahanMahasiswa['error_desc']);
                    }
                }
                if($responseInsertPerkuliahanMahasiswa['error_code'] == '1260'){

                    $updatePerkuliahanMahasiswa = new NeoFeeder([
                        'act' => 'UpdatePerkuliahanMahasiswa',
                        'key' => $key,
                        'record' => $recordInsertPerkuliahanMahasiswa
                    ]);
                    
                    $responseUpdatePerkuliahanMahasiswa = $updatePerkuliahanMahasiswa->getData();
                    // dd($updatePerkuliahanMahasiswa);
                    if($responseUpdatePerkuliahanMahasiswa['error_code'] == '0') {
                        
                        $user = Auth::user();
                        $userName = $user->nama_pengguna;

                        ImportLog::create([
                            'act' => 'UpdatePerkuliahanMahasiswa',
                            'nama_pengguna' => $userName,
                            'status' => 'Sukses',
                            'description' => 'Mahasiswa dengan NIM ' . $data['nim'] .  ' berhasil memperbarui status aktivitas mahasiswa.'
                        ]);
                    } 
                    if($responseUpdatePerkuliahanMahasiswa['error_code'] == '1190') {
                                
                        $user = Auth::user();
                        $userName = $user->nama_pengguna;

                        ImportLog::create([
                            'act' => 'InsertPerkuliahanMahasiswa',
                            'nama_pengguna' => $userName,
                            'status' => 'Gagal',
                            'description' => 'Mahasiswa dengan NIM ' . $data['nim'] .  ' - ' .$responseUpdatePerkuliahanMahasiswa['error_desc']. '.'
                        ]);
                    } 
                    else {
                        throw new Exception($responseUpdatePerkuliahanMahasiswa['error_desc']);
                    }
                } else {
                    throw new Exception($responseInsertPerkuliahanMahasiswa['error_desc']);
                }
                
            } catch (Exception $e) {

                $errorLog = $e->getMessage();
                
                $user = Auth::user();
                $userName = $user->nama_pengguna;

                if($errorLog != null) {
                ImportLog::create([
                    'act' => 'InsertPerkuliahanMahasiswa',
                    'nama_pengguna' => $userName,
                    'status' => 'Gagal',
                    'description' => 'Mahasiswa dengan NIM - ' . $data['nim'] .  ' : ' . strtolower($errorLog) .'.'
                ]);
                }
            }
        }
    }
}
