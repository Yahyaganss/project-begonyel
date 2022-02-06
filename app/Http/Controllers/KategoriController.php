<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();  //SELECT * FROM kategoris

        return view('backend.kategori.index', [
            'kategoris' => $kategoris,
        ]);
    }

    public function create() {
        return view('backend.kategori.add');
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required'
        ]);

        Kategori::create([
            'nama_kategori' => $request->name
        ]);

        return redirect('kategori');
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id); // SELECT * FROM kategori WHERE id = $id
        // dd($kategori);

        // tampilkan form edit dan kirim datanya
        return view('backend.kategori.edit', compact('kategori'));
    }

    // update data selected
    public function update(Request $request)
    {
        // data yg akan diterima function store

        $id = $request->id;
        $name = $request->name;

        // buat object untuk simpan data ke table
        $kategori = Kategori::find($id);

        //kirim nilai2 yg didapat dari form ke table
        $kategori->nama_kategori = $name;
        $kategori->update();

        // redirect ke halaman kategoris
        return redirect('kategori');
    }

    public function delete($id)
    {
        // query/perintah hapus data berdasarkan id
        Kategori::find($id)->delete();

        // kembalikan ke halaman kategoris
        return redirect('kategori');
    }

}
