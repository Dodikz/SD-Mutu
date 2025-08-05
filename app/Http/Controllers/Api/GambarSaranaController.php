<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GambarSarana;
use Illuminate\Http\Request;

class GambarSaranaController extends Controller
{
    public function index()
    {
        $gambarsaranas = GambarSarana::with('sarana')->get()->map(function ($gambar) {
            return [
                'sarana_id' => $gambar->sarana_id,
                'gambar' => asset('storage/' . $gambar->gambar),
                'judul' => $gambar->judul,
            ];
        });

        if (count($gambarsaranas) > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $gambarsaranas,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data, data tidak ditemukan!'
            ], 404);
        }
    }

    public function show($id)
    {
        $gambar = GambarSarana::with('sarana')->find($id);

        if ($gambar) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'sarana_id' => $gambar->sarana_id,
                    'gambar' => asset('storage/' . $gambar->gambar),
                    'judul' => $gambar->judul,
                ],
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gambar sarana tidak ditemukan!'
            ], 404);
        }
    }
}
