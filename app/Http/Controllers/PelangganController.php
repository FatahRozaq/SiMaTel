<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PelangganExport;
use App\Imports\PelangganImport;

class PelangganController extends Controller
{
    public function export() 
    {
        return Excel::download(new PelangganExport, 'pelanggan.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new PelangganImport, $file);
            return redirect()->back()->with('success', 'Data pelanggan berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function index()
    {
        try {
            if (request()->ajax()) {
                $pelanggan = Pelanggan::query();
                return DataTables::of($pelanggan)
                    ->make();
            }
            return view('page.admin.pelanggan.index');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function dataTable(Request $request)
    {
        try {
            $totalFilteredRecord = $totalDataRecord = $draw_val = "";
            $columns_list = array(
                0 => 'namaPelanggan',
                1 => 'alamat',
                2 => 'noTelepon',
                3 => 'email',
                4 => 'noIdentifikasi',
                5 => 'idPelanggan',
            );

            $totalDataRecord = Pelanggan::count();

            $totalFilteredRecord = $totalDataRecord;

            $limit_val = $request->input('length');
            $start_val = $request->input('start');
            $order_val = $columns_list[$request->input('order.0.column')];
            $dir_val = $request->input('order.0.dir');

            if (empty($request->input('search.value'))) {
                $pelanggan_data = Pelanggan::offset($start_val)
                    ->limit($limit_val)
                    ->orderBy($order_val, $dir_val)
                    ->get();
            } else {
                $search_text = $request->input('search.value');

                $pelanggan_data =  Pelanggan::where('namaPelanggan', 'LIKE', "%{$search_text}%")
                    ->orWhere('alamat', 'LIKE', "%{$search_text}%")
                    ->orWhere('noTelepon', 'LIKE', "%{$search_text}%")
                    ->orWhere('email', 'LIKE', "%{$search_text}%")
                    ->orWhere('noIdentifikasi', 'LIKE', "%{$search_text}%")
                    ->offset($start_val)
                    ->limit($limit_val)
                    ->orderBy($order_val, $dir_val)
                    ->get();

                $totalFilteredRecord = Pelanggan::where('namaPelanggan', 'LIKE', "%{$search_text}%")
                    ->orWhere('alamat', 'LIKE', "%{$search_text}%")
                    ->orWhere('noTelepon', 'LIKE', "%{$search_text}%")
                    ->orWhere('email', 'LIKE', 'LIKE', "%{$search_text}%")
                    ->orWhere('noIdentifikasi', 'LIKE', "%{$search_text}%")
                    ->count();
            }

            $data_val = array();
            if (!empty($pelanggan_data)) {
                foreach ($pelanggan_data as $pelanggan_val) {
                    $url = route('pelanggan.edit', ['idPelanggan' => $pelanggan_val->idPelanggan]);
                    $urlHapus = route('pelanggan.delete', ['idPelanggan' => $pelanggan_val->idPelanggan]);

                    $pelangganNestedData['namaPelanggan'] = $pelanggan_val->namaPelanggan;
                    $pelangganNestedData['alamat'] = $pelanggan_val->alamat;
                    $pelangganNestedData['noTelepon'] = $pelanggan_val->noTelepon;
                    $pelangganNestedData['email'] = $pelanggan_val->email;
                    $pelangganNestedData['noIdentifikasi'] = $pelanggan_val->noIdentifikasi;
                    $pelangganNestedData['options'] = "<a href='$url'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$pelanggan_val->idPelanggan' data-url='$urlHapus'><i class='fas fa-trash fa-lg text-danger'></i></a>";
                    $data_val[] = $pelangganNestedData;
                }
            }
            $draw_val = $request->input('draw');
            $get_json_data = array(
                "draw"            => intval($draw_val),
                "recordsTotal"    => intval($totalDataRecord),
                "recordsFiltered" => intval($totalFilteredRecord),
                "data"            => $data_val
            );

            return response()->json($get_json_data);
        } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
    }

    public function tambahPelanggan(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'namaPelanggan' => 'required|string|max:200|min:3',
                    'alamat' => 'required|string|min:3',
                    'noTelepon' => 'required|string|min:3',
                    'email' => 'required|string|email',
                    'noIdentifikasi' => 'required|string|min:3',
                ]);

                Pelanggan::create([
                    'namaPelanggan' => $request->namaPelanggan,
                    'alamat' => $request->alamat,
                    'noTelepon' => $request->noTelepon,
                    'email' => $request->email,
                    'noIdentifikasi' => $request->noIdentifikasi,
                ]);

                return redirect()->route('pelanggan.add')->with('status', 'Data pelanggan telah tersimpan di database');
            }

            return view('page.admin.pelanggan.addPelanggan');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ubahPelanggan($id, Request $request)
    {
        try {
            $pelanggan = Pelanggan::findOrFail($id);

            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'namaPelanggan' => 'required|string|max:200|min:3',
                    'alamat' => 'required|string|min:3',
                    'noTelepon' => 'required|string|min:3',
                    'email' => 'required|string|email',
                    'noIdentifikasi' => 'required|string|min:3',
                ]);

                $pelanggan->update([
                    'namaPelanggan' => $request->namaPelanggan,
                    'alamat' => $request->alamat,
                    'noTelepon' => $request->noTelepon,
                    'email' => $request->email,
                    'noIdentifikasi' => $request->noIdentifikasi,
                ]);

                return redirect()->route('pelanggan.edit', ['idPelanggan' => $pelanggan->idPelanggan])->with('status', 'Data pelanggan telah diperbarui di database');
            }

            return view('page.admin.pelanggan.ubahPelanggan', [
                'pelanggan' => $pelanggan
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function hapusPelanggan($id)
    {
        try {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }   catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Data not found'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }
}
