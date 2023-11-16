@extends('layouts.base_admin.base_dashboard')
@section('judul', 'Tambah Pelanggan')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Pelanggan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Pelanggan</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    @if(session('status'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        {{ session('status') }}
    </div>
    @endif
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Data Diri</h3>

                        <div class="card-tools">
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse"
                                title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputNama">Nama Pelanggan</label>
                            <input
                                type="text"
                                id="inputNama"
                                name="namaPelanggan"
                                class="form-control @error('namaPelanggan') is-invalid @enderror"
                                placeholder="Masukkan Nama Pelanggan"
                                value="{{ old('namaPelanggan') }}"
                                required="required"
                                autocomplete="namaPelanggan">
                            @error('namaPelanggan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputAlamat">Alamat</label>
                            <input
                                type="text"
                                id="inputAlamat"
                                name="alamat"
                                class="form-control @error('alamat') is-invalid @enderror"
                                placeholder="Masukkan Alamat"
                                value="{{ old('alamat') }}"
                                required="required"
                                autocomplete="alamat">
                            @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputNoTelepon">Nomor Telepon</label>
                            <input
                                type="text"
                                id="inputNoTelepon"
                                name="noTelepon"
                                class="form-control @error('noTelepon') is-invalid @enderror"
                                placeholder="Masukkan Nomor Telepon"
                                value="{{ old('noTelepon') }}"
                                required="required"
                                autocomplete="noTelepon">
                            @error('noTelepon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input
                                type="email"
                                id="inputEmail"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan Email"
                                value="{{ old('email') }}"
                                required="required"
                                autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputNoIdentifikasi">Nomor Identifikasi</label>
                            <input
                                type="text"
                                id="inputNoIdentifikasi"
                                name="noIdentifikasi"
                                class="form-control @error('noIdentifikasi') is-invalid @enderror"
                                placeholder="Masukkan Nomor Identifikasi"
                                value="{{ old('noIdentifikasi') }}"
                                required="required"
                                autocomplete="noIdentifikasi">
                            @error('noIdentifikasi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Tambah Pelanggan" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<!-- /.content -->
@endsection
@section('script_footer')
<script>
    // Tambahkan kode JavaScript sesuai kebutuhan
</script>
@endsection
