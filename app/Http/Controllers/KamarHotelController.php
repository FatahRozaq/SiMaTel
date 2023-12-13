<?php

namespace App\Http\Controllers;

use App\Models\KamarHotel;
use Illuminate\Http\Request;
use App\Exports\KamarHotelExport;
use App\Imports\KamarHotelImport;
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
        if (request()->ajax()) {
            $kamarHotel = KamarHotel::query();
            return DataTables::of($kamarHotel)
                ->make();
        }
        return view('page.admin.kamarHotel.index');
    }

    public function tambahKamar(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'tipeKamar' => 'required|string|max:25|min:5',
                'hargaPerMalam' => 'required',
                'kapasitas' => 'required|integer|max:2',
                'status' => 'required|string',
            ]);
            
            KamarHotel::create([
                'tipeKamar' => $request->tipeKamar,
                'hargaPerMalam' => $request->hargaPerMalam,
                'kapasitas' => $request->kapasitas,
                'status' => $request->status,
            ]);
            return redirect()->route('kamar.add')->with('status', 'Data telah tersimpan di database');
        }
        return view('page.admin.kamarHotel.addKamar');
    }

    public function ubahKamar($idKamar, Request $request)
    {
        $kamar = KamarHotel::findOrFail($idKamar);
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'tipeKamar' => 'required|string|max:25|min:5',
                'hargaPerMalam' => 'required',
                'kapasitas' => 'required|integer|max:2',
                'status' => 'required|string',
            ]);
            $kamar->update([
                'tipeKamar' => $request->tipeKamar,
                'hargaPerMalam' => $request->hargaPerMalam,
                'kapasitas' => $request->kapasitas,
                'status' => $request->status,
            ]);
            return redirect()->route('kamar.edit',['idKamar' => $kamar->idKamar ])->with('status', 'Data telah tersimpan di database');
        }
        return view('page.admin.kamarHotel.ubahKamar', [
            'kamar' => $kamar
        ]);
    }

    public function hapusKamar($idKamar)
    {
        $kamar = KamarHotel::findOrFail($idKamar);
        
        $kamar->delete($idKamar);
        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }
}
