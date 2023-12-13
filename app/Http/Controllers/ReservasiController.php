<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Reservasi;
use App\Models\Transaksi;
use App\Models\KamarHotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        if ($request->isMethod('post')) {

            $idKamars = KamarHotel::find($request->idKamar);
            $hargaKamar = $idKamars->hargaPerMalam;
            

            $this->validate($request, [
                'tanggalCheckIn' => 'required|date',
                'tanggalCheckOut' => 'required|date',
                'jumlahTamu' => 'required|integer',
                'totalBiaya' => 'required'
            ]);
            
            Reservasi::create([
                'idKamar' =>  $request->idKamar,
                'idPelanggan' =>  1,
                'tanggalCheckIn' =>  $request->tanggalCheckIn,
                'tanggalCheckOut' => $request->tanggalCheckOut,
                'jumlahTamu' => $request->jumlahTamu,
                'totalBiaya' => $request->totalBiaya,
                'status' => 'Belum Bayar',
                'metodePembayaran' => 'Belum Ada',
            ]);
            return redirect()->route('user.reservasi')->with('status', 'Reservasi anda telah berhasil');
        }

        $availableRooms = KamarHotel::where('status', 'Tersedia')->get()->sortBy(function($room) {
            $order = ['Suite', 'Deluxe', 'Standard'];
            return array_search($room->tipeKamar, $order);
        });

        return view('page.user.reservasi', compact('availableRooms'));
    }

    public function indexReservasi()
    {
        $user = Auth::user();

        if (request()->ajax()) {
            // $reservasi = Reservasi::query()
            //     ->where('idPelanggan', $user->id);
            $reservasi = Reservasi::query();
            return DataTables::of($reservasi)
                ->make();
        }
        return view('page.user.indexReservasi');
    }

    // public function buatReservasi(Request $request)
    // {
        
    // }

    public function transaksi(Request $request, $idReservasi)
    {
        $userId = Auth::id();
        if ($request->isMethod('post')) {

            $tanggalSekarang = Carbon::now();
            $reservasi = Reservasi::findOrFail($idReservasi);
            $this->validate($request, [
                'idReservasi' => 'required',
                'jumlahPembayaran' => 'required',
                'metodePembayaran' => 'required|string',
                'status' => 'required'
            ]);
            
            Transaksi::create([
                'idReservasi' =>  $request->idReservasi,
                'idPelanggan' =>  1,
                'tanggalPembayaran' =>  $tanggalSekarang,
                'jumlahPembayaran' => $request->jumlahPembayaran,
                'metodePembayaran' => $request->metodePembayaran,
                'status' => $request->status
            ]);

            $idKamar = $reservasi->idKamar;
            $reservasi->update([
                'status' => $request->status
            ]);

            KamarHotel::where('idKamar', $idKamar)
                ->update([
                    'status' => 'Terisi',
                ]);

            return redirect()->route('user.indexReservasi')->with('status', 'Transaksi anda telah berhasil');
        }

        $transaksi = Reservasi::find($idReservasi);

        return view('page.user.transaksi', [
            'transaksi' => $transaksi
        ]);
    }
}
