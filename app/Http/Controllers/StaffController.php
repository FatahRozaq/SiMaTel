<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $staff = Staff::query();
            return DataTables::of($staff)
                ->make();
        }
       
        return view('page.admin.staff.index');
    }

    public function dataTable(Request $request)
    {
        $totalFilteredRecord = $totalDataRecord = $draw_val = "";
        $columns_list = array(
            0 => 'namaStaff',
            1 => 'alamat',
            2 => 'noTelepon',
            3 => 'email',
            4 => 'jabatan',
        );

        $totalDataRecord = Staff::count();

        $totalFilteredRecord = $totalDataRecord;

        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = $columns_list[$request->input('order.0.column')];
        $dir_val = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $staff_data = Staff::where('idStaff','!=',Auth::id())
            ->offset($start_val)
            ->limit($limit_val)
            ->orderBy($order_val,$dir_val)
            ->get();
        } else {
            $search_text = $request->input('search.value');

            $staff_data =  Staff::where('idStaff','!=',Auth::id())
            ->where('idStaff','LIKE',"%{$search_text}%")
            ->orWhere('namaStaff', 'LIKE',"%{$search_text}%")
            ->orWhere('alamat', 'LIKE',"%{$search_text}%")
            ->orWhere('noTelepon', 'LIKE',"%{$search_text}%")
            ->orWhere('email', 'LIKE',"%{$search_text}%")
            ->orWhere('jabatan', 'LIKE',"%{$search_text}%")
            ->offset($start_val)
            ->limit($limit_val)
            ->orderBy($order_val,$dir_val)
            ->get();

            $totalFilteredRecord = Staff::where('idStaff','!=',Auth::id())
            ->where('idStaff','LIKE',"%{$search_text}%")
            ->orWhere('namaStaff', 'LIKE',"%{$search_text}%")
            ->orWhere('alamat', 'LIKE',"%{$search_text}%")
            ->orWhere('noTelepon', 'LIKE',"%{$search_text}%")
            ->orWhere('email', 'LIKE',"%{$search_text}%")
            ->orWhere('jabatan', 'LIKE',"%{$search_text}%")
            ->count();
        }

        $data_val = array();
        if(!empty($staff_data))
        {
            foreach ($staff_data as $staff_val)
            {
                $url = route('staff.edit',['idStaff' => $staff_val->id]);
                $urlHapus = route('staff.delete',$staff_val->id);
                // if ($staff_val->user_image) {
                //     $img = $akun_val->user_image;
                // } else {
                //     $img = asset('vendor/adminlte3/img/user2-160x160.jpg');
                // }
                $staffnestedData['namaStaff'] = $staff_val->name;
                $staffnestedData['alamat'] = $staff_val->email;
                $staffnestedData['noTelepon'] = $staff_val->email;
                $staffnestedData['options'] = "<a href='$url'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$staff_val->id' data-url='$urlHapus'><i class='fas fa-trash fa-lg text-danger'></i></a>";
                $data_val[] = $staffnestedData;
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

    public function tambahStaff(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'namaStaff' => 'required|string|max:200|min:3',
                'alamat' => 'min:3',
                'noTelepon' => 'required|regex:/^[0-9]{12}$/',
                'email' => 'required|string|min:3|email|unique:users,email',
                'jabatan' => 'required|string'
            ]);
            
            Staff::create([
                'namaStaff' => $request->namaStaff,
                'alamat' => $request->alamat,
                'noTelepon' => $request->noTelepon,
                'email' => $request->email,
                'jabatan' => $request->jabatan,
            ]);
            return redirect()->route('staff.add')->with('status', 'Data telah tersimpan di database');
        }
        return view('page.admin.staff.addStaff');
    }

    public function ubahStaff($id, Request $request)
    {
        $staff = Staff::findOrFail($id);
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'namaStaff' => 'required|string|max:200|min:3',
                'alamat' => 'required|string|min:3',
                'noTelepon' => 'required|regex:/^[0-9]{12}$/',
                'email' => 'required|string|min:3|email|unique:users,email',
                'jabatan' => 'required|string'
            ]);
            
            $staff->update([
                'namaStaff' => $request->namaStaff,
                'alamat' => $request->alamat,
                'noTelepon' => $request->noTelepon,
                'email' => $request->email,
                'jabatan' => $request->jabatan,
            ]);
            return redirect()->route('staff.edit',['id' => $staff->id ])->with('status', 'Data telah tersimpan di database');
        }
        return view('page.admin.akun.ubahStaff', [
            'staff' => $staff
        ]);
    }

    public function hapusStaff($id)
    {
        $staff = Staff::findOrFail($id);
        
        $staff->delete($id);
        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }
}
