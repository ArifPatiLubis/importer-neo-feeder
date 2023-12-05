<?php

namespace App\Http\Controllers\Administrator\Import;

use App\Models\ImportLog;
use App\Helpers\NeoFeeder;
use App\Http\Controllers\Administrator\Import\Antrian\HistoriPendidikanJob;
use App\Http\Controllers\Administrator\Import\Helpers\RiwayatPendidikanMahasiswa;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

ini_set('max_execution_time', 300);

class SingkronHistoriController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax()) {
            
            $getLogImport = ImportLog::select('*')->where('act', 'InsertRiwayatPendidikanMahasiswa')
            ->orWhere('act', 'UpdateRiwayatPendidikanMahasiswa')->orWhere('act', 'DeleteRiwayatPendidikanMahasiswa')
            ->orderBy('created_at', 'desc')->get(); ;

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

        return view('Administrator.Import.Histori.index', [
            'prodi' => $getProdi->getData(),
            'semester' => $getSemester->getData()
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'program_studi' => 'required',
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // dd($request->prodi);

        $fileUpload = $request->file('file');
        $aktivitas = new RiwayatPendidikanMahasiswa;
        $aktivitas->import($fileUpload);

        if($aktivitas->failures()->isNotEmpty()) {
            return back()->with('import-error', $aktivitas->failures()[0]);
        } else {
            
            $dataAktivitas = $aktivitas->toArray($fileUpload);
            $idProdi = $request->program_studi;
            HistoriPendidikanJob::dispatch($dataAktivitas[0], $idProdi)->onQueue('imports');

            return redirect()->back()->with('success', 'Sukses import file. Riwayat import dapat dilihat pada menu Log Import');
        }
    }
}
