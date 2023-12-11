@extends('layouts.base_admin.base_dashboard') @section('judul', 'Tambah Fasilitas Hotel')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Kamar Hotel</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Kamar Hotel</li>
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
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        {{ session('status') }}
      </div>
    @endif
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="column">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Data Fasilitas Hotel</h3>

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
                                <label for="inputtipeKamar">TipeKamar</label>
                                <input
                                    type="text"
                                    id="inputTipeKamar"
                                    name="tipeKamar"
                                    class="form-control @error('tipeKamar') is-invalid @enderror"
                                    placeholder="Masukkan Tipe Kamar"
                                    value="{{ old('tipeKamar') }}"
                                    required="required"
                                    autocomplete="tipeKamar">
                                @error('tipeKamar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputhargaPerMalam">Harga Per Malam</label>
                                <input
                                    type="text"
                                    id="inputhargaPerMalam"
                                    name="hargaPerMalam"
                                    class="form-control @error('hargaPerMalam') is-invalid @enderror"
                                    placeholder="Masukkan Harga Per Malam"
                                    value="{{ old('hargaPerMalam') }}"
                                    required="required"
                                    autocomplete="hargaPerMalam">
                                @error('hargaPerMalam')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputkapasitas">kapasitas</label>
                                <input
                                    type="text"
                                    id="inputkapasitas"
                                    name="kapasitas"
                                    class="form-control @error('kapasitas') is-invalid @enderror"
                                    placeholder="Masukkan Harga Per Malam"
                                    value="{{ old('kapasitas') }}"
                                    required="required"
                                    autocomplete="kapasitas">
                                @error('kapasitas')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputstatus">Status</label>
                                <select
                                    id="inputStatus"
                                    name="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                    required="required"
                                    autocomplete="status"
                                >
                                    <option value="Pilih Status" disabled selected>Pilih Status</option>
                                    <option value="Kosong">Kosong</option>
                                    <option value="Terisi">Terisi</option>
                                    <option value="Perbaikan">Perbaikan</option>
                                    <!-- Tambahkan opsi status lainnya sesuai kebutuhan -->
                                </select>
                                @error('status')
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
                
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Tambah Kamar Hotel" class="btn btn-success float-right">
                </div>
            </div>
        </div>
    </form>
</section>
<!-- /.content -->

@endsection
