<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiProductController extends Controller
{
    // menampilkan list products
    public function getProducts()
    {
        $data = listProducts()->get();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil di load',
                'data' => $data,
            ],
            200
        );
    }

    // best Product
    public function bestProducts()
    {
        $data = listProducts()
            ->limit(4)
            ->orderBy('nama_produk', 'ASC')
            ->get();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil di load',
                'data' => $data,
            ],
            200
        );
    }

    // product detail
    public function productDetail($id)
    {
        $data = listProducts()
            ->where('p.id', $id)
            ->first();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil di load',
                'data' => $data,
            ],
            200
        );
    }

    // search product
    public function searchProduct(Request $request)
    {
        // data yang diterima berupa inputan nama produk/nama kategori
        $keyword = $request->keyword;

        $getData = listProducts()
            ->where('p.nama_produk', 'like', '%' . $keyword . '%') // berdasarkan nama produk yg diinput
            ->orWhere('k.nama_kategori', 'like', '%' . $keyword . '%') //berdasarkan nama kategori yg diinput
            ->get();
        // dd($getData);
        // jika data ditemukan
        if ($getData->count() > 0) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data berhasil di load',
                    'data' => $getData,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data tidak ada',
                    'data' => [],
                ],
                200
            );
        }
    }
}
