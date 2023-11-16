<?php

namespace App\Http\Controllers;

use App\Models\FasilitasHotel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FasilitasHotelController extends Controller
{
    public function index()
    {
        return view('page.admin.fasilitasHotel.index');
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
    }

    public function ubahFasilitas($idFasilitas, Request $request)
    {
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
            return redirect()->route('fasilitas.edit',['idFasilitas' => $fasilitas->idFasilitas ])->with('status', 'Data telah tersimpan di database');
        }
        return view('page.admin.fasilitasHotel.ubahFasilitas', [
            'fasilitas' => $fasilitas
        ]);
    }

    public function hapusAkun($idFasilitas)
    {
        $fasilitas = FasilitasHotel::findOrFail($idFasilitas);
        
        $fasilitas->delete($idFasilitas);
        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }
}
