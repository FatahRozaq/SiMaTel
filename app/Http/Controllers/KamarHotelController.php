<?php

namespace App\Http\Controllers;

use App\Models\KamarHotel;
use Illuminate\Http\Request;
use App\Exports\KamarHotelExport;
use App\Imports\KamarHotelImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class KamarHotelController extends Controller
{
    public function export() 
    {
        return Excel::download(new KamarHotelExport, 'KamarHotel.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new KamarHotelImport, $file);
            return redirect()->back()->with('success', 'Data KamarHotel berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
    public function index()
    {
        try {
            if (request()->ajax()) {
                $kamarHotel = KamarHotel::query();
                return DataTables::of($kamarHotel)->make();
            }

            return view('page.admin.kamarHotel.index');
        } catch (\Exception $e) {
            Log::error('Error in YourController@index: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }

    public function tambahKamar(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'tipeKamar' => 'required|string|max:25|min:5',
                    'status' => 'required|string',
                ]);

                $hargaPerMalam = 0;
                $kapasitas = 0;

                if ($request->tipeKamar == 'Deluxe') {
                    $hargaPerMalam = 200000;
                    $kapasitas = 6;
                } elseif ($request->tipeKamar == 'Suite') {
                    $hargaPerMalam = 150000;
                    $kapasitas = 4;
                } else {
                    $hargaPerMalam = 100000;
                    $kapasitas = 2;
                }

                KamarHotel::create([
                    'tipeKamar' => $request->tipeKamar,
                    'hargaPerMalam' => $hargaPerMalam,
                    'kapasitas' => $kapasitas,
                    'status' => $request->status,
                ]);

                return redirect()->route('kamar.add')->with('status', 'Data telah tersimpan di database');
            }

            return view('page.admin.kamarHotel.addKamar');
        } catch (\Exception $e) {
            Log::error('Error in YourController@tambahKamar: ' . $e->getMessage());

            return back()->with('error', 'An error occurred. Please try again.');
        }
    }
    

    public function ubahKamar($idKamar, Request $request)
    {
        try {
            $kamar = KamarHotel::findOrFail($idKamar);

            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'tipeKamar' => 'required|string|max:25|min:5',
                    'status' => 'required|string',
                ]);

                $kamar->update([
                    'tipeKamar' => $request->tipeKamar,
                    'status' => $request->status,
                ]);

                return redirect()->route('kamar.edit', ['idKamar' => $kamar->idKamar])
                    ->with('status', 'Data telah tersimpan di database');
            }

            return view('page.admin.kamarHotel.ubahKamar', ['kamar' => $kamar]);
        } catch (\Exception $e) {
            Log::error('Error in YourController@ubahKamar: ' . $e->getMessage());

            return back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function hapusKamar($idKamar)
    {
        try {
            $kamar = KamarHotel::findOrFail($idKamar);
            
            $kamar->delete();

            return response()->json([
                'msg' => 'Data yang dipilih telah dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in YourController@hapusKamar: ' . $e->getMessage());

            return response()->json([
                'error' => 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.'
            ], 500);
        }
    }
}
