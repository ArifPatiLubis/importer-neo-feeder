<?php

namespace App\Http\Controllers\Administrator\Pddikti;

ini_set('max_execution_time', 300);
use App\Helpers\NeoFeeder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class KrsMahasiswaController extends Controller
{
    
    public function index(Request $request)
    {

        $getSemester = new NeoFeeder([
            'act' => 'GetSemester',
            'order' => "id_semester desc"
        ]);

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);
        
        return view('Administrator.Pddikti.krs', [
            'semester' => $getSemester->getData(),
            'semesterAKM' => $getSemester->getData()
        ]);
    }
    

    
    public function cari(Request $request)
    {
        
        if($request->ajax()) {
            
            $getDataMahasiswa = new NeoFeeder([
                "act" => 'GetListMahasiswa',
	            "filter" => "nim = '" . $request["nim"] ."'",
	            "order" => '',
	            "limit" => '',
	            "offset" => '0'
            ]);
            
            return $getDataMahasiswa->getData();
        }
    }

    public function carikrs(Request $request)
    {
        
        if($request->ajax()) {
            
            $getDataMahasiswa = new NeoFeeder([
                "act" => 'GetKRSMahasiswa',
	            "filter" => "nim = '" . $request["nim"] ."' AND id_periode = '" . $request["id_periode"] ."'",
	            "order" => '',
	            "limit" => '',
	            "offset" => '0'
            ]);
            
            return $getDataMahasiswa->getData();
        }
    }

    public function cariakm(Request $request)
    {
        
        if($request->ajax()) {
            
            $getDataMahasiswa = new NeoFeeder([
                "act" => 'GetAktivitasKuliahMahasiswa',
	            "filter" => "nim = '" . $request["nim"] ."'",
	            "order" => '',
	            "limit" => '',
	            "offset" => '0'
            ]);
            
            return $getDataMahasiswa->getData();
        }
    }
    
}
