<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil nama role dari user yang sedang login
        $userRole = Auth::user()->role->nama_role;

        // Cek apakah role pengguna ada di dalam array $roles yang diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses Ditolak. Anda tidak memiliki hak untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
