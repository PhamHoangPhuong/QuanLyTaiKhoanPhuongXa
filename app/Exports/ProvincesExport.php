<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class ProvincesExport implements WithHeadings, FromCollection
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
        provinces.ten_tinh,
        provinces_report.nam_dieu_tra,
        provinces_report.tong_dan_so,
        provinces_report.dan_so_tu_15_den_25_tuoi,
        provinces_report.dan_so_tu_15_den_35_tuoi,
        provinces_report.dan_so_tu_15_den_60_tuoi,
        provinces_report.gioi_tinh_nam,
        provinces_report.gioi_tinh_nu,
        provinces_report.gioi_tinh_nu_tu_15_den_25_tuoi,
        provinces_report.gioi_tinh_nu_tu_15_den_35_tuoi,
        provinces_report.gioi_tinh_nu_tu_15_den_60_tuoi,
        provinces_report.dan_toc,
        provinces_report.dan_toc_tu_15_den_25_tuoi,
        provinces_report.dan_toc_tu_15_den_35_tuoi,
        provinces_report.dan_toc_tu_15_den_60_tuoi,
        provinces_report.nu_dan_toc,
        provinces_report.nu_dan_toc_tu_15_den_25_tuoi,
        provinces_report.nu_dan_toc_tu_15_den_35_tuoi,
        provinces_report.nu_dan_toc_tu_15_den_60_tuoi,

        provinces_report.Ds_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
        provinces_report.Ds_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
        provinces_report.Ds_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3,


        provinces_report.Ds_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
        provinces_report.Ds_nu_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
        provinces_report.Ds_nu_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3,


        provinces_report.Dt_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
        provinces_report.Dt_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
        provinces_report.Dt_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3,

        
        provinces_report.Dt_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
        provinces_report.Dt_nu_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3,
        provinces_report.Dt_nu_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3,


        provinces_report.Ds_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
        provinces_report.Ds_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
        provinces_report.Ds_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5,


        provinces_report.Ds_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
        provinces_report.Ds_nu_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
        provinces_report.Ds_nu_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5,

        provinces_report.Dt_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
        provinces_report.Dt_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
        provinces_report.Dt_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5,

        
        provinces_report.Dt_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5,
        provinces_report.Dt_nu_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5,
        provinces_report.Dt_nu_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5
        
        
        FROM provinces_report
        JOIN provinces ON provinces_report.province_id = provinces.province_id
        WHERE provinces_report.province_id = ?
        
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
