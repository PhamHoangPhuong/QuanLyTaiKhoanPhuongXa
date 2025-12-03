<html>
<header>
    <title>test biểu đồ</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <style>
        body {
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                "Apple Color Emoji",
                "Segoe UI Emoji",
                "Segoe UI Symbol",
                sans-serif;
            background: var(--highcharts-background-color);
            color: var(--highcharts-neutral-color-100);
        }

        .highcharts-figure,
        .highcharts-data-table table {
            margin: 1em auto;
        }

        #container {
            height: 400px;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid var(--highcharts-neutral-color-10, #e6e6e6);
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: var(--highcharts-neutral-color-60, #666);
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tbody tr:nth-child(even) {
            background: var(--highcharts-neutral-color-3, #f7f7f7);
        }

        .highcharts-description {
            margin: 0.3rem 10px;
        }
    </style>
</header>

<body>
    <div class="card shadow-sm">
        <div class="card-body">
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
            <script>
                Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Tổng hợp tình hình số liệu công tác chống mù chữ'
                    },
                    xAxis: {
                        categories: ['Ds mù chữ từ 15 đến 25 tuổi', 'Ds mù chữ từ 15 đến 35 tuổi'],
                        crosshair: true,
                        accessibility: {
                            description: 'Countries'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '1000 metric tons (MT)'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' (1000 MT)'
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [
                        {
                            name: 'Ds mù chữ ở mức độ 1 độ tuổi 15 đến 25 tuổi chưa hoàn thành lớp 3',
                            data: [{{ 
                                $ward_report->Ds_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3,
                            }}]
                        },
                        {
                            name: 'Ds nữ mù chữ ở mức độ 1 độ tuổi 15 đến 25 tuổi chưa hoàn thành lớp 3',
                            data: [{{ 
                                $ward_report->Ds_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3, 

                            }}]
                        },
                        {
                            name: 'Dt mù chữ ở mức độ 1 độ tuổi 15 đến 25 tuổi chưa hoàn thành lớp 3',
                            data: [{{ 
                                $ward_report->Dt_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3, 

                            }}]
                        },
                        {
                            name: 'Dt nữ mù chữ ở mức độ 1 độ tuổi 15 đến 25 tuổi chưa hoàn thành lớp 3',
                            data: [{{ 
                                $ward_report->Dt_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3, 

                            }}]
                        },



                        {
                            name: 'Ds mù chữ ở mức độ 2 độ tuổi 15 đến 25 tuổi chưa hoàn thành lớp 5',
                            data: [{{ 
                                $ward_report->Ds_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5, 

                            }}]
                        },
                        {
                            name: 'Ds nữ mù chữ ở mức độ 2 độ tuổi 15 đến 25 tuổi chưa hoàn thành lớp 5',
                            data: [{{ 
                                $ward_report->Ds_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5, 

                            }}]
                        },
                        {
                            name: 'Dt mù chữ ở mức độ 2 độ tuổi 15 đến 25 tuổi chưa hoàn thành lớp 5',
                            data: [{{ 
                                $ward_report->Dt_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5, 

                            }}]
                        },
                        {
                            name: 'Dt nữ mù chữ ở mức độ 2 độ tuổi 15 đến 25 tuổi chưa hoàn thành lớp 5',
                            data: [{{ 
                                $ward_report->Dt_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5, 

                            }}]
                        },
                    ]
                });
            </script>
        </div>
    </div>
</body>

</html>