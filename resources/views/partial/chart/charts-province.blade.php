<html>
<header>
    <title>test biểu đồ</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

        

        .highcharts-figure {
            display: flex;
            flex-wrap: wrap;      
            gap: 20px;
        }


        #container-column {
            width: 100%;
        }


        #container-circle,
        #container-circle_1,
        #container-circle_2,
        #container-circle_3 {
            width: calc(25% - 15px);   
            height: 400px !important;
            margin-top: 0 !important;
        }

    </style>
</header>


<body>
    <div class="card shadow-sm">
        <div class="card-body">
            <figure class="highcharts-figure">
                <div id="container-column"></div>

                <div id="container-circle" style="margin-top: 40px; height: 400px;"></div>
                <div id="container-circle_1" style="margin-top: 40px; height: 400px;"></div>
                <div id="container-circle_2" style="margin-top: 40px; height: 400px;"></div>
                <div id="container-circle_3" style="margin-top: 40px; height: 400px;"></div>
            </figure>

            <script>

                //1.--------------------------------- CHART PROVINCE DATA COLUMN ---------------------------------

                $(document).ready(function () {

                    function loadChartByYear(year) {
                        $.ajax({
                            url: '/chart-province-data-column',
                            type: 'GET',
                            data: { years: year },   
                            dataType: 'json',
                            success: function (seriesDataColumn) {
                                Highcharts.chart('container-column', {
                                    chart: { type: 'column' },
                                    title: { text: 'Tổng hợp tình hình số liệu công tác chống mù chữ năm ' + year },
                                    xAxis: {
                                        categories: [
                                            'Ds mù chữ từ 15 đến 25 tuổi',
                                            'Ds mù chữ từ 15 đến 35 tuổi',
                                            'Ds mù chữ từ 15 đến 60 tuổi'
                                        ],
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: { text: 'Người' }
                                    },
                                    tooltip: { valueSuffix: ' Người' },
                                    plotOptions: {
                                        column: { pointPadding: 0.2, borderWidth: 0 }
                                    },
                                    series: seriesDataColumn
                                });
                            },
                            error: function(err) {
                                console.error('Lỗi khi lấy dữ liệu column:', err);
                            }
                        });
                    }


                    // const defaultYear = $('#yearSelect').val();
                    // loadChartByYear(defaultYear);

                    $('#yearSelect').on('change', function () {
                        const year = $(this).val();
                        loadChartByYear(year);
                    });

                });

                //2.--------------------------------- CREATE CIRCLE CHART ---------------------------------

                function createCircleChart(container, res, total, series, population) {
                    Highcharts.chart(container, {
                        chart: {
                            type: 'pie',
                            custom: {},
                            events: {
                                render() {
                                    const chart = this,
                                        series = chart.series[0];

                                    let label = chart.options.chart.custom.label;

                                    if (!label) {
                                        label = chart.options.chart.custom.label =
                                            chart.renderer.label(
                                                'Total<br/><strong>' + res[total] + '</strong>'
                                            )
                                                .css({ color: '#000', textAnchor: 'middle' })
                                                .add();
                                    }

                                    const x = series.center[0] + chart.plotLeft,
                                        y = series.center[1] + chart.plotTop - (label.attr('height') / 2);

                                    label.attr({ x, y });
                                    label.css({ fontSize: (series.center[2] / 12) + 'px' });
                                }
                            }
                        },
                        title: { text: population },
                        tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>' },
                        legend: { enabled: false },
                        plotOptions: {
                            series: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                borderRadius: 8,
                                dataLabels: [{
                                    enabled: true,
                                    distance: 20,
                                    format: '{point.name}'
                                }, {
                                    enabled: true,
                                    distance: -15,
                                    format: '{point.percentage:.0f}%'
                                }]
                            }
                        },
                        series: [{
                            name: 'Registrations',
                            colorByPoint: true,
                            innerSize: '75%',
                            data: res[series]
                        }]
                    });
                }

                function loadCircleAjax(url, container, total, series, population, year) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        data: { years: year },

                        success: function (res) {
                            createCircleChart(container, res, total, series, population);
                        },
                        error: function (err) {
                            console.error('Lỗi circle:', err);
                        }
                    });
                }


                //3. --------------------------------- CHART PROVINCE DATA CIRCLE ---------------------------------
                $(document).ready(function () {
                    $('#yearSelect').on('change', function () {
                        loadCircleAjax('/chart-province-data-circle', 'container-circle', 'total', 'series', 'Tổng dân số', $(this).val());
                    });
                });


                //4. --------------------------------- CHART PROVINCE DATA CIRCLE_1 ---------------------------------
                $(document).ready(function () {
                    $('#yearSelect').on('change', function () {
                        loadCircleAjax('/chart-province-data-circle-1', 'container-circle_1', 'total_1', 'series_1', 'Tổng dân số từ 15 đến 25 tuổi', $(this).val());
                    });
                });


                //5. --------------------------------- CHART PROVINCE DATA CIRCLE_2 ---------------------------------
                $(document).ready(function () {
                    $('#yearSelect').on('change', function () {
                        loadCircleAjax('/chart-province-data-circle-2', 'container-circle_2', 'total_2', 'series_2', 'Tổng dân số từ 15 đến 35 tuổi', $(this).val());
                    });
                });


                //6. --------------------------------- CHART PROVINCE DATA CIRCLE_3 ---------------------------------
                $(document).ready(function () {
                    $('#yearSelect').on('change', function () {
                        loadCircleAjax('/chart-province-data-circle-3', 'container-circle_3', 'total_3', 'series_3', 'Tổng dân số từ 15 đến 60 tuổi', $(this).val());
                    });
                });

            </script>
        </div>
    </div>
</body>

</html>