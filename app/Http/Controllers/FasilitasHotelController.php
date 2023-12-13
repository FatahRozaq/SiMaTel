<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FasilitasHotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FasilitasHotelExport;
use App\Imports\FasilitasHotelImport;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class FasilitasHotelController extends Controller
{
    public function index()
    {
        try {
            if (request()->ajax()) {
                $fasilitasHotel = FasilitasHotel::query();
                return DataTables::of($fasilitasHotel)->make();
            }
    
            return view('page.admin.fasilitasHotel.index');
        } catch (\Exception $e) {
            Log::error('Error in FasilitasHotelController@index: ' . $e->getMessage());
            
            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }

    public function dataTable(Request $request)
    {
        $totalFilteredRecord = $totalDataRecord = $draw_val = "";
        $columns_list = array(
            0 => 'namaFasilitas',
            1 => 'status',
            2 => 'jumlahTamu',
            3 => 'deskripsi',
            4 => 'idFasilitas',
        );

        $totalDataRecord = FasilitasHotel::count();

        $totalFilteredRecord = $totalDataRecord;

        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = $columns_list[$request->input('order.0.column')];
        $dir_val = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $fasilitas_data = FasilitasHotel::offset($start_val)
            ->limit($limit_val)
            ->orderBy($order_val,$dir_val)
            ->get();
        } else {
            $search_text = $request->input('search.value');

            $fasilitas_data =  FasilitasHotel::where('idFasilitas','LIKE',"%{$search_text}%")
            ->orWhere('namaFasilitas', 'LIKE',"%{$search_text}%")
            ->orWhere('status', 'LIKE',"%{$search_text}%")
            ->orWhere('jumlahTamu', 'LIKE',"%{$search_text}%")
            ->orWhere('deskripsi', 'LIKE',"%{$search_text}%")
            ->offset($start_val)
            ->limit($limit_val)
            ->orderBy($order_val,$dir_val)
            ->get();

            $totalFilteredRecord = FasilitasHotel::where('idFasilitas','LIKE',"%{$search_text}%")
            ->orWhere('namaFasilitas', 'LIKE',"%{$search_text}%")
            ->orWhere('status', 'LIKE',"%{$search_text}%")
            ->orWhere('jumlahTamu', 'LIKE',"%{$search_text}%")
            ->orWhere('deskripsi', 'LIKE',"%{$search_text}%")
            ->count();
        }

        $data_val = array();
        if(!empty($fasilitas_data))
        {
            foreach ($fasilitas_data as $fasilitas_val)
            {
                $url = route('fasilitas.edit',['idFasilitas' => $fasilitas_val->idFasilitas]);
                $urlHapus = route('fasilitas.delete',$fasilitas_val->idFasilitas);
                $akunnestedData['namaFasilitas'] = $fasilitas_val->namaFasilitas;
                $akunnestedData['status'] = $fasilitas_val->status;
                $akunnestedData['jumlahTamu'] = $fasilitas_val->jumlahTamu;
                $akunnestedData['deskripsi'] = $fasilitas_val->deskripsi;
                $akunnestedData['options'] = "<a href='$url'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$fasilitas_val->idFasilitas' data-url='$urlHapus'><i class='fas fa-trash fa-lg text-danger'></i></a>";
                $data_val[] = $akunnestedData;
            }
        }
        $draw_val = $request->input('draw');
        $get_json_data = array(
        "draw"            => intval($draw_val),
        "recordsTotal"    => intval($totalDataRecord),
        "recordsFiltered" => intval($totalFilteredRecord),
        "data"            => $data_val
        );

        echo json_encode($get_json_data);
    }

    public function tambahFasilitas(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'namaFasilitas' => 'required|string|max:200|min:3',
                    'deskripsi' => 'required|string|max:200|min:3',
                    'jumlahTamu' => 'required',
                    'status' => 'required',
                ]);

                FasilitasHotel::create([
                    'namaFasilitas' => $request->namaFasilitas,
                    'deskripsi' => $request->deskripsi,
                    'jumlahTamu' => $request->jumlahTamu,
                    'status' => $request->status,
                ]);

                return redirect()->route('fasilitas.add')->with('status', 'Data telah tersimpan di database');
            }

            return view('page.admin.fasilitasHotel.addFasilitas');
        } catch (\Exception $e) {
            Log::error('Error in FasilitasHotelController@tambahFasilitas: ' . $e->getMessage());

            return redirect()->route('fasilitas.add')->with('error', 'An error occurred. Please try again.');
        }
    }


    public function ubahFasilitas($idFasilitas, Request $request)
    {
        try {
            $fasilitas = FasilitasHotel::findOrFail($idFasilitas);

            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'namaFasilitas' => 'required|string|max:200|min:3',
                    'deskripsi' => 'required|string|max:200|min:3',
                    'jumlahTamu' => 'required',
                    'status' => 'required',
                ]);

                $fasilitas->update([
                    'namaFasilitas' => $request->namaFasilitas,
                    'deskripsi' => $request->deskripsi,
                    'jumlahTamu' => $request->jumlahTamu,
                    'status' => $request->status,
                ]);

                return redirect()->route('fasilitas.edit', ['idFasilitas' => $fasilitas->idFasilitas])
                    ->with('status', 'Data telah tersimpan di database');
            }

            return view('page.admin.fasilitasHotel.ubahFasilitas', ['fasilitas' => $fasilitas]);
        } catch (\Exception $e) {
            Log::error('Error in FasilitasHotelController@ubahFasilitas: ' . $e->getMessage());

            return redirect()->route('fasilitas.edit', ['idFasilitas' => $idFasilitas])
                ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function hapusAkun($idFasilitas)
    {
        try {
            $fasilitas = FasilitasHotel::findOrFail($idFasilitas);

            $fasilitas->delete();

            return response()->json([
                'msg' => 'Data yang dipilih telah dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in YourController@hapusAkun: ' . $e->getMessage());

            return response()->json([
                'error' => 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.'
            ], 500);
        }
    }

    public function exportFasilitas()
    {
        try {
            return Excel::download(new FasilitasHotelExport, 'fasilitas_hotel.xlsx');
        } catch (\Exception $e) {
            Log::error('Error in FasilitasControllerr@exportFasilitas: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while exporting data. Please try again.');
        }
    }

    public function importFasilitas(Request $request)
    {
        try {
            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);

            $file = $request->file('file');
            Excel::import(new FasilitasHotelImport, $file);

            return redirect('page.admin.fasilitasHotel.index');
        } catch (\Exception $e) {
            Log::error('Error in FasilitasController@importFasilitas: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while importing data. Please try again.');
        }
    }
}
