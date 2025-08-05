<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $beritas)
    {
        $beritas = Berita::paginate(5);
        if ($beritas->isEmpty()) {
            return response()->json([
                'message' => 'No berita data found',
                'data' => []
            ], 404);
        }
        $beritaData = $beritas->map(function ($berita) {
            return [
                'judul_berita' => $berita->judul_berita,
                'isi_berita' => $berita->isi_berita,
                'gambar_berita' => $berita->gambar_berita,
                'user_id' => $berita->user_id,
            ];
        });

        return response()->json([
            'message' => 'Berita data retrieved successfully',
            'data' => $beritaData
        ]);
    }
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)->first();

        if (!$berita) {
            return response()->json([
                'message' => 'Berita not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Berita data retrieved successfully',
            'data' => [
                'judul_berita' => $berita->judul_berita,
                'isi_berita' => $berita->isi_berita,
                'gambar_berita' => $berita->gambar_berita,
                'user_id' => $berita->user_id,
            ]
        ]);
    }
}
