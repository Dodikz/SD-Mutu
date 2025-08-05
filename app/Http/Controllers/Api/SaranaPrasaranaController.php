<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sarana;
use Illuminate\Http\Request;

class SaranaPrasaranaController extends Controller
{
    public function index(Request $request)
    {
        $saranaPrasarana = Sarana::all();

        if ($saranaPrasarana->isEmpty()) {
            return response()->json([
                'message' => 'Data sarana prasarana tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Data sarana prasarana berhasil ditemukan.',
            'data' => $saranaPrasarana,
        ], 200);
    }

    public function show($id)
    {
        $saranaPrasarana = Sarana::find($id);

        if (!$saranaPrasarana) {
            return response()->json([
                'message' => 'Data sarana prasarana tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Data sarana prasarana berhasil ditemukan.',
            'data' => $saranaPrasarana,
        ], 200);
    }
}
