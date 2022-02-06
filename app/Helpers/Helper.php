<?php

use Illuminate\Support\Facades\DB;

function set_active($route, $output = 'active')
{
    if (is_array($route)) {
        foreach ($route as $r) {
            if (Route::is($r)) {
                return $output;
            }
        }
    } else {
        if (Route::is($route)) {
            return $output;
        }
    }
}

function listProducts()
{
    $data = DB::table('products as p')
        ->join('kategoris as k', 'k.id', 'p.kategori_id')
        ->select(
            DB::raw('p.id,p.nama_produk, p.harga, k.nama_kategori, p.gambar')
        );
    return $data;
}

?>
