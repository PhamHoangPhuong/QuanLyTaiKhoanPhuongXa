$(document).ready(function () {

    const headerCircle = $('#container-circle-home')
        .closest('.card')
        .find('.card-header');

    const selectCircle = $('<select class="form-control" id="yearCircleSelect" style="width:110px; margin-left:10px;">'
        + '<option value="2023">2023</option>'
        + '<option value="2024" selected>2024</option>'
        + '<option value="2025">2025</option>'
        + '</select>');

    headerCircle.append(selectCircle);

    $('#yearCircleSelect').on('change', function () {
        const year = $(this).val();

        $.ajax({
            url: 'chart-ward-data-circle-home?year=' + year,
            type: 'GET',
            dataType: 'json',
            success: function (res) {

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
                    title: { text: 'Tổng dân số - ' + year },
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

    });

});