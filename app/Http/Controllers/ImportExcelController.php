<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Jobs\ProcessImportJob;

class ImportExcelController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);     
        $perPage = 100;                           
        $offset = ($page - 1) * $perPage;

        if($userWardId = Auth::user()->ward_id){

            $year = request()->get('nam_dieu_tra');

            $where = "WHERE excel_import.ward_id = $userWardId";

            if (!empty($year)) {
                $where .= " AND excel_import.nam_dieu_tra = " . intval($year);
            }

            $excel = DB::select("
                SELECT excel_import.*, wards.ten_phuong 
                FROM excel_import
                JOIN wards ON wards.ward_id = excel_import.ward_id
                $where
                LIMIT $perPage OFFSET $offset
            ");

            $totalExcel = DB::select("
                SELECT COUNT(*) as total 
                FROM excel_import
                $where
            ")[0]->total;

            $paginatedExcel = new LengthAwarePaginator(
                $excel,
                $totalExcel,
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $years = DB::select("
                SELECT DISTINCT nam_dieu_tra 
                FROM excel_import 
                WHERE ward_id = $userWardId 
                ORDER BY nam_dieu_tra DESC
            ");

            return view('excels.excels-index', compact('paginatedExcel', 'years'));

        }else{
            $userProvinceId = Auth::user()->province_id;

            $year = request()->get('nam_dieu_tra');

            $ward = request()->get('ten_phuong');

            $where = "WHERE wards.province_id = $userProvinceId";

            if (!empty($year) && !empty($ward)) {
                $where .= " AND excel_import.nam_dieu_tra = " . intval($year) . " AND ten_phuong =  '$ward' ";
            }

            if (!empty($year)) {
                $where .= " AND excel_import.nam_dieu_tra = " . intval($year);
            }

            if (!empty($ward)) {
                $where .= " AND ten_phuong =  '$ward' ";
            }

            $excel = DB::select("
                SELECT excel_import.*, wards.ten_phuong 
                FROM excel_import
                JOIN wards ON wards.ward_id = excel_import.ward_id
                $where
                LIMIT $perPage OFFSET $offset
            ");

            $totalExcel = DB::select("
                SELECT COUNT(*) as total 
                FROM excel_import
                JOIN wards ON wards.ward_id = excel_import.ward_id
                $where
            ")[0]->total;

            $paginatedExcel = new LengthAwarePaginator(
                $excel,
                $totalExcel,
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $years = DB::select("
                SELECT DISTINCT nam_dieu_tra 
                FROM excel_import 
                JOIN wards ON wards.ward_id = excel_import.ward_id
                WHERE province_id = $userProvinceId 
                ORDER BY nam_dieu_tra DESC
            ");

            $wards = DB::select("
                SELECT DISTINCT ten_phuong
                FROM excel_import 
                JOIN wards ON wards.ward_id = excel_import.ward_id
                WHERE province_id = $userProvinceId 
            ");

            return view('excels.excels-index', compact('paginatedExcel', 'years', 'wards'));
        }
    }


    public function importQueue(Request $request)
    {
        $file = $request->file('myFile');

        if(!$file){
            return response()->json(['message' => 'Yêu cầu gửi file'], 400);
        }

        $extension = strtolower($file->getClientOriginalExtension());

        $validExtensions = ['xlsx', 'xls', 'csv'];

        if (!in_array($extension, $validExtensions)) {
            return response()->json(['message' => 'File không đúng định dạng Excel'], 400);
        }

        $path = $file->store('imports');

        $now = now();


        $ids = Auth::user()->getAttributes();
        $id = $ids["ward_id"];
        $idProvince = $ids["province_id"];
        // dd($id);

        $sessionCode = (string) Str::uuid();

        DB::statement("INSERT INTO import_sessions (session_code, ward_id, province_id, status, result, total_success, total_fail, queued_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [
            $sessionCode,
            $id,
            $idProvince,
            'Đang chờ xử lý',
            null,
            0,
            0,
            $now,
        ]);

        // Lấy session vừa tạo để truyền vào job
        $sessionRecord = DB::select("SELECT * FROM import_sessions WHERE session_code = ? LIMIT 1", [$sessionCode]);
        if (!$sessionRecord) {
            return response()->json(['message' => 'Không thể tạo phiên import'], 500);
        }
        $session = $sessionRecord[0];

        
        
        ProcessImportJob::dispatchSync($session->id, $path, $id, $idProvince);
    
        return redirect()->route('index')->with('success', 'Import dữ liệu excel thành công');
    }

}
