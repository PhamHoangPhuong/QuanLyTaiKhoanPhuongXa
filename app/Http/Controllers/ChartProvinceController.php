<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChartProvinceController extends Controller
{
    public function chart_province(){

        return view('charts.charts-province-index');

    }

    public function getYearsByProvince()
    {
        $years_column = DB::select('SELECT DISTINCT nam_dieu_tra FROM provinces_report ORDER BY nam_dieu_tra ASC');

        return response()->json($years_column);
    }

    public function chartProvinceDataColumn(Request $request)
    {
        $provinces = Auth::user()->getAttributes();
        $province = $provinces["province_id"];

        $namDieuTra = $request->input('years');

        $province_report = DB::selectOne('SELECT * FROM provinces_report WHERE province_id = ? AND nam_dieu_tra = ?', [
            $province, $namDieuTra]);

        $seriesDataColumn = [
            [
                'name' => 'Ds mù chữ ở mức độ 1 chưa hoàn thành lớp 3',
                'data' => [
                    $province_report->Ds_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
                    $province_report->Ds_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
                    $province_report->Ds_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3
                ]
            ],
            [
                'name' => 'Ds nữ mù chữ ở mức độ 1 chưa hoàn thành lớp 3',
                'data' => [
                    $province_report->Ds_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
                    $province_report->Ds_nu_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
                    $province_report->Ds_nu_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3
                ]
            ],
            [
                'name' => 'Dt mù chữ ở mức độ 1 chưa hoàn thành lớp 3',
                'data' => [
                    $province_report->Dt_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
                    $province_report->Dt_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
                    $province_report->Dt_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3
                ]
            ],
            [
                'name' => 'Dt nữ mù chữ ở mức độ 1 chưa hoàn thành lớp 3',
                'data' => [
                    $province_report->Dt_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
                    $province_report->Dt_nu_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
                    $province_report->Dt_nu_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3
                ]
            ],
            [
                'name' => 'Ds mù chữ ở mức độ 2 chưa hoàn thành lớp 5',
                'data' => [
                    $province_report->Ds_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
                    $province_report->Ds_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
                    $province_report->Ds_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5
                ]
            ],
            [
                'name' => 'Ds nữ mù chữ ở mức độ 2 chưa hoàn thành lớp 5',
                'data' => [
                    $province_report->Ds_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
                    $province_report->Ds_nu_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
                    $province_report->Ds_nu_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5
                ]
            ],
            [
                'name' => 'Dt mù chữ ở mức độ 2 chưa hoàn thành lớp 5',
                'data' => [
                    $province_report->Dt_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
                    $province_report->Dt_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
                    $province_report->Dt_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5
                ]
            ],
            [
                'name' => 'Dt nữ mù chữ ở mức độ 2 chưa hoàn thành lớp 5',
                'data' => [
                    $province_report->Dt_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
                    $province_report->Dt_nu_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
                    $province_report->Dt_nu_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5
                ]
            ]
        ];

        return response()->json($seriesDataColumn);
    }


    public function chartProvinceDataCircle(Request $request){

        $provinces = Auth::user()->getAttributes();
        $province = $provinces["province_id"];
        $namDieuTra = $request->input('years');

        $province_report = DB::selectOne(
            'SELECT * FROM provinces_report WHERE province_id = ? AND nam_dieu_tra = ?',
            [$province, $namDieuTra]
        );


        if (!$province_report) {
            return response()->json([
                'series' => [
                    ['name' => 'Giới tính nam', 'y' => 0],
                    ['name' => 'Giới tính nữ', 'y' => 0]
                ],
                'total' => 0
            ]);
        }

        return response()->json([
            'series' => [
                ['name' => 'Giới tính nam', 'y' => $province_report->gioi_tinh_nam],
                ['name' => 'Giới tính nữ', 'y' => $province_report->gioi_tinh_nu]
            ],
            'total'  => $province_report->tong_dan_so
        ]);
    }


    public function chartProvinceDataCircle_1(Request $request){

        $provinces = Auth::user()->getAttributes();
        $province = $provinces["province_id"];
        $namDieuTra = $request->input('years');

        $province_report = DB::selectOne(
            'SELECT * FROM provinces_report WHERE province_id = ? AND nam_dieu_tra = ?',
            [$province, $namDieuTra]
        );

        if (!$province_report) {
            return response()->json([
                'series_1' => [
                    ['name' => 'Giới tính nam', 'y' => 0],
                    ['name' => 'Giới tính nữ', 'y' => 0]
                ],
                'total_1' => 0
            ]);
        }

        return response()->json([
            'series_1' => [
                ['name' => 'Giới tính nam', 'y' =>
                    $province_report->dan_so_tu_15_den_25_tuoi - $province_report->gioi_tinh_nu_tu_15_den_25_tuoi],
                ['name' => 'Giới tính nữ', 'y' => $province_report->gioi_tinh_nu_tu_15_den_25_tuoi]
            ],
            'total_1'  => $province_report->dan_so_tu_15_den_25_tuoi
        ]);
    }


    public function chartProvinceDataCircle_2(Request $request){

        $provinces = Auth::user()->getAttributes();
        $province = $provinces["province_id"];
        $namDieuTra = $request->input('years');

        $province_report = DB::selectOne(
            'SELECT * FROM provinces_report WHERE province_id = ? AND nam_dieu_tra = ?',
            [$province, $namDieuTra]
        );

        if (!$province_report) {
            return response()->json([
                'series_2' => [
                    ['name' => 'Giới tính nam', 'y' => 0],
                    ['name' => 'Giới tính nữ', 'y' => 0]
                ],
                'total_2' => 0
            ]);
        }

        return response()->json([
            'series_2' => [
                ['name' => 'Giới tính nam', 'y' =>
                    $province_report->dan_so_tu_15_den_35_tuoi - $province_report->gioi_tinh_nu_tu_15_den_35_tuoi],
                ['name' => 'Giới tính nữ', 'y' => $province_report->gioi_tinh_nu_tu_15_den_35_tuoi]
            ],
            'total_2'  => $province_report->dan_so_tu_15_den_35_tuoi
        ]);
    }

    
    public function chartProvinceDataCircle_3(Request $request){

        $provinces = Auth::user()->getAttributes();
        $province = $provinces["province_id"];
        $namDieuTra = $request->input('years');

        $province_report = DB::selectOne(
            'SELECT * FROM provinces_report WHERE province_id = ? AND nam_dieu_tra = ?',
            [$province, $namDieuTra]
        );

        if (!$province_report) {
            return response()->json([
                'series_3' => [
                    ['name' => 'Giới tính nam', 'y' => 0],
                    ['name' => 'Giới tính nữ', 'y' => 0]
                ],
                'total_3' => 0
            ]);
        }

        return response()->json([
            'series_3' => [
                ['name' => 'Giới tính nam', 'y' =>
                    $province_report->dan_so_tu_15_den_60_tuoi - $province_report->gioi_tinh_nu_tu_15_den_60_tuoi],
                ['name' => 'Giới tính nữ', 'y' => $province_report->gioi_tinh_nu_tu_15_den_60_tuoi]
            ],
            'total_3'  => $province_report->dan_so_tu_15_den_60_tuoi
        ]);
    }
    
}
