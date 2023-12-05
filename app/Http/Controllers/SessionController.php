<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class SessionController extends Controller
{
   function index()
   {
        return view('welcome');
   }

   function login(Request $request)
   {
        $request->validate(
            [
                'nama_pengguna'=>'required',
                'password'=>'required'
            ], 
            [
                'nama_pengguna.required'=>'Nama Pengguna harus diisi',
                'password.required'=>'Password harus diisi'
            ]
        );

        $infoSession = [
            'nama_pengguna' => $request->nama_pengguna,
            'password' => $request->password,
        ];

        if (Auth::attempt($infoSession)) {
            $user = Auth::user();

        
            if ($user->role == '1') {
                $userId = $user->id; // Mengambil ID pengguna yang sedang login

                // Update waktu terakhir aktivitas pengguna pada login
                User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);
                User::updateOrCreate(['id' => $userId], ['status_id' => '1']);
                return redirect('/Administrator/Beranda/Profil-Kampus');
                
            } elseif ($user->role == '2') {
                $userId = $user->id; // Mengambil ID pengguna yang sedang login

                // Update waktu terakhir aktivitas pengguna pada login
                User::updateOrCreate(['id' => $userId], ['last_activity' => now()]);
                User::updateOrCreate(['id' => $userId], ['status_id' => '1']);
                return redirect('/PIC');
            }
        } else {
            return redirect('')
                ->withErrors('Nama Pengguna dan Password tidak sesuai')
                ->withInput();
        }
   }

   function logout()
   {
        $user = Auth::user();
        $userId = $user->id;
        User::updateOrCreate(['id' => $userId], ['status_id' => '0']);
            
        Auth::logout();
        return redirect('');
   }
}
