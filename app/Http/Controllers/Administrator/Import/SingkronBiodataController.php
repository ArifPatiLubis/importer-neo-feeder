<?php

namespace App\Http\Controllers\Administrator\Import;

use App\Models\ImportLog;
use App\Helpers\NeoFeeder;
use App\Http\Controllers\Administrator\Import\Antrian\BiodataJob;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Administrator\Import\Helpers\MahasiswaBaruImport;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

ini_set('max_execution_time', 300);

class SingkronBiodataController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax()) {
            
            $getLogImport = ImportLog::select('*')->where('act', 'InsertBiodataMahasiswa')
            ->orWhere('act', 'InsertRiwayatPendidikanMahasiswa')->orWhere('act', 'UpdateBiodataMahasiswa')
            ->orderBy('created_at', 'desc')->get(); 

            return $getLogImport;
        }

        $getProdi = new NeoFeeder([
            'act' => 'GetProdi',
            'order' => "id_jenjang_pendidikan, nama_program_studi"
        ]);

        $getSemester = new NeoFeeder([
            'act' => 'GetSemester',
            'filter' => "",
            'order' => "id_semester desc"
        ]);

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Import.Biodata.index', [
            'prodi' => $getProdi->getData(),
            'semester' => $getSemester->getData()
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([

            'file' => 'required|mimes:xls,xlsx'
        ]);

        $fileUpload = $request->file('file');
        $mahasiswa = new MahasiswaBaruImport;
        $mahasiswa->import($fileUpload);

        if($mahasiswa->failures()->isNotEmpty()) {
            return back()->with('import-error', $mahasiswa->failures()[0]);
        } else {

            $dataMahasiswa = $mahasiswa->toArray($fileUpload);

            BiodataJob::dispatch($dataMahasiswa[0])->onQueue('imports');

            return redirect()->back()->with('success', 'Sukses import file. Riwayat import dapat dilihat pada menu Log Import');
        }
    }
}
