@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Detail Pemesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                {{-- content tabel --}}
                <div class="col-12">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">

                            </h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No. Transaksi</th>
                                        <th>:</th>
                                        <th>{{ $getPemesanan->nomor_transaksi }}</th>
                                    </tr>
                                    <tr>
                                        <th>Nama Pemesan</th>
                                        <th>:</th>
                                        <th>{{ $getPemesanan->nama_pemesan }}</th>
                                    </tr>
                                    <tr>
                                        <th>No. Meja</th>
                                        <th>:</th>
                                        <th>{{ $getPemesanan->nomor_meja }}</th>
                                    </tr>
                                </thead>
                            </table>
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah Beli</th>
                                        <th class="text-right">Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($detailPemesanan as $key => $detailPemesanan)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $detailPemesanan->nama_produk }} </td>
                                            <td>
                                                {{ number_format($detailPemesanan->harga_produk, 0) }}
                                            </td>
                                            <td>{{ $detailPemesanan->jumlah_beli }}</td>
                                            <td class="text-right">
                                                {{ number_format($detailPemesanan->harga, 0) }}
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Data tidak ada</td>
                                        </tr>
                                    @endforelse

                                    <tr>
                                        <td colspan="4">Grand Total</td>
                                        <td class="text-right">{{ number_format($getTotalHarga->totalharga, 0) }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="4"> Status </td>
                                        <td>
                                            <form action="{{ route('pemesanan-update-status') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="pemesanan_id" value="{{$getPemesanan->id}}">
                                                <select name="status_pesanan" id="" class="form-control">
                                                    <option value="new" {{ $getPemesanan->status_pesanan == 'new' ? 'selected' : '' }}>
                                                        New</option>

                                                    <option value="approved"
                                                        {{ $getPemesanan->status_pesanan == 'approved' ? 'selected' : '' }}>Approved
                                                    </option>
                                                </select>
                                                <br>
                                                <button type="submit" class="btn btn-success btn-block">Update Status</button>
                                            </form>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
