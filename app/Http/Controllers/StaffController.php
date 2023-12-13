<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\StaffExport;
use App\imports\StaffImport;
use Maatwebsite\Excel\Facades\Excel;

class StaffController extends Controller
{
    public function export() 
    {
        return Excel::download(new StaffExport, 'staff.xlsx');
    }

    public function imports(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');

 
		// import data
		Excel::import(new StaffImport, $file);
 
		// notifikasi dengan session
		
 
		// alihkan halaman kembali
		return redirect('staff.index');
	}

    public function index()
    {
        try {
            if (request()->ajax()) {
                $staff = Staff::query();
                return DataTables::of($staff)->make();
            }
            Log::info("Berhasil menampilkan data staff");
            return view('page.admin.staff.index');
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan ketika ingin menampilkan data");
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function dataTable(Request $request)
    {
        try {
            $totalFilteredRecord = $totalDataRecord = $draw_val = "";
            $columns_list = array(
                0 => 'namaStaff',
                1 => 'alamat',
                2 => 'noTelepon',
                3 => 'email',
                4 => 'jabatan',
                5 => 'fasilitasHotel',
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
                ->orWhere('fasilitasHotel', 'LIKE',"%{$search_text}%")
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
                ->orWhere('fasilitasHotel', 'LIKE',"%{$search_text}%")
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
                    $staffnestedData['alamat'] = $staff_val->alamat;
                    $staffnestedData['noTelepon'] = $staff_val->noTelepon;
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
            Log::info("Berhasil menampilkan data staff");
            echo json_encode($get_json_data);
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan ketika ingin menampilkan data");
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function tambahStaff(Request $request)
    {  
        try {
            if ($request->isMethod('post')) {

                $this->validate($request, [
                    'namaStaff' => 'required|string|max:200|min:3',
                    'alamat' => 'min:3',
                    'noTelepon' => 'required|regex:/^[0-9]{12}$/',
                    'email' => 'required|string|min:3|email|unique:users,email',
                    'jabatan' => 'required|string',
                    'fasilitasHotel' => 'required|string'
                ]);
                
                Staff::create([
                    'namaStaff' => $request->namaStaff,
                    'alamat' => $request->alamat,
                    'noTelepon' => $request->noTelepon,
                    'email' => $request->email,
                    'jabatan' => $request->jabatan,
                    'fasilitasHotel' => $request->fasilitasHotel,
                ]);
                Log::info("Berhasil menambahkan data staff");
                return redirect()->route('staff.add')->with('status', 'Data telah tersimpan di database');
            }
            return view('page.admin.staff.addStaff');
        }catch (\Exception $e) {
            Log::error("Terjadi kesalahan ketika ingin menambah data");
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ubahStaff($id, Request $request)
    {
        try {
            $staff = Staff::findOrFail($id);
            if ($request->isMethod('post')) {

                $this->validate($request, [
                    'namaStaff' => 'required|string|max:200|min:3',
                    'alamat' => 'required|string|min:3',
                    'noTelepon' => 'required|regex:/^[0-9]{12}$/',
                    'email' => 'required|string|min:3|email|unique:users,email',
                    'jabatan' => 'required|string',
                    'fasilitasHotel' => 'required|string',
                ]);
                
                $staff->update([
                    'namaStaff' => $request->namaStaff,
                    'alamat' => $request->alamat,
                    'noTelepon' => $request->noTelepon,
                    'email' => $request->email,
                    'jabatan' => $request->jabatan,
                    'fasilitasHotel' => $request->fasilitasHotel,
                ]);
                Log::info("Data staff dengan ID $id berhasil diedit");
                return redirect()->route('staff.edit',['id' => $staff->id ])->with('status', 'Data telah tersimpan di database');
            }
            return view('page.admin.akun.ubahStaff', [
                'staff' => $staff
            ]);
        } catch (ModelNotFoundException $e) {
            Log::warning("Terjadi kesalahan ketika mengedit data staff, karena staff dengan ID $id tidak ada");
            return response()->json(['error' => 'Data not found'], 404);
        } catch (ValidationException $e) {
            Log::warning("Terjadi kesalahan ketika mengedit data staff, karena terdapat kesalahan ketika validasi data");
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan ketika ingin mengedit data, namun bukan karena staff dengan ID $id tidak ada");
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function hapusStaff($id)
    {
        try {
            $staff = Staff::findOrFail($id);
            
            $staff->delete($id);
            Log::info("Data staff dengan ID $id berhasil dihapus");
            return response()->json([
                'msg' => 'Data yang dipilih telah dihapus'
            ]);
            
        } catch (ModelNotFoundException $e) {
            Log::warning("Terjadi kesalahan ketika menghapus data staff, karena staff dengan ID $id tidak ada");
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan ketika ingin menghapus data, namun bukan karena staff dengan ID $id tidak ada");
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}