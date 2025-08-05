<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilSekolahController extends Controller
{
    public function index(Request $request)
    {
        $profil = Profil::first();
    
        if (!$profil) {
            return response()->json([
                'message' => 'Profil sekolah tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Profil sekolah berhasil ditemukan.',
            'data' => $profil,
        ], 200);

    }
}
