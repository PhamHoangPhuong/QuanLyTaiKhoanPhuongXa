@extends('layouts.master')

@section('title', 'App - Top Page')

@section('style-libraries')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
@stop

@section('styles')
    {{-- custom css item suggest search --}}
    <style>
        .autocomplete-group { padding: 2px 5px; }
    </style>
@stop

@section('breadcrumb')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chart Index</h1>

        <select id="yearSelect" class="form-select" style="width: 200px;"></select>
    </div>
@stop

@section('content')
    @include('partial.chart.charts-province')
@stop

@section('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
    {{-- jquery.autocomplete.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.10/jquery.autocomplete.min.js"></script>
    {{-- quick defined --}}
    <script>
        $(function () {
            // your custom javascript
        });
    </script>


    {{-- jquery province --}}
    <script>
        $(document).ready(function () {

            $.ajax({
                url: "/api/get-years-province",
                type: "GET",
                dataType: "json",
                success: function (res) {
                    console.log(res)
                    let select = $("#yearSelect");

                    select.append('<option value="">Chọn năm điều tra</option>');

                    $.each(res, function(index, item) {
                        select.append(
                            `<option value="${item.nam_dieu_tra}">${item.nam_dieu_tra}</option>`
                        );
                    });


                    if (res.length > 0) {
                        select.val(res[0].nam_dieu_tra).trigger('change');
                    }
                },
                error: function (err) {
                    console.error("Lỗi load năm:", err);
                }
            });

        });
    </script>

@stop