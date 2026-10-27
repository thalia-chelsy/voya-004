<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ClientTransaksiController extends Controller
{
    public function halamanPetugas() {
        // Client nembak API server pakai token
        $response = Http::withToken(session('api_token'))
                    ->get('http://127.0.0.1:8000/api/transaksi/petugas');
                    
    $transaksi = $response->json()['data'];
    
    return view('transaksi.petugas_index', compact('transaksi'));
    }

}