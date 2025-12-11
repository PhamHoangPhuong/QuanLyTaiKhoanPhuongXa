<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChartWardHomeController extends Controller
{
    public function chartWardDataColumnHome(Request $request)
    {

        $provinces = Auth::user()->getAttributes();
        $province = $provinces["province_id"];

        $namDieuTra = $request->input('year');

        $ward_report = DB::selectOne('SELECT * FROM wards_report WHERE nam_dieu_tra = ? AND province_id = ?', [
            $namDieuTra, $province]);

        $seriesDataColumnHome = [
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

        return response()->json($seriesDataColumnHome);
    }

    public function chartWardDataCircleHome(Request $request){

        $wards = Auth::user()->getAttributes();
        $ward = $wards["ward_id"];

        $namDieuTra = $request->input('year');

        $ward_report = DB::selectOne('SELECT * FROM wards_report WHERE nam_dieu_tra = ? AND ward_id = ?', [$namDieuTra , $ward]);


        $seriesDataCircleHome = [
            [
                'name' => 'Giới tính nam',
                'y' => $ward_report->gioi_tinh_nam
            ],

            [
                'name' => 'Giới tính nữ',
                'y' => $ward_report->gioi_tinh_nu
            ]
        ];

        return response()->json([
            'series_home' => $seriesDataCircleHome,
            'total_home'  => $ward_report->tong_dan_so 
        ]);
    }

    public function getYearsWardColumnHome()
    {
        $years_column = DB::select('SELECT DISTINCT nam_dieu_tra FROM wards_report ORDER BY nam_dieu_tra ASC');

        return response()->json($years_column);
    }

    public function getYearsWardCircleHome()
    {
        $years_circle = DB::select('SELECT DISTINCT nam_dieu_tra FROM wards_report ORDER BY nam_dieu_tra ASC');

        return response()->json($years_circle);
    }

}
