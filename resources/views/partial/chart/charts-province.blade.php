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

                $(document).ready(function() {
                    $.ajax({
                        url: '/chart-province-data-column',
                        type: 'GET',
                        dataType: 'json',
                        success: function(seriesDataColumn) {
                            // console.log(seriesData);
                            Highcharts.chart('container-column', {
                                chart: { type: 'column' },
                                title: { text: 'Tổng hợp tình hình số liệu công tác chống mù chữ' },
                                xAxis: {
                                    categories: ['Ds mù chữ từ 15 đến 25 tuổi', 'Ds mù chữ từ 15 đến 35 tuổi', 'Ds mù chữ từ 15 đến 60 tuổi'],
                                    crosshair: true,
                                    accessibility: { description: 'Countries' }
                                },
                                yAxis: {
                                    min: 0,
                                    title: { text: 'Người' }
                                },
                                tooltip: { valueSuffix: ' Người' },
                                plotOptions: { column: { pointPadding: 0.2, borderWidth: 0 } },
                                series: seriesDataColumn
                            });
                        },
                        error: function(err) {
                            console.error('Lỗi khi lấy dữ liệu column:', err);
                        }
                    });
                });

                //2.--------------------------------- CHART PROVINCE DATA CIRCLE ---------------------------------

                $(document).ready(function(){
                    $.ajax({
                        url: 'chart-province-data-circle',
                        type: 'GET',
                        dataType: 'json',

                        success: function(res){
                            Highcharts.chart('container-circle', {
                                chart: {
                                    type: 'pie',
                                    custom: {},
                                    events: {
                                        render() {
                                            const chart = this,
                                                series = chart.series[0];
                                            let customLabel = chart.options.chart.custom.label;

                                            if (!customLabel) {
                                                customLabel = chart.options.chart.custom.label =
                                                    chart.renderer.label(
                                                        'Total<br/>' +
                                                        `<strong>${res.total}</strong>`
                                                    )
                                                        .css({
                                                            color:
                                                                'var(--highcharts-neutral-color-100, #000)',
                                                            textAnchor: 'middle'
                                                        })
                                                        .add();
                                            }

                                            const x = series.center[0] + chart.plotLeft,
                                                y = series.center[1] + chart.plotTop -
                                                (customLabel.attr('height') / 2);

                                            customLabel.attr({
                                                x,
                                                y
                                            });
                                            // Set font size based on chart diameter
                                            customLabel.css({
                                                fontSize: `${series.center[2] / 12}px`
                                            });
                                        }
                                    }
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                title: {
                                    text: 'Tổng dân số'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                                },
                                legend: {
                                    enabled: false
                                },
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
                                            format: '{point.percentage:.0f}%',
                                            style: {
                                                fontSize: '0.9em'
                                            }
                                        }],
                                        showInLegend: true
                                    }
                                },
                                series: [{
                                    name: 'Registrations',
                                    colorByPoint: true,
                                    innerSize: '75%',
                                    data: res.series
                                }]
                            });
                        },
                        error: function(err) {
                            console.error('Lỗi khi lấy dữ liệu circle:', err);
                        }
                    });
                });

                //3.--------------------------------- CHART PROVINCE DATA CIRCLE_1 ---------------------------------

                $(document).ready(function(){
                    $.ajax({
                        url: 'chart-province-data-circle-1',
                        type: 'GET',
                        dataType: 'json',

                        success: function(res){
                            Highcharts.chart('container-circle_1', {
                                chart: {
                                    type: 'pie',
                                    custom: {},
                                    events: {
                                        render() {
                                            const chart = this,
                                                series = chart.series[0];
                                            let customLabel = chart.options.chart.custom.label;

                                            if (!customLabel) {
                                                customLabel = chart.options.chart.custom.label =
                                                    chart.renderer.label(
                                                        'Total<br/>' +
                                                        `<strong>${res.total_1}</strong>`
                                                    )
                                                        .css({
                                                            color:
                                                                'var(--highcharts-neutral-color-100, #000)',
                                                            textAnchor: 'middle'
                                                        })
                                                        .add();
                                            }

                                            const x = series.center[0] + chart.plotLeft,
                                                y = series.center[1] + chart.plotTop -
                                                (customLabel.attr('height') / 2);

                                            customLabel.attr({
                                                x,
                                                y
                                            });
                                            // Set font size based on chart diameter
                                            customLabel.css({
                                                fontSize: `${series.center[2] / 12}px`
                                            });
                                        }
                                    }
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                title: {
                                    text: 'Tổng dân số ở độ tuổi từ 15 đến 25'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                                },
                                legend: {
                                    enabled: false
                                },
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
                                            format: '{point.percentage:.0f}%',
                                            style: {
                                                fontSize: '0.9em'
                                            }
                                        }],
                                        showInLegend: true
                                    }
                                },
                                series: [{
                                    name: 'Registrations',
                                    colorByPoint: true,
                                    innerSize: '75%',
                                    data: res.series_1
                                }]
                            });
                        },
                        error: function(err) {
                            console.error('Lỗi khi lấy dữ liệu circle:', err);
                        }
                    });
                });

                //4.--------------------------------- CHART PROVINE DATA CIRCLE_2 ---------------------------------

                $(document).ready(function(){
                    $.ajax({
                        url: 'chart-province-data-circle-2',
                        type: 'GET',
                        dataType: 'json',

                        success: function(res){
                            Highcharts.chart('container-circle_2', {
                                chart: {
                                    type: 'pie',
                                    custom: {},
                                    events: {
                                        render() {
                                            const chart = this,
                                                series = chart.series[0];
                                            let customLabel = chart.options.chart.custom.label;

                                            if (!customLabel) {
                                                customLabel = chart.options.chart.custom.label =
                                                    chart.renderer.label(
                                                        'Total<br/>' +
                                                        `<strong>${res.total_2}</strong>`
                                                    )
                                                        .css({
                                                            color:
                                                                'var(--highcharts-neutral-color-100, #000)',
                                                            textAnchor: 'middle'
                                                        })
                                                        .add();
                                            }

                                            const x = series.center[0] + chart.plotLeft,
                                                y = series.center[1] + chart.plotTop -
                                                (customLabel.attr('height') / 2);

                                            customLabel.attr({
                                                x,
                                                y
                                            });
                                            // Set font size based on chart diameter
                                            customLabel.css({
                                                fontSize: `${series.center[2] / 12}px`
                                            });
                                        }
                                    }
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                title: {
                                    text: 'Tổng dân số ở độ tuổi từ 15 đến 35'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                                },
                                legend: {
                                    enabled: false
                                },
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
                                            format: '{point.percentage:.0f}%',
                                            style: {
                                                fontSize: '0.9em'
                                            }
                                        }],
                                        showInLegend: true
                                    }
                                },
                                series: [{
                                    name: 'Registrations',
                                    colorByPoint: true,
                                    innerSize: '75%',
                                    data: res.series_2
                                }]
                            });
                        },
                        error: function(err) {
                            console.error('Lỗi khi lấy dữ liệu circle:', err);
                        }
                    });
                });

                //5.--------------------------------- CHART PROVINCE DATA COLUMN_3 ---------------------------------

                $(document).ready(function(){
                    $.ajax({
                        url: 'chart-province-data-circle-3',
                        type: 'GET',
                        dataType: 'json',

                        success: function(res){
                            Highcharts.chart('container-circle_3', {
                                chart: {
                                    type: 'pie',
                                    custom: {},
                                    events: {
                                        render() {
                                            const chart = this,
                                                series = chart.series[0];
                                            let customLabel = chart.options.chart.custom.label;

                                            if (!customLabel) {
                                                customLabel = chart.options.chart.custom.label =
                                                    chart.renderer.label(
                                                        'Total<br/>' +
                                                        `<strong>${res.total_3}</strong>`
                                                    )
                                                        .css({
                                                            color:
                                                                'var(--highcharts-neutral-color-100, #000)',
                                                            textAnchor: 'middle'
                                                        })
                                                        .add();
                                            }

                                            const x = series.center[0] + chart.plotLeft,
                                                y = series.center[1] + chart.plotTop -
                                                (customLabel.attr('height') / 2);

                                            customLabel.attr({
                                                x,
                                                y
                                            });
                                            // Set font size based on chart diameter
                                            customLabel.css({
                                                fontSize: `${series.center[2] / 12}px`
                                            });
                                        }
                                    }
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                title: {
                                    text: 'Tổng dân số ở độ tuổi từ 15 đến 60'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                                },
                                legend: {
                                    enabled: false
                                },
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
                                            format: '{point.percentage:.0f}%',
                                            style: {
                                                fontSize: '0.9em'
                                            }
                                        }],
                                        showInLegend: true
                                    }
                                },
                                series: [{
                                    name: 'Registrations',
                                    colorByPoint: true,
                                    innerSize: '75%',
                                    data: res.series_3
                                }]
                            });
                        },
                        error: function(err) {
                            console.error('Lỗi khi lấy dữ liệu circle:', err);
                        }
                    });
                });

            </script>
        </div>
    </div>
</body>

</html>