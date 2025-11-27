<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WardsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $province_id;

	public function __construct($province_id)
	{
        $this->province_id = $province_id;
	}

    public function collection()
    {
        $data = DB::select("
            SELECT 
            wards.ten_phuong,
            wards_report.nam_dieu_tra,
            wards_report.tong_dan_so,
            wards_report.dan_so_tu_15_den_25_tuoi,
            wards_report.dan_so_tu_15_den_35_tuoi,
            wards_report.dan_so_tu_15_den_60_tuoi,
            wards_report.gioi_tinh_nam,
            wards_report.gioi_tinh_nu,
            wards_report.gioi_tinh_nu_tu_15_den_25_tuoi,
            wards_report.gioi_tinh_nu_tu_15_den_35_tuoi,
            wards_report.gioi_tinh_nu_tu_15_den_60_tuoi,
            wards_report.dan_toc,
            wards_report.dan_toc_tu_15_den_25_tuoi,
            wards_report.dan_toc_tu_15_den_35_tuoi,
            wards_report.dan_toc_tu_15_den_60_tuoi,
            wards_report.nu_dan_toc,
            wards_report.nu_dan_toc_tu_15_den_25_tuoi,
            wards_report.nu_dan_toc_tu_15_den_35_tuoi,
            wards_report.nu_dan_toc_tu_15_den_60_tuoi,

            wards_report.Ds_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
            wards_report.Ds_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
            wards_report.Ds_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3,


            wards_report.Ds_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
            wards_report.Ds_nu_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
            wards_report.Ds_nu_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3,


            wards_report.Dt_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
            wards_report.Dt_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
            wards_report.Dt_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3,

            
            wards_report.Dt_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
            wards_report.Dt_nu_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
            wards_report.Dt_nu_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3,


            wards_report.Ds_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
            wards_report.Ds_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
            wards_report.Ds_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5,


            wards_report.Ds_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
            wards_report.Ds_nu_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
            wards_report.Ds_nu_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5,

            wards_report.Dt_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
            wards_report.Dt_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
            wards_report.Dt_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5,

            
            wards_report.Dt_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
            wards_report.Dt_nu_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
            wards_report.Dt_nu_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5


            FROM wards_report
            JOIN wards ON wards_report.ward_id = wards.ward_id
            WHERE wards_report.province_id = ?
        ", [$this->province_id]);

        $collection = collect($data)->map(function ($item, $index) {
            return array_merge(
                ['stt' => $index + 1],  
                (array) $item
            );
        });

        return $collection;
    }

    public function headings(): array
    {
        return [
            "Stt",
            "Tên phường",
            "Năm điều tra",
            "Tổng dân số",

            "Dân số từ 15 đến 25 tuổi",
            "Dân số từ 15 đến 35 tuổi",
            "Dân số từ 15 đến 60 tuổi",

            "Giới tính nam",
            "Giới tính nữ",

            "Nữ từ 15 đến 25 tuổi",
            "Nữ từ 15 đến 35 tuổi",
            "Nữ từ 15 đến 60 tuổi",

            "Dân tộc",
            "Dân tộc từ 15 đến 25 tuổi",
            "Dân tộc từ 15 đến 35 tuổi",
            "Dân tộc từ 15 đến 60 tuổi",

            "Nữ dân tộc",
            "Nữ dân tộc từ 15 đến 25 tuổi",
            "Nữ dân tộc từ 15 đến 35 tuổi",
            "Nữ dân tộc từ 15 đến 60 tuổi",

            "Dân số mù chữ mức độ 1 - 15 đến 25 tuổi (chưa học hết lớp 3)",
            "Dân số mù chữ mức độ 1 - 15 đến 35 tuổi (chưa học hết lớp 3)",
            "Dân số mù chữ mức độ 1 - 15 đến 60 tuổi (chưa học hết lớp 3)",

            "Nữ mù chữ mức độ 1 - 15 đến 25 tuổi (chưa học hết lớp 3)",
            "Nữ mù chữ mức độ 1 - 15 đến 35 tuổi (chưa học hết lớp 3)",
            "Nữ mù chữ mức độ 1 - 15 đến 60 tuổi (chưa học hết lớp 3)",

            "Dân tộc mù chữ mức độ 1 - 15 đến 25 tuổi (chưa học hết lớp 3)",
            "Dân tộc mù chữ mức độ 1 - 15 đến 35 tuổi (chưa học hết lớp 3)",
            "Dân tộc mù chữ mức độ 1 - 15 đến 60 tuổi (chưa học hết lớp 3)",

            "Nữ dân tộc mù chữ mức độ 1 - 15 đến 25 tuổi (chưa học hết lớp 3)",
            "Nữ dân tộc mù chữ mức độ 1 - 15 đến 35 tuổi (chưa học hết lớp 3)",
            "Nữ dân tộc mù chữ mức độ 1 - 15 đến 60 tuổi (chưa học hết lớp 3)",

            "Dân số mù chữ mức độ 2 - 15 đến 25 tuổi (chưa học hết lớp 5)",
            "Dân số mù chữ mức độ 2 - 15 đến 35 tuổi (chưa học hết lớp 5)",
            "Dân số mù chữ mức độ 2 - 15 đến 60 tuổi (chưa học hết lớp 5)",

            "Nữ mù chữ mức độ 2 - 15 đến 25 tuổi (chưa học hết lớp 5)",
            "Nữ mù chữ mức độ 2 - 15 đến 35 tuổi (chưa học hết lớp 5)",
            "Nữ mù chữ mức độ 2 - 15 đến 60 tuổi (chưa học hết lớp 5)",

            "Dân tộc mù chữ mức độ 2 - 15 đến 25 tuổi (chưa học hết lớp 5)",
            "Dân tộc mù chữ mức độ 2 - 15 đến 35 tuổi (chưa học hết lớp 5)",
            "Dân tộc mù chữ mức độ 2 - 15 đến 60 tuổi (chưa học hết lớp 5)",

            "Nữ dân tộc mù chữ mức độ 2 - 15 đến 25 tuổi (chưa học hết lớp 5)",
            "Nữ dân tộc mù chữ mức độ 2 - 15 đến 35 tuổi (chưa học hết lớp 5)",
            "Nữ dân tộc mù chữ mức độ 2 - 15 đến 60 tuổi (chưa học hết lớp 5)",
        ];
    }
}
