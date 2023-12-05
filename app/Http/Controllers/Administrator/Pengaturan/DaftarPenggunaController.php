<?php

namespace App\Http\Controllers\Administrator\Pengaturan;

use App\Helpers\NeoFeeder;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarPenggunaController extends Controller
{
    function index(Request $request){

        if($request->ajax()) {
            
            $users = User::all(); // Ambil semua data pengguna dari tabel User

            return response()->json($users);
        }

        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);
        
        return view('Administrator.Pengaturan.daftar-pengguna', [
        ]);
    }
}
