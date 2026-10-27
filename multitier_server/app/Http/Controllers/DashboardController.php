<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data user yang sedang login (lewat token API nantinya)
        $user = Auth::user(); 
        
        // KEMBALIKAN JSON (Bukan return view)
        return response()->json([
            'status' => 'success',
            'pesan' => 'Data dashboard berhasil diambil',
            'data' => [
                'user' => $user,
                
            ]
        ], 200);
    }
}