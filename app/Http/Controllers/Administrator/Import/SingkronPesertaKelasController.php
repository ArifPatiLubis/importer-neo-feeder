<?php

namespace App\Http\Controllers\Administrator\Import;

use App\Models\ImportLog;
use App\Helpers\NeoFeeder;
use App\Http\Controllers\Administrator\Import\Antrian\PesertaKelasJob;
use App\Http\Controllers\Administrator\Import\Helpers\MahasiswaBaruImport;
use App\Http\Controllers\Administrator\Import\Helpers\PesertaKelasImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

ini_set('max_execution_time', 900);

class SingkronPesertaKelasController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            
            $getLogImport = ImportLog::select('*')->where('act', 'InsertPesertaKelasKuliah')
            ->orWhere('act', 'DeletePesertaKelasKuliah')
            ->orderBy('created_at', 'desc')->get(); ;

            return $getLogImport;
        }

        $getProdi = new NeoFeeder([
            'act' => 'GetProdi',
            'order' => "id_jenjang_pendidikan, nama_program_studi"
        ]);

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Import.Peserta-Kelas.index', [
            'prodi' => $getProdi->getData()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $fileUpload = $request->file('file');
        $mataKuliah = new PesertaKelasImport;
        $mataKuliah->import($fileUpload);

        if($mataKuliah->failures()->isNotEmpty()) {
            return back()->with('import-error', $mataKuliah->failures()[0]);
        } else {
            $dataMataKuliah = $mataKuliah->toArray($fileUpload);
            
            PesertaKelasJob::dispatch($dataMataKuliah[0])->onQueue('imports'); 

            return redirect()->back()->with('success', 'Sukses import file. Riwayat import dapat dilihat pada menu Log Import');

        }
    }
}
