<?php

namespace App\Services;

use App\Models\Kendaraan;

class KendaraanService
{
    public function tambahKendaraan($data, $foto)
    {
        // Proses upload foto dipindah ke sini (Service Layer)
        if ($foto) {
            $fileName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/kendaraan'), $fileName);
            $data['foto_kendaraan'] = 'uploads/kendaraan/' . $fileName;
        }

        return Kendaraan::create($data);
    }
}