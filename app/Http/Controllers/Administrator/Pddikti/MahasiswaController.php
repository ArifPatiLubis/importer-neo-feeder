<?php

namespace App\Http\Controllers\Administrator\Pddikti;

ini_set('max_execution_time', 300);
use App\Helpers\NeoFeeder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    
    public function index(Request $request)
    {

        $query = request('program_studi_pengampu');
        $querysemester = request('semester_pendidikan'); 

        $getFakultas = new NeoFeeder([
            'act' => 'GetFakultas',
            'order' => "id_jenjang_pendidikan, nama_fakultas"
        ]);
        
        $getProdi = new NeoFeeder([
            'act' => 'GetProdi',
            'order' => "id_jenjang_pendidikan, nama_program_studi"
        ]);

        $getTitleProdi = new NeoFeeder([
            'act' => 'GetProdi',
            "filter" => "id_prodi = '" . $query ."'"
        ]);

        $getTitlePeriode = new NeoFeeder([
            'act' => 'GetSemester',
            "filter" => "id_semester = '" . $querysemester."'"
        ]);

        $getStatus = new NeoFeeder([
            'act' => 'GetStatusMahasiswa',
            'order' => ""
        ]);

        $getSemester = new NeoFeeder([
            'act' => 'GetSemester',
            // 'filter' => "a_periode_aktif = '1'",
            'order' => "id_semester desc"
        ]);
        
        $tahunajar = $getTitlePeriode->getData();
        $programstudi = $getTitleProdi->getData();

        
        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);
        
        return view('Administrator.Pddikti.mahasiswa', [
            'tahun_ajar' =>  $tahunajar,
            'program_studi' => $programstudi,
            'nama_prodi' => $query,
            'id_periode' => $querysemester,
            'status' => $getStatus->getData(),
            'fakultas' => $getFakultas->getData(),
            'prodi' => $getProdi->getData(),
            'semester' => $getSemester->getData()
        ]);
    }
    

    
    public function cari(Request $request)
    {

        if($request->ajax()) {
            
            $getDataMahasiswa = new NeoFeeder([
                "act" => 'GetListMahasiswa',
	            "filter" => "id_prodi = '" . $request["id_prodi"] ."' AND id_periode = '" . $request["id_periode"] ."'",
	            "order" => '',
	            "limit" => '',
	            "offset" => '0'
            ]);
            
            return $getDataMahasiswa->getData();
        }
    }

    public function nim(Request $request)
    {

        $query = request('nim');
        
        if($request->ajax()) {
            
            $getDataMahasiswa = new NeoFeeder([
                "act" => 'GetListMahasiswa',
	            "filter" => "nim = '" . $request["nim"] ."'",
	            "order" => '',
	            "limit" => '',
	            "offset" => '0'
            ]);

            // "filter" => "id_prodi = '" . $request["id_prodi"] ."', id_periode = '" . $request["id_periode"] ."'",
            
            return $getDataMahasiswa->getData();
        }

        $getFakultas = new NeoFeeder([
            'act' => 'GetFakultas',
            'order' => "id_jenjang_pendidikan, nama_fakultas"
        ]);
        
        $getProdi = new NeoFeeder([
            'act' => 'GetProdi',
            'order' => "id_jenjang_pendidikan, nama_program_studi"
        ]);


        $getSemester = new NeoFeeder([
            'act' => 'GetSemester',
            // 'filter' => "a_periode_aktif = '1'",
            'order' => "id_semester desc"
        ]);
        
        
        return view('dashboard.mahasiswa.cari', [
            'nim' => $query,
            'fakultas' => $getFakultas->getData(),
            'prodi' => $getProdi->getData(),
            'semester' => $getSemester->getData()
        ]);
    }
    
}
