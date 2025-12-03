<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\WardsExport;
use Maatwebsite\Excel\Facades\Excel;

class WardReportController extends Controller
{
    public function view_ward_report(){

        $userProvinceId = Auth::user()->province_id;
        
        $ward_reports = DB::select("
            SELECT * FROM wards_report
            JOIN wards ON wards_report.ward_id = wards.ward_id
            WHERE wards_report.province_id = ?
        ", [$userProvinceId]);

        return view('ward_reports.ward-reports-index', compact('ward_reports'));

    }

    public function delete($ward_report_id){
        DB::delete("DELETE FROM wards_report WHERE ward_report_id = ?", [$ward_report_id]);

        return back()->with('success', 'Ward report deleted successfully!');
    }

    public function export()
    {
        $check = DB::select("SELECT COUNT(*) AS total FROM wards_report");
        if ($check[0]->total == 0) {
            return back()->with('error', 'Không có dữ liệu nào để xuất');
        }

        $id = Auth::guard('web')->user()->getAttributes();
        $province_id = $id["province_id"];
        return Excel::download(new WardsExport($province_id), 'wards.xlsx');
    }
}
