<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Detailpemesanan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApiPemesananController extends Controller
{
    //post/insert pemesanan
    public function postPemesanan(Request $request)
    {
        // ambil total harga yg ada di tabel detailpemesanans yg status_detailnya adalah cart
        $getTotalHarga = DB::table('detailpemesanans')
                         ->select(DB::raw('SUM(harga) as totalharga '))
                         ->where('status_detail', 'cart')
                         ->first();

        if(!$getTotalHarga) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Keranjang Kosong!',
                    'data' => []
                ],
                500
            );
        }
        
        // Db transaction => akan mengupdate data apabila proses 1 berhasil dilakukan
        // jika proses pertama/kedua saat di proses ketiga gagal, maka proses 1 dan 2 dibatalkan
        // proses yg akan dilakukan : 1. update data yg ada di tabel detailpemesanas (pemesanan_id)
        // 2. insert data baru ke tabel pemesanans

        // opening db transaction
        DB::beginTransaction();

        try {
            // isi proses
            // 1. proses insert data ke tabel pemesanans
            $postPemesanan = Pemesanan::create([
                'nomor_transaksi' => 'BGY-' . Str::random(5),
                'nama_pemesan' => $request->nama_pemesan,
                'nomor_meja' => $request->nomor_meja,
                'status_pesanan' => 'new',
                'total_harga' => $getTotalHarga->totalharga
            ]);

            // 2. proses update pemesanan_id di tabel detailpemesanans
            // ambil dulu id pada tabel pemesanans yg barusan disimpan ke database
            $pemesanan_id = $postPemesanan->id;

            // proses update tabel detailpemesanans pd field pemesanan_id dan status_detail

            // yg bakal diupdate adlh yg statusnya masih cart
            $updateDetail = Detailpemesanan::where('status_detail','cart')->update([
                'pemesanan_id' => $pemesanan_id,
                'status_detail' => 'checkout'
            ]);

            // success transaction
            DB::commit();

            // response success
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Post Data Berhasil',
                    'data' => $postPemesanan
                ],
                200
            );
        } catch (\Exception $error) {

            // saat gagal, maka cancel smua transaction data
            DB::rollBack();

            // response gagal
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Post Data Gagal ' . $error->getMessage(),
                    'data' => []
                ],
                500
            );
        }

    }
}
