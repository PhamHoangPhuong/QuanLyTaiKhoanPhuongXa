$(document).ready(function() {

    if (window.ROLE_ID == 1 || window.ROLE_ID == 2) {

        const headerColumn = $('#container-column-home')
            .closest('.card')
            .find('.card-header');

        const selectColumn = $('<select class="form-control" id="yearColumnSelect" style="width:110px; margin-left:10px;"></select>');

        let ajaxYearUrl = '';
        if (window.ROLE_ID == 1) {
            ajaxYearUrl = '/years-ward-column-home'; 
        } else if (window.ROLE_ID == 2) {
            ajaxYearUrl = '/years-province-column-home'; 
        }

        
        $.ajax({
            url: ajaxYearUrl,
            type: 'GET',
            dataType: 'json',
            success: function($years_column) {
                $years_column.forEach(function(item) {
                    const option = $('<option></option>')
                        .attr('value', item.nam_dieu_tra)
                        .text(item.nam_dieu_tra);


                    selectColumn.append(option);
                });


                loadChartColumnHome();
            },
            error: function(err) {
                console.error('Không lấy được danh sách năm:', err);
            }
        });

        headerColumn.append(selectColumn);

        let ajaxUrl = '';
        if (window.ROLE_ID == 1) {
            ajaxUrl = '/chart-ward-data-column-home'; 
        } else if (window.ROLE_ID == 2) {
            ajaxUrl = '/chart-province-data-column-home'; 
        }


        function loadChartColumnHome() {
            $.ajax({
                url: ajaxUrl,
                type: 'GET',
                data: { year: $('#yearColumnSelect').val() },
                dataType: 'json',
                success: function(seriesProvinceDataColumnHome) {
                    Highcharts.chart('container-column-home', {
                        chart: { type: 'column' },
                        title: { 
                            text: window.ROLE_ID == 1 
                                ? 'Tổng hợp tình hình số liệu công tác chống mù chữ phường năm: ' + $('#yearColumnSelect').val()
                                : 'Tổng hợp tình hình số liệu công tác chống mù chữ tỉnh năm: ' + $('#yearColumnSelect').val()
                        },
                        xAxis: {
                            categories: ['Ds mù chữ từ 15 đến 25 tuổi', 'Ds mù chữ từ 15 đến 35 tuổi', 'Ds mù chữ từ 15 đến 60 tuổi'],
                            crosshair: true,
                            accessibility: { description: 'Categories' }
                        },
                        yAxis: {
                            min: 0,
                            title: { text: '1000 metric tons (MT)' }
                        },
                        tooltip: { valueSuffix: ' (1000 MT)' },
                        plotOptions: { column: { pointPadding: 0.2, borderWidth: 0 } },
                        series: seriesProvinceDataColumnHome
                    });
                },
                error: function(err) {
                    console.error('Lỗi khi lấy dữ liệu column:', err);
                }
            });
        }


        $(document).on('change', '#yearColumnSelect', function() {
            loadChartColumnHome();
        });

    } else {
        console.log('Admin không xem chart này');
    }
});