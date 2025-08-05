<?php

namespace App\Http\Controllers\Api;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimoniController extends Controller
{
    public function index(Request $request)
    {
        $testimoni = Testimoni::all();
        if ($testimoni->isEmpty()) {
            return response()->json([
                'message' => 'Data testimoni tidak ditemukan.',
            ], 404);
        }
        return response()->json([
            'message' => 'Data testimoni berhasil ditemukan.',
            'data' => $testimoni,
        ], 200);
    }
    
}
