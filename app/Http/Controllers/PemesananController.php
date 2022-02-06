<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::all();

        return view('backend.pemesanan.index', compact('pemesanan'));
    }

    public function detail($id)
    {
        $getPemesanan = Pemesanan::find($id);

        $detailPemesanan = DB::table('detailpemesanans as dp')
            ->join('products as pr', 'pr.id', 'dp.product_id')
            ->join('pemesanans as pm', 'pm.id', 'dp.pemesanan_id')
            ->select(
                DB::raw(
                    'dp.id, dp.jumlah_beli, dp.harga, pr.nama_produk, pr.gambar, pr.harga as harga_produk, pm.* '
                )
            )
            ->where('dp.pemesanan_id', $id)
            ->get();

        $getTotalHarga = DB::table('detailpemesanans')
            ->select(DB::raw('SUM(harga) as totalharga'))
            ->where('status_detail', 'checkout')
            ->where('pemesanan_id', $id)
            ->first();

        return view('backend.pemesanan.detail', compact('detailPemesanan','getTotalHarga','getPemesanan') );
    }

    public function updateStatus(Request $request)
    {
        Pemesanan::where('id', $request->pemesanan_id)->update([
            'status_pesanan' => $request->status_pesanan
        ]);

        return redirect()->back()->with(
            'success', 'Status berhasil diubah'
        );
    }
}
