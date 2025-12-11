<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChartProvinceHomeController extends Controller
{
    public function chartProvinceDataColumnHome(Request $request)
    {

        $provinces = Auth::user()->getAttributes();
        $province = $provinces["province_id"];

        $namDieuTra = $request->input('year');

        $province_report = DB::selectOne('SELECT * FROM provinces_report WHERE nam_dieu_tra = ? AND province_id = ?', [
            $namDieuTra, $province]);

        $seriesProvinceDataColumnHome = [
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

        return response()->json($seriesProvinceDataColumnHome);
    }

    public function chartProvinceDataCircleHome(Request $request){

        $provinces = Auth::user()->getAttributes();
        $province = $provinces["province_id"];

        $namDieuTra = $request->input('year');

        $province_report = DB::selectOne('SELECT * FROM provinces_report WHERE nam_dieu_tra = ? AND province_id = ?', [$namDieuTra , $province]);


        $seriesProvinceDataCircleHome = [
            [
                'name' => 'Giới tính nam',
                'y' => $province_report->gioi_tinh_nam
            ],

            [
                'name' => 'Giới tính nữ',
                'y' => $province_report->gioi_tinh_nu
            ]
        ];

        return response()->json([
            'series_home' => $seriesProvinceDataCircleHome,
            'total_home'  => $province_report->tong_dan_so 
        ]);
    }

    public function getYearsProvinceColumnHome()
    {
        $years_column = DB::select('SELECT DISTINCT nam_dieu_tra FROM provinces_report ORDER BY nam_dieu_tra ASC');

        return response()->json($years_column);
    }

    public function getYearsProvinceCircleHome()
    {
        $years_circle = DB::select('SELECT DISTINCT nam_dieu_tra FROM provinces_report ORDER BY nam_dieu_tra ASC');

        return response()->json($years_circle);
    }

}
