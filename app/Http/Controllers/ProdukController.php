<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        // join
        // 1. DB Query Builder => bakal di pake di API

        // 2. Eloquent (menggunakan model)

        //menampilkan data produk ke view
        $produks = Product::orderBy('nama_produk', 'ASC')->get();
        $title = '';

        return view('backend.produk.index', compact('produks', 'title'));
    }

    // menampilkan data kategori
    public function listKategori()
    {
        $data = Kategori::orderBy('nama_kategori', 'ASC')->get();
        return $data;
    }

    public function create()
    {
        // ambil data kategori untuk diinputkan ke tabel produk
        $kategoris = $this->listKategori();

        return view('backend.produk.add', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // validasi
        $request->validate([
            'nama_produk' => 'required|min:3',
            'harga' => 'required',
            'gambar' => 'required|image|file|max:2048',
            'kategori_id' => 'required',
        ]);

        try {
            //code...
            $pathGambar = $request->file('gambar')->store('product-images');

            // insert data to produks table
            Product::create([
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'kategori_id' => $request->kategori_id,
                'gambar' => $pathGambar,
            ]);

            return redirect('produk')->with([
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
        // ambil data kategori untuk diinputkan ke tabel produk
        $kategoris = $this->listKategori();

        // ambil data produk berdasarkan id yg dipilih
        // SELECT * FROM produks WHERE id = '$id'
        $produk = Product::find($id);

        // panggil tampilan/halaman edit produk
        // compact => fungsi yg berguna untuk mengirim data yang telah
        // didefinisikan ke view yang dituju

        return view('backend.produk.edit', compact('kategoris', 'produk'));
    }

    public function update(Request $request)
    {
        // validasi
        $request->validate([
            'nama_produk' => 'required|min:3',
            'harga' => 'required',
            'gambar' => 'image|file|max:2048',
            'kategori_id' => 'required',
        ]);

        try {
            // ambil data produk berdasarkan id yg dipilih
            $produk = Product::find($request->id);

            // cek apakah ada gambar diupload?
            if ($request->file('gambar')) {
                // cek foto/gambar lama
                if ($produk->gambar) {
                    // delete gambar yg lama
                    Storage::delete($produk->gambar);
                    $pathGambar = $request
                        ->file('gambar')
                        ->store('product-images');
                }
            } else {
                // jika tidak mengupload, maka data yg lama yg akan tetap tersimpan
                // di tabel products
                $pathGambar = $produk->gambar;
            }

            // update data di tabel products (database)
            Product::where('id', $request->id)->update([
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'gambar' => $pathGambar,
                'kategori_id' => $request->kategori_id,
            ]);

            return redirect('produk')->with([
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
        $produk = Product::find($id);

        // cek foto/gambar lama
        if ($produk->gambar) {
            // delete file gambar yg lama yg ada di folder storage/app/public/product-images
            Storage::delete($produk->gambar);
        }

        // fungsi hapus data dari tabel
        Product::destroy($id);

        // kembalikan ke halaman produk
        return redirect('produk')->with([
            'pesan' => 'Data Berhasil disimpan!',
        ]);
    }
}
