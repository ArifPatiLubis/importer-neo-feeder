<?php

namespace App\Http\Controllers\Administrator\Pddikti;

ini_set('max_execution_time', 300);
use App\Helpers\NeoFeeder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    
    public function index(Request $request)
    {
        $getProdi = new NeoFeeder([
            'act' => 'GetProdi',
            'order' => "id_jenjang_pendidikan, nama_program_studi"
        ]);

        $getSemester = new NeoFeeder([
            'act' => 'GetSemester',
            // 'filter' => "a_periode_aktif = '1'",
            'order' => "id_semester desc"
        ]);

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);
        
        return view('Administrator.Pddikti.kelas', [
            'semester' => $getSemester->getData(),
            'prodi' => $getProdi->getData(),
        ]);
    }
    

    
    public function cari(Request $request)
    {
        
        if($request->ajax()) {
            
            $getDataMahasiswa = new NeoFeeder([
                "act" => 'GetListKelasKuliah',
	            "filter" => "id_prodi = '" . $request["id_prodi"] ."' AND id_semester = '" . $request["id_semester"] ."'",
	            "order" => '',
	            "limit" => '',
	            "offset" => '0'
            ]);
            
            return $getDataMahasiswa->getData();
        }
    }
    
}
