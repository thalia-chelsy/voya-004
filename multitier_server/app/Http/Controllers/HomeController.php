<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    /**
     * Show the application dashboard data (API).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Ambil data user yang sedang login
        $user = $request->user();

        // KEMBALIKAN JSON (Bukan return view)
        return response()->json([
            'status' => 'success',
            'pesan' => 'Selamat datang di Dashboard Voya-004',
            'data' => [
                'user' => $user,
                'total_kendaraan' => Kendaraan::count(),
            ]
        ], 200);
    }
}