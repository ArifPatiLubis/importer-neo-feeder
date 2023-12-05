<?php

namespace App\Http\Controllers\Administrator\Import;

use App\Models\ImportLog;
use App\Http\Controllers\Administrator\Import\Antrian\AktivitasPerkuliahanJob;
use App\Http\Controllers\Administrator\Import\Helpers\PerkuliahanMahasiswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

ini_set('max_execution_time', 300);

class SingkronPerkuliahanController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax()) {
            
            $getLogImport = ImportLog::select('*')->where('act', 'InsertPerkuliahanMahasiswa')
            ->orWhere('act', 'UpdatePerkuliahanMahasiswa')->orWhere('act', 'DeletePerkuliahanMahasiswa')
            ->orderBy('created_at', 'desc')->get(); 

            return $getLogImport;
        }


        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);

        return view('Administrator.Import.AktivitasPerkuliahan.index', []);
    }

    public function store(Request $request)
    {
        $request->validate([

            'file' => 'required|mimes:xls,xlsx'
        ]);

        $fileUpload = $request->file('file');
        $mahasiswa = new PerkuliahanMahasiswa;
        $mahasiswa->import($fileUpload);

        if($mahasiswa->failures()->isNotEmpty()) {
            return back()->with('import-error', $mahasiswa->failures()[0]);
        } else {

            $dataMahasiswa = $mahasiswa->toArray($fileUpload);

            AktivitasPerkuliahanJob::dispatch($dataMahasiswa[0])->onQueue('imports');

            return redirect()->back()->with('success', 'Sukses import file. Riwayat import dapat dilihat pada menu Log Import');
        }
    }
}
