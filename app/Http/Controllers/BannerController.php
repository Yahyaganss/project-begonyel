<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        // join
        // 1. DB Query Builder => bakal di pake di API

        // 2. Eloquent (menggunakan model)

        //menampilkan data produk ke view
        $banners = Banner::all();
        $title = '';

        return view('backend.banner.index', compact('banners', 'title'));
    }

    public function create()
    {
        return view('backend.banner.add');
    }

    public function store(Request $request)
    {
        // validasi
        $request->validate([
            'banner' => 'required|image|file|max:2048',
            'status_banner' => 'required',
        ]);

        try {
            //code...
            $pathGambar = $request->file('banner')->store('banner-images');

            // insert data to produks table
            Banner::create([
                'banner' => $pathGambar,
                'status_banner' => $request->status_banner
            ]);

            return redirect('banner')->with([
                'pesan' => 'Data Berhasil disimpan!',
            ]);
        } catch (Exception $err) {
            return redirect()
                ->back()
                ->with(['pesan' => $err->getMessage()]);
        }
    }

    public function edit($id)
    {
        // ambil data produk berdasarkan id yg dipilih
        // SELECT * FROM produks WHERE id = '$id'
        $banner = Banner::find($id);

        // panggil tampilan/halaman edit produk
        // compact => fungsi yg berguna untuk mengirim data yang telah
        // didefinisikan ke view yang dituju

        return view('backend.banner.edit', compact('banner'));
    }

    public function update(Request $request)
    {
        // validasi
        $request->validate([
            'banner' => 'required|image|file|max:2048',
            'status_banner' => 'required',
        ]);

        try {
            // ambil data produk berdasarkan id yg dipilih
            $banner = Banner::find($request->id);

            // cek apakah ada gambar diupload?
            if ($request->file('banner')) {
                // cek foto/gambar lama
                if ($banner->banner) {
                    // delete gambar yg lama
                    Storage::delete($banner->banner);
                    $pathGambar = $request
                        ->file('banner')
                        ->store('banner-images');
                }
            } else {
                // jika tidak mengupload, maka data yg lama yg akan tetap tersimpan
                // di tabel products
                $pathGambar = $banner->banner;
            }

            // update data di tabel products (database)
            Banner::where('id', $request->id)->update([
                'banner' => $pathGambar,
                'status_banner' => $request->status_banner
            ]);

            return redirect('banner')->with([
                'pesan' => 'Data Berhasil disimpan!',
            ]);
        } catch (Exception $error) {
            return redirect()
                ->back()
                ->with(['pesan' => $error->getMessage()]);
        }
    }

    public function delete($id)
    {
        // ambil data produk berdasarkan id yg dipilih/ yg ingin dihapus
        $banner = Banner::find($id);

        // cek foto/gambar lama
        if ($banner->banner) {
            // delete file gambar yg lama yg ada di folder storage/app/public/product-images
            Storage::delete($banner->banner);
        }

        // fungsi hapus data dari tabel
        Banner::destroy($id);

        // kembalikan ke halaman produk
        return redirect('banner')->with([
            'pesan' => 'Data Berhasil disimpan!',
        ]);
    }
}
