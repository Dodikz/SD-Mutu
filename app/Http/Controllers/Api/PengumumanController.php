<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $pengumumans = Pengumuman::paginate(5);
        if ($pengumumans->isEmpty()) {
            return response()->json([
                'message' => 'No pengumuman data found',
                'data' => []
            ], 404);
        }
        $pengumumanData = $pengumumans->map(function ($pengumuman) {
            return [
                'nama_pengumumen' => $pengumuman->nama_pengumumen,
                'file_pengumumen' => $pengumuman->file_pengumumen,
            ];
        });

        return response()->json([
            'message' => 'Pengumuman data retrieved successfully',
            'data' => $pengumumanData
        ], 200);
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::find($id);
        if (!$pengumuman) {
            return response()->json([
                'message' => 'Pengumuman not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Pengumuman data retrieved successfully',
            'data' => [
                'nama_pengumumen' => $pengumuman->nama_pengumumen,
                'file_pengumumen' => $pengumuman->file_pengumumen,
            ]
        ], 200);
    }
}
