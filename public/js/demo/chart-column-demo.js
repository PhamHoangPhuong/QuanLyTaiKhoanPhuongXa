$(document).ready(function() {

    if (window.ROLE_ID == 1 || window.ROLE_ID == 2) {

        const headerColumn = $('#container-column-home')
            .closest('.card')
            .find('.card-header');

        const selectColumn = $('<select class="form-control" id="yearColumnSelect" style="width:110px; margin-left:10px;">'
            + '<option value="2023">2023</option>'
            + '<option value="2024" selected>2024</option>'
            + '<option value="2025">2025</option>'
            + '</select>');

        headerColumn.append(selectColumn);

        let ajaxUrl = '';
        if (window.ROLE_ID == 1) {
            ajaxUrl = '/chart-ward-data-column-home'; 
        } else if (window.ROLE_ID == 2) {
            ajaxUrl = '/chart-province-data-column-home'; 
        }

        $.ajax({
            url: ajaxUrl,
            type: 'GET',
            dataType: 'json',
            success: function(seriesDataColumnHome) {
                Highcharts.chart('container-column-home', {
                    chart: { type: 'column' },
                    title: { 
                        text: window.ROLE_ID == 1 
                            ? 'Tổng hợp tình hình số liệu công tác chống mù chữ - Ward' 
                            : 'Tổng hợp tình hình số liệu công tác chống mù chữ - Province'
                    },
                    xAxis: {
                        categories: window.ROLE_ID == 1
                            ? ['Ds mù chữ từ 15 đến 25 tuổi', 'Ds mù chữ từ 15 đến 35 tuổi', 'Ds mù chữ từ 15 đến 60 tuổi']
                            : ['Số liệu tỉnh 1', 'Số liệu tỉnh 2', 'Số liệu tỉnh 3'], // ví dụ Province
                        crosshair: true,
                        accessibility: { description: 'Categories' }
                    },
                    yAxis: {
                        min: 0,
                        title: { text: '1000 metric tons (MT)' }
                    },
                    tooltip: { valueSuffix: ' (1000 MT)' },
                    plotOptions: { column: { pointPadding: 0.2, borderWidth: 0 } },
                    series: seriesDataColumnHome
                });
            },
            error: function(err) {
                console.error('Lỗi khi lấy dữ liệu column:', err);
            }
        });
    } else {
        console.log('Admin không xem chart này');
    }
});

