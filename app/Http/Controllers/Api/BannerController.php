<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        
        $banners = Banner::paginate(5);
        if ($banners->isEmpty()) {
            return response()->json([
                'message' => 'No banner data found',
                'data' => []
            ], 404);
        }
        $banner = $banners->first();
        $bannerData = [
            'judul_banner' => $banner->judul_banner,
            'gambar_banner' => $banner->gambar_banner,
            'deskripsi_banner' => $banner->deskripsi_banner,
            'link_banner' => $banner->link_banner
        ];
        return response()->json([
            'message' => 'Banner data retrieved successfully',
            'data' => $bannerData
        ]);
    }
}
