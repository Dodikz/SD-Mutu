<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ektra;
use Illuminate\Http\Request;

class EkstrakulikulerController extends Controller
{
    public function index(Request $request)
    {
        $ekstrakulikulers = Ektra::paginate(5);
        if ($ekstrakulikulers->isEmpty()) {
            return response()->json([
                'message' => 'No ekstrakulikuler data found',
                'data' => []
            ], 404);
        }
        $ekstrakulikulerData = $ekstrakulikulers->map(function ($ekstra) {
            return [
                'judul_ektra' => $ekstra->judul_ektra,
                'isi_ektra' => $ekstra->isi_ektra,
                'gambar_ektra' => $ekstra->gambar_ektra,
                'pembina' => $ekstra->pembina,
                'hari' => $ekstra->hari,
            ];
        });
        return response()->json([
            'message' => 'Ekstrakulikuler data retrieved successfully',
            'data' => $ekstrakulikulerData
        ], 200);
    }

    public function show($id)
    {
        $ekstra = Ektra::find($id);
        if (!$ekstra) {
            return response()->json([
                'message' => 'Ekstrakulikuler not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Ekstrakulikuler data retrieved successfully',
            'data' => [
                'judul_ektra' => $ekstra->judul_ektra,
                'isi_ektra' => $ekstra->isi_ektra,
                'gambar_ektra' => $ekstra->gambar_ektra,
                'pembina' => $ekstra->pembina,
                'hari' => $ekstra->hari,
            ]
        ], 200);
    }
}
