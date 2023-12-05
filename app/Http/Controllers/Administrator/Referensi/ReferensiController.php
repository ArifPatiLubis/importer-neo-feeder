<?php

namespace App\Http\Controllers\Administrator\Referensi;

ini_set('max_execution_time', 300);
use App\Helpers\NeoFeeder;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferensiController extends Controller
{
    public function agama(Request $request)
    {
        if($request->ajax()) {
            $getAgama = new NeoFeeder([
                'act' => 'GetAgama'
            ]);

            return $getAgama->getData();
        }

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Referensi.agama');
    }

    public function jalurmasuk(Request $request)
    {
        if($request->ajax()) {
            $getJenjangPendidikan = new NeoFeeder([
                'act' => 'GetJalurMasuk'
            ]);

            return $getJenjangPendidikan->getData();
        }

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Referensi.jalur-masuk');
    }

    public function jenisevaluasi(Request $request)
    {
        if($request->ajax()) {
            $getJenjangPendidikan = new NeoFeeder([
                'act' => 'GetJenisEvaluasi'
            ]);

            return $getJenjangPendidikan->getData();
        }

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Referensi.jenis-evaluasi');
    }

    public function jenjangPendidikan(Request $request)
    {
        if($request->ajax()) {
            $getJenjangPendidikan = new NeoFeeder([
                'act' => 'GetJenjangPendidikan'
            ]);

            return $getJenjangPendidikan->getData();
        }

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Referensi.jenjang-pendidikan');
    }

    public function pembiayaan(Request $request)
    {
        if($request->ajax()) {
            $getPembiayaan = new NeoFeeder([
                'act' => 'GetPembiayaan'
            ]);

            return $getPembiayaan->getData();
        }
        
        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Referensi.pembiayaan');
    }

    public function penugasandosen(Request $request)
    {
        if($request->ajax()) {
            $getProdi = new NeoFeeder([
                'act' => 'GetListPenugasanDosen',
                'filter' => "id_tahun_ajaran='2023'",
            ]);
            
            return $getProdi->getData();
        }

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Penugasan-Dosen.index');
    }

    public function prodi(Request $request)
    {
        if($request->ajax()) {
            $getProdi = new NeoFeeder([
                'act' => 'GetProdi',
                'order' => 'nama_jenjang_pendidikan, nama_program_studi'
            ]);
            
            return $getProdi->getData();
        }

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Program-Studi.index');
    }

    public function wilayah()
    {
        $getWilayahNegara = new NeoFeeder([
            'act' => 'GetWilayah',
            'filter' => "id_negara != 'ID'",
            'order' => 'nama_wilayah',
        ]);

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Referensi.wilayah',[
            'negara' => $getWilayahNegara->getData()
        ]);
    }

    public function wilayahProvinsi()
    {
        $getWilayahProvinsi = new NeoFeeder([
            'act' => 'GetWilayah',
            'filter' => "id_negara = 'ID'",
            'filter' => "nama_wilayah like 'Prov.%'",
            'order' => "nama_wilayah"
        ]);

        return $getWilayahProvinsi->getData();
    }

    public function wilayahKota(Request $request)
    {
        $idProvinsi = Str::substr($request->provinsi, 0, 2);

        $getWilayahKota = new NeoFeeder([
            'act' => 'GetWilayah',
            'filter' => "id_wilayah like '$idProvinsi%' and (nama_wilayah like 'Kota%' or nama_wilayah like 'Kab.%')",
            'order' => "nama_wilayah"
        ]);

        return $getWilayahKota->getData();
    }

    public function wilayahKecamatan(Request $request)
    {
        $idKota = Str::substr($request->kota, 0, 4);

        $getWilayahKota = new NeoFeeder([
            'act' => 'GetWilayah',
            'filter' => "id_wilayah like '$idKota%' and nama_wilayah like 'Kec.%'",
            'order' => "nama_wilayah"
        ]);

        return $getWilayahKota->getData();
    }
}

