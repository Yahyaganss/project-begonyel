@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile</h1> 
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Profile</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('profile-update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                                        value="{{ $user->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter email" value="{{ $user->email }}">
                                </div>

                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>
                                    <select name="jk" id="jk" class="form-control">
                                        <option value="">--Pilih Jenis Kelamin--</option>
                                        <option value="L" @if ($user->jk == 'L') {{ 'selected' }} @else {{ '' }} @endif>Laki-laki</option>

                                        <option value="P" @if ($user->jk == 'P') {{ 'selected' }} @else {{ '' }} @endif>Perempuan</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">No. HP</label>
                                    <input type="number" class="form-control" id="no_telp" name="no_telp"
                                        placeholder="Enter No. HP" value="{{ $user->no_telp }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password <span class="text-info"> <small> * Isi jika ingin mengubah password </small> </span> </label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Ubah Password">
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
