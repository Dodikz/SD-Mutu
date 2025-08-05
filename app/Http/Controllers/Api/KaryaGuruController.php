<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KaryaGuru;
use Illuminate\Http\Request;

class KaryaGuruController extends Controller
{
    public function index(Request $request)
    {
        $karyaGurus = KaryaGuru::with('user')->get();
        if ($karyaGurus->isEmpty()) {
            return response()->json([
                'message' => 'No karya guru data found',
                'data' => []
            ], 404);
        }
        $karyaGuruData = $karyaGurus->map(function ($karya) {
            return [
                'nama_karya_guru' => $karya->nama_karya_guru,
                'isi_karya' => $karya->isi_karya,
                'foto_karya_guru' => $karya->foto_karya_guru,
                'penulis' => $karya->user->name ?? 'tidak diketahui',
            ];
        });
        return response()->json([
            'message' => 'Karya guru data retrieved successfully',
            'data' => $karyaGuruData
        ], 200);
    }

    public function show($slug)
    {
        $karya = KaryaGuru::where('slug', $slug)->first();
        if (!$karya) {
            return response()->json([
                'message' => 'Karya guru not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Karya guru data retrieved successfully',
            'data' => [
                'nama_karya_guru' => $karya->nama_karya_guru,
                'isi_karya' => $karya->isi_karya,
                'foto_karya_guru' => $karya->foto_karya_guru,
                'penulis' => $karya->user->name ?? 'tidak diketahui',
            ]
        ], 200);
    }
}
