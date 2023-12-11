<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\KamarHotel;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'tanggalCheckIn' => 'required|date',
                'tanggalCheckOut' => 'required|date',
                'jumlahTamu' => 'required|integer',
                'totalBiaya' => 'required',
                'status' => 'required|string',
                'metodePembayaran' => 'required|string',
            ]);
            
            Reservasi::create([
                'idKamar' =>  1,
                'idPelanggan' =>  1,
                'tanggalCheckIn' =>  $request->tanggalCheckIn,
                'tanggalCheckOut' => $request->tanggalCheckOut,
                'jumlahTamu' => $request->jumlahTamu,
                'totalBiaya' => $request->totalBiaya,
                'status' => $request->status,
                'metodePembayaran' => $request->metodePembayaran,
            ]);
            return redirect()->route('user.reservasi')->with('status', 'Reservasi anda telah berhasil');
        }

        $availableRooms = KamarHotel::where('status', "Tersedia")->get();

        return view('page.user.reservasi', compact('availableRooms'));
    }

    // public function buatReservasi(Request $request)
    // {
        
    // }
}
