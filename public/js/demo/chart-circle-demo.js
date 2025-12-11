$(document).ready(function () {

    if (window.ROLE_ID == 1 || window.ROLE_ID == 2) {

        const headerCircle = $('#container-circle-home')
            .closest('.card')
            .find('.card-header');

        const selectCircle = $('<select class="form-control" id="yearCircleSelect" style="width:110px; margin-left:10px;"></select>');

        let ajaxYearUrl = '';
        if (window.ROLE_ID == 1) {
            ajaxYearUrl = '/years-ward-circle-home'; 
        } else if (window.ROLE_ID == 2) {
            ajaxYearUrl = '/years-province-circle-home'; 
        }
        

        $.ajax({
            url: ajaxYearUrl,
            type: 'GET',
            dataType: 'json',
            success: function($years_circle) {
                $years_circle.forEach(function(item) {
                    const option = $('<option></option>')
                        .attr('value', item.nam_dieu_tra)
                        .text(item.nam_dieu_tra);


                    selectCircle.append(option);
                });


                loadChartCircleHome();
            },
            error: function(err) {
                console.error('Không lấy được danh sách năm:', err);
            }
        });

        headerCircle.append(selectCircle);

        let ajaxUrl = '';
        if (window.ROLE_ID == 1) {
            ajaxUrl = '/chart-ward-data-circle-home'; 
        } else if (window.ROLE_ID == 2) {
            ajaxUrl = '/chart-province-data-circle-home'; 
        }

        function loadChartCircleHome() {
            $.ajax({
                url: ajaxUrl,
                type: 'GET',
                data: { year: $('#yearCircleSelect').val() },
                dataType: 'json',
                success: function (res) {
                    console.log(res)
                    Highcharts.chart('container-circle-home', {
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
                                                `<strong>${res.total_home}</strong>`
                                            )
                                                .css({
                                                    color: 'var(--highcharts-neutral-color-100, #000)',
                                                    textAnchor: 'middle'
                                                })
                                                .add();
                                    }

                                    const x = series.center[0] + chart.plotLeft,
                                        y = series.center[1] + chart.plotTop -
                                        (customLabel.attr('height') / 2);

                                    customLabel.attr({ x, y });
                                    customLabel.css({ fontSize: `${series.center[2] / 12}px` });
                                }
                            }
                        },
                        title: { text: window.ROLE_ID == 1 
                                    ? 'Tổng dân số phường năm: ' + $('#yearCircleSelect').val()
                                    : 'Tổng dân số tỉnh năm: ' + $('#yearCircleSelect').val() },
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
                                    format: '{point.percentage:.0f}%',
                                    style: { fontSize: '0.9em' }
                                }]
                            }
                        },
                        series: [{
                            name: 'Registrations',
                            colorByPoint: true,
                            innerSize: '75%',
                            data: res.series_home
                        }]
                    });

                },
                error: function (err) {
                    console.error('Lỗi khi đổi năm circle:', err);
                }
            });
        }
        $(document).on('change', '#yearCircleSelect', function() {
            loadChartCircleHome();
        });
    }
});

