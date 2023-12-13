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
                                    <select
                                        id="inputKamar"
                                        name="idKamar"
                                        class="form-control @error('kamar') is-invalid @enderror"
                                        required="required"
                                        autocomplete="kamar"
                                    >
                                        <option value="" disabled selected>Pilih Kamar</option>
                                        @foreach ($availableRooms as $room)
                                            @php
                                                $formattedRoomType = str_pad($room->tipeKamar, 15); // Adjust the width as needed
                                            @endphp
                                            <option value="{{ $room->idKamar }}" data-harga-per-malam="{{ $room->hargaPerMalam }}">
                                                {{ $formattedRoomType }} || Kamar-{{ $room->idKamar }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kamar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Total Biaya</h3>

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
                            <label for="inputtotalBiaya">Total Biaya</label>
                                <input
                                    type="number"
                                    id="inputtotalBiaya"
                                    name="totalBiaya"
                                    class="form-control @error('totalBiaya') is-invalid @enderror"
                                    placeholder="Total Biaya"
                                    value="{{ old('totalBiaya') }}"
                                    autocomplete="totalBiaya"
                                    readonly
                                >
                                @error('totalBiaya')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('user.home') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Tambah Reservasi" class="btn btn-success float-right">
                    </div>
                </div>
        </div>
    </form>

</section>
@endsection

@section('script_footer')
<!-- Tambahkan bagian script di bagian bawah halaman atau di bagian head -->
<script>
    // Fungsi untuk menghitung selisih hari antara dua tanggal
    function getSelisihHari(tanggalCheckIn, tanggalCheckOut) {
        var date1 = new Date(tanggalCheckIn);
        var date2 = new Date(tanggalCheckOut);
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var selisihHari = Math.ceil(timeDiff / (1000 * 3600 * 24));
        return selisihHari;
    }

    // Fungsi untuk menghitung total biaya
    function hitungTotalBiaya() {
        var tanggalCheckIn = document.getElementById('inputtanggalCheckIn').value;
        var tanggalCheckOut = document.getElementById('inputtanggalCheckOut').value;
        var hargaPerMalam = document.getElementById('inputKamar').options[document.getElementById('inputKamar').selectedIndex].getAttribute('data-harga-per-malam');

        var selisihHari = getSelisihHari(tanggalCheckIn, tanggalCheckOut);

        var totalBiaya = selisihHari * hargaPerMalam;

        // Menampilkan total biaya
        document.getElementById('inputtotalBiaya').value = totalBiaya;
    }

    // Menambahkan event listener untuk memanggil fungsi hitungTotalBiaya saat input tanggalCheckIn, tanggalCheckOut, atau inputKamar berubah
    document.getElementById('inputtanggalCheckIn').addEventListener('change', hitungTotalBiaya);
    document.getElementById('inputtanggalCheckOut').addEventListener('change', hitungTotalBiaya);
    document.getElementById('inputKamar').addEventListener('change', hitungTotalBiaya);
</script>
@endsection