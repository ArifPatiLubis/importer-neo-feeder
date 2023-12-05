<?php

namespace App\Http\Controllers\Administrator;

ini_set('max_execution_time', 300);
use App\Helpers\NeoFeeder;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministratorController extends Controller
{
    function index(){

        $getProfilPT = new NeoFeeder([
            'act' => 'GetProfilPT'
        ]); 

        $getCountProdi = new NeoFeeder([
            'act' => 'GetCountProdi'
        ]);

        $getCountDosen = new NeoFeeder([
            'act' => 'GetCountDosen'
        ]);

        $getCountMahasiswa = new NeoFeeder([
            'act' => 'GetCountMahasiswa'
        ]);


        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);
        
        return view('Administrator.Beranda.index', [
            'profil' => $getProfilPT->getData()['data'],
            'count_prodi' => $getCountProdi->getData()['data'],
            'count_dosen' => $getCountDosen->getData()['data'],
            'count_mahasiswa' => $getCountMahasiswa->getData()['data']
        ]);
    }
}
