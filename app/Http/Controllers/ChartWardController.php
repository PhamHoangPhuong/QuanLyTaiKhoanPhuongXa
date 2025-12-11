<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChartWardController extends Controller
{
    public function chart_ward(){

        return view('charts.charts-ward-index');

    }

    public function getYearsByWard()
    {
        $years_column = DB::select('SELECT DISTINCT nam_dieu_tra FROM wards_report ORDER BY nam_dieu_tra ASC');

        return response()->json($years_column);
    }

    public function chartWardDataColumn(Request $request)
    {
        $wards = Auth::user()->getAttributes();
        $ward = $wards["ward_id"];

        $namDieuTra = $request->input('years');

        $ward_report = DB::selectOne('SELECT * FROM wards_report WHERE ward_id = ? AND nam_dieu_tra = ?', [
            $ward, $namDieuTra]);

        $seriesDataColumn = [
            [
                'name' => 'Ds mù chữ ở mức độ 1 chưa hoàn thành lớp 3',
                'data' => [
                    $ward_report->Ds_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
                    $ward_report->Ds_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
                    $ward_report->Ds_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3
                ]
            ],
            [
                'name' => 'Ds nữ mù chữ ở mức độ 1 chưa hoàn thành lớp 3',
                'data' => [
                    $ward_report->Ds_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
                    $ward_report->Ds_nu_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
                    $ward_report->Ds_nu_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3
                ]
            ],
            [
                'name' => 'Dt mù chữ ở mức độ 1 chưa hoàn thành lớp 3',
                'data' => [
                    $ward_report->Dt_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
                    $ward_report->Dt_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
                    $ward_report->Dt_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3
                ]
            ],
            [
                'name' => 'Dt nữ mù chữ ở mức độ 1 chưa hoàn thành lớp 3',
                'data' => [
                    $ward_report->Dt_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
                    $ward_report->Dt_nu_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
                    $ward_report->Dt_nu_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3
                ]
            ],
            [
                'name' => 'Ds mù chữ ở mức độ 2 chưa hoàn thành lớp 5',
                'data' => [
                    $ward_report->Ds_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
                    $ward_report->Ds_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
                    $ward_report->Ds_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5
                ]
            ],
            [
                'name' => 'Ds nữ mù chữ ở mức độ 2 chưa hoàn thành lớp 5',
                'data' => [
                    $ward_report->Ds_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
                    $ward_report->Ds_nu_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
                    $ward_report->Ds_nu_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5
                ]
            ],
            [
                'name' => 'Dt mù chữ ở mức độ 2 chưa hoàn thành lớp 5',
                'data' => [
                    $ward_report->Dt_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
                    $ward_report->Dt_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
                    $ward_report->Dt_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5
                ]
            ],
            [
                'name' => 'Dt nữ mù chữ ở mức độ 2 chưa hoàn thành lớp 5',
                'data' => [
                    $ward_report->Dt_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
                    $ward_report->Dt_nu_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
                    $ward_report->Dt_nu_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5
                ]
            ]
        ];

        return response()->json($seriesDataColumn);
    }


    public function chartWardDataCircle(Request $request){

        $wards = Auth::user()->getAttributes();
        $ward = $wards["ward_id"];
        $namDieuTra = $request->input('years');

        $ward_report = DB::selectOne(
            'SELECT * FROM wards_report WHERE ward_id = ? AND nam_dieu_tra = ?',
            [$ward, $namDieuTra]
        );


        if (!$ward_report) {
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
                ['name' => 'Giới tính nam', 'y' => $ward_report->gioi_tinh_nam],
                ['name' => 'Giới tính nữ', 'y' => $ward_report->gioi_tinh_nu]
            ],
            'total'  => $ward_report->tong_dan_so
        ]);
    }

    public function chartWardDataCircle_1(Request $request){

        $wards = Auth::user()->getAttributes();
        $ward = $wards["ward_id"];
        $namDieuTra = $request->input('years');

        $ward_report = DB::selectOne(
            'SELECT * FROM wards_report WHERE ward_id = ? AND nam_dieu_tra = ?',
            [$ward, $namDieuTra]
        );

        if (!$ward_report) {
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
                    $ward_report->dan_so_tu_15_den_25_tuoi - $ward_report->gioi_tinh_nu_tu_15_den_25_tuoi],
                ['name' => 'Giới tính nữ', 'y' => $ward_report->gioi_tinh_nu_tu_15_den_25_tuoi]
            ],
            'total_1'  => $ward_report->dan_so_tu_15_den_25_tuoi
        ]);
    }


    public function chartWardDataCircle_2(Request $request){

        $wards = Auth::user()->getAttributes();
        $ward = $wards["ward_id"];
        $namDieuTra = $request->input('years');

        $ward_report = DB::selectOne(
            'SELECT * FROM wards_report WHERE ward_id = ? AND nam_dieu_tra = ?',
            [$ward, $namDieuTra]
        );

        if (!$ward_report) {
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
                    $ward_report->dan_so_tu_15_den_35_tuoi - $ward_report->gioi_tinh_nu_tu_15_den_35_tuoi],
                ['name' => 'Giới tính nữ', 'y' => $ward_report->gioi_tinh_nu_tu_15_den_35_tuoi]
            ],
            'total_2'  => $ward_report->dan_so_tu_15_den_35_tuoi
        ]);
    }

    
    public function chartWardDataCircle_3(Request $request){

        $wards = Auth::user()->getAttributes();
        $ward = $wards["ward_id"];
        $namDieuTra = $request->input('years');

        $ward_report = DB::selectOne(
            'SELECT * FROM wards_report WHERE ward_id = ? AND nam_dieu_tra = ?',
            [$ward, $namDieuTra]
        );

        if (!$ward_report) {
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
                    $ward_report->dan_so_tu_15_den_60_tuoi - $ward_report->gioi_tinh_nu_tu_15_den_60_tuoi],
                ['name' => 'Giới tính nữ', 'y' => $ward_report->gioi_tinh_nu_tu_15_den_60_tuoi]
            ],
            'total_3'  => $ward_report->dan_so_tu_15_den_60_tuoi
        ]);
    }

}
