<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Detailpemesanan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiKeranjangController extends Controller
{
    //list keranjang
    public function getKeranjangs()
    {
        $data = DB::table('detailpemesanans as dp')
            ->join('products as p', 'p.id', 'dp.product_id')
            ->select(
                DB::raw(
                    'dp.id, dp.jumlah_beli, dp.harga, dp.keterangan, p.nama_produk, p.gambar, p.harga as harga_satuan '
                )
            )
            ->where('dp.status_detail', 'cart')
            ->get();

        $getTotal = DB::table('detailpemesanans')
            ->select(DB::raw('SUM(harga) as totalharga, SUM(jumlah_beli) as jlh_beli '))
            ->where('status_detail', 'cart')
            ->first();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil di load',
                'data' => $data,
                'jumlah_beli' => $getTotal->jlh_beli,
                'total' => $getTotal->totalharga
            ],
            200
        );
    }

    // post/insert keranjang
    public function postKeranjang(Request $request){
        // ambil data produk berdasarkan id yg dipilih
        $getProduct = Product::find($request->product_id);

        // jika product_id di tabel tidak ada
        if(!$getProduct) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Product tidak ada',
                    'data' => []
                ],
                500
            );
        }
       
        // ambil field harga pd produk yg dipilih berdasarkan id
        $getHarga = $getProduct->harga;

        // cek apakah produk yg dipilih sudah ada di keranjang
        $getKeranjang = Detailpemesanan::where('product_id', $request->product_id )->where('status_detail','cart')->first();

        // jika ada, maka update nilainya
        if($getKeranjang) {
            // update nilai keranjang yg product_idnya sama dengan product_id yg diinput ($request->id)
            $post = Detailpemesanan::where('product_id', $request->product_id )->where('status_detail','cart')->update([
                'jumlah_beli' => $getKeranjang->jumlah_beli + $request->jumlah_beli,
                'harga' => ($getKeranjang->jumlah_beli + $request->jumlah_beli) * $getHarga,
                'status_detail' => 'cart',
                'keterangan' => $request->keterangan
            ]);
        } else {
            // jika tidak ada, maka insert baru ke tabel detailpemesanans
            $post = Detailpemesanan::create([
                'product_id' => $request->product_id,
                'jumlah_beli' => $request->jumlah_beli,
                'harga' => $request->jumlah_beli * $getHarga, // jumlah yg diinput dikalikan dengan harga produk yg dipilih
                'keterangan' => $request->keterangan,
                'status_detail' => 'cart'
            ]);
        }

        // jika post berhasil dilakukan
        if($post){
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Post Data Berhasil',
                    'data' => $post
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Post Data Gagal',
                    'data' => $post
                ],
                500
            );
        }
    }

    // hapus keranjang berdasarkan id yg dipilih
    public function deleteKeranjang(Request $request){

        // fungsi hapus keranjang menggunakan model
        $id = $request->id; // inputan yg diinput dari postman/vuejs/front-end
        $delete = Detailpemesanan::destroy($id);
        if($delete){
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Delete Data Berhasil',
                    'data' => []
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Delete Data Gagal',
                    'data' => []
                ],
                500
            );
        }

    }
}
