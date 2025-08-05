<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $prestasis = Prestasi::paginate(5);
        if ($prestasis->isEmpty()) {
            return response()->json([
                'message' => 'No achievements found',
                'data' => []
            ], 404);
        }
        $prestasiData = $prestasis->map(function ($prestasi) {
            return [
                'jenis_prestasi' => $prestasi->jenis_prestasi,
                'nama_prestasi' => $prestasi->nama_prestasi,
                'keterangan_prestasi' => $prestasi->keterangan_prestasi,
                'penyelenggara' => $prestasi->penyelenggara,
                'peringkat' => $prestasi->peringkat,
                'bidang' => $prestasi->bidang,
                'gambar_prestasi' => $prestasi->gambar_prestasi,
            ];
        });

        return response()->json([
            'message' => 'prestasi data retrieved successfully',
            'data' => $prestasiData
        ]);
    }

    public function show($id)
    {
        $prestasi = Prestasi::find($id);

        if (!$prestasi) {
            return response()->json([
                'message' => 'Achievement not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Achievement data retrieved successfully',
            'data' => [
                'jenis_prestasi' => $prestasi->jenis_prestasi,
                'nama_prestasi' => $prestasi->nama_prestasi,
                'keterangan_prestasi' => $prestasi->keterangan_prestasi,
                'penyelenggara' => $prestasi->penyelenggara,
                'peringkat' => $prestasi->peringkat,
                'bidang' => $prestasi->bidang,
                'gambar_prestasi' => $prestasi->gambar_prestasi,
            ]
        ]);
    }
}
