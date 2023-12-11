@extends('layouts.base_user.base_dashboard')

@section('judul', 'Reservasi')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Reservasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('user.home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Reservasi</li>
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
                            <h3 class="card-title">Informasi Reservasi</h3>

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
                                <label for="inputtanggalCheckIn">Tanggal Check In</label>
                                <input
                                    type="date"
                                    id="inputtanggalCheckIn"
                                    name="tanggalCheckIn"
                                    class="form-control @error('tanggalCheckIn') is-invalid @enderror"
                                    placeholder="Masukkan Tanggal Check In"
                                    value="{{ old('tanggalCheckIn') }}"
                                    required="required"
                                    autocomplete="tanggalCheckIn">
                                @error('tanggalCheckIn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputtanggalCheckOut">Tanggal Check Out</label>
                                <input
                                    type="date"
                                    id="inputtanggalCheckOut"
                                    name="tanggalCheckOut"
                                    class="form-control @error('tanggalCheckOut') is-invalid @enderror"
                                    placeholder="Masukkan Tanggal Check Out"
                                    value="{{ old('tanggalCheckOut') }}"
                                    required="required"
                                    autocomplete="tanggalCheckOut">
                                @error('tanggalCheckOut')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputJumlahTamu">Jumlah Tamu</label>
                                <input
                                    type="number"
                                    id="inputJumlahTamu"
                                    name="jumlahTamu"
                                    class="form-control @error('jumlahTamu') is-invalid @enderror"
                                    placeholder="Masukkan Jumlah Tamu"
                                    value="{{ old('jumlahTamu') }}"
                                    required="required"
                                    autocomplete="jumlahTamu"
                                >
                                @error('jumlahTamu')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputKamar">Pilih Kamar Hotel</label>
                                <div class="row" id="kamarRows">
                                    <div class="col-md-8">
                                        <select
                                            id="inputKamar"
                                            name="kamar[]"
                                            class="form-control @error('kamar') is-invalid @enderror"
                                            required="required"
                                            autocomplete="kamar"
                                        >
                                            <option value="" disabled selected>Pilih Kamar</option>
                                            @foreach ($availableRooms as $room)
                                                <option value="{{ $room->idKamar }}">{{ $room->tipeKamar }}</option>
                                            @endforeach
                                        </select>
                                        @error('kamar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success" onclick="addRow()">Tambah</button>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputtotalBiaya">Total Biaya</label>
                                <input
                                    type="number"
                                    id="inputtotalBiaya"
                                    name="totalBiaya"
                                    class="form-control @error('totalBiaya') is-invalid @enderror"
                                    placeholder="Masukkan Jumlah Tamu"
                                    value="{{ old('totalBiaya') }}"
                                    required="required"
                                    autocomplete="totalBiaya"
                                >
                                @error('totalBiaya')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputmetodePembayaran">Metode Pembayaran</label>
                                <input
                                    type="text"
                                    id="inputmetodePembayaran"
                                    name="metodePembayaran"
                                    class="form-control @error('metodePembayaran') is-invalid @enderror"
                                    placeholder="Masukkan metodePembayaran"
                                    value="{{ old('metodePembayaran') }}"
                                    required="required"
                                    autocomplete="metodePembayaran">
                                @error('metodePembayaran')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select
                                    id="inputStatus"
                                    name="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                    required="required"
                                    autocomplete="status"
                                >
                                    <option value="Pilih Status" disabled selected>Pilih Status</option>
                                    <option value="Buka">Buka</option>
                                    <option value="Penuh">Penuh</option>
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
                    <a href="{{ route('user.home') }}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Tambah Reservasi" class="btn btn-success float-right">
                </div>
            </div>
        </div>
    </form>

    <script>
        function addRow() {
            var row = '<div class="row">' +
                          '<div class="col-md-8">' +
                              '<select id="inputKamar" name="kamar[]" class="form-control" required="required" autocomplete="kamar">' +
                                  '<option value="" disabled selected>Pilih Kamar</option>' +
                                  '@foreach ($availableRooms as $room)' +
                                      '<option value="{{ $room->idKamar }}">{{ $room->tipeKamar }}</option>' +
                                  '@endforeach' +
                              '</select>' +
                          '</div>' +
                          '<div class="col-md-2">' +
                              '<button type="button" class="btn btn-danger" onclick="removeRow(this)">Hapus</button>' +
                          '</div>' +
                      '</div>';
            $('#kamarRows').append(row);
        }

        function removeRow(button) {
            $(button).closest('.row').remove();
        }
    </script>
</section>
@endsection