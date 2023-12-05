<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckUserActivity
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $lastActivity = $user->last_activity; // Pastikan kolom 'last_activity' ada di tabel pengguna

            // Sesuaikan dengan waktu sesi yang telah Anda tentukan
            $sessionLifetime = config('session.lifetime') * 60; // Konversi menit ke detik

            $currentTime = time();

            if ($currentTime - strtotime($lastActivity) > $sessionLifetime) {
                $this->updateUserStatus($user->id, 0);
                $this->lastActivity($user->id, now());
                Auth::logout();

                return Redirect::to('/login')->withErrors('Sesi Anda telah berakhir karena tidak ada aktivitas.')
                    ->withInput($request->except('password')); // Hindari menyimpan password dalam session
            } else {
                // Jika masih ada aktivitas, perbaharui waktu terakhir aktivitas
                $this->lastActivity($user->id, now());
            }
        }

        return $next($request);
    }

    private function updateUserStatus($userId, $statusId)
    {
        User::updateOrCreate(['id' => $userId], ['status_id' => $statusId]);
    }
    
    private function lastActivity($userId, $lastActivity)
    {
        User::updateOrCreate(['id' => $userId], ['last_activity' => $lastActivity]);
    }
}
