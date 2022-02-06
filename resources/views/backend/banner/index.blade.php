@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Banner</h1>
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
                    @if ($message = Session::get('pesan'))
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
                                <a href="{{ route('banner-add') }}" class="btn btn-primary">Tambah</a>
                            </h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Banner</th>
                                        <th>Status Banner</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($banners as $key => $banner)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @if ($banner->banner == '' || $banner->banner == null)
                                                    <img src="{{ asset('storage/product-images/default.png') }}" width="200px">
                                                @else
                                                    <img src="{{ asset('storage/' . $banner->banner) }}" width="200px">
                                                @endif
                                            </td>
                                            <td>
                                                {{ $banner->status_banner }}
                                            </td>
                                            <td>
                                                <a href="{{ route('banner-edit', $banner->id) }}"
                                                    class="btn btn-sm btn-success">Edit</a>
                                                <a href="{{ route('banner-delete', $banner->id) }}"
                                                    onclick="return confirm('Yakin hapus data ini?')"
                                                    class="btn btn-sm btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Data tidak ada</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
