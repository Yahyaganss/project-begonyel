<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class ApiBannerController extends Controller
{
    public function getBanners()
    {
        $data = Banner::where('status_banner', 'publish')->get();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil di load',
                'data' => $data,
            ],
            200
        );
    }
}
