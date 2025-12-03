<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <form action="{{ route('get.province') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tổng hợp dữ liệu </button>
                        </form>

                        <form action="{{ route('export.ward-report') }}" method="GET" enctype="multipart/form-data">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Xuất dữ liệu excel </button>
                        </form>
                    </div>

                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Pagination đặt trên đầu -->
                        <!-- <nav>
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous --}}

                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>

                                    <li class="page-item"><a class="page-link" href="">Previous</a></li>


                                {{-- Always show first 2 pages --}}

                                    <li class="">
                                        <a class="page-link" href=""></a>
                                    </li>


                                {{-- Ellipsis if currentPage > 4 --}}

                                    <a class="page-link goto-page" href="javascript:void(0)" data-position="left">...</a>

                                {{-- Show currentPage -1, currentPage, currentPage +1 --}}

                                    <li class="">
                                        <a class="page-link" href=""></a>
                                    </li>


                                {{-- Ellipsis if currentPage < lastPage - 3 --}}

                                    <a class="page-link goto-page" href="javascript:void(0)" data-position="right">...</a>


                                {{-- Always show last 2 pages --}}

                                    <li class="">
                                        <a class="page-link" href=""></a>
                                    </li>


                                {{-- Next --}}

                                    <li class="page-item"><a class="page-link" href="">Next</a></li>

                                    <li class="page-item disabled"><span class="page-link">Next</span></li>

                                <script>
                                document.querySelectorAll('.goto-page').forEach(e => {
                                    e.addEventListener('click', function () {
                                        let page = prompt("Nhập số trang muốn đến:");
                                        if (page) {
                                            // Lấy URL hiện tại
                                            let url = new URL(window.location.href);


                                            // Set lại param page
                                            url.searchParams.set('page', page);//<- mặc định là page trong URL

                                            // Chuyển đến URL mới
                                            window.location.href = url.toString();
                                        }
                                    });
                                });
                                </script>
                            </ul>
                        </nav> -->
                    </div>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-sm table-striped table-bordered align-middle text-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Tên phường</th>
                                    <th>Năm điều tra</th>
                                    <th>Tổng dân số</th>
                                    <th>Ds từ 15 đến 25 tuổi</th>
                                    <th>Ds từ 15 đến 35 tuổi</th>
                                    <th>Ds từ 15 đến 60 tuổi</th>
                                    <th>Giới tính nam</th>
                                    <th>Giới tính nữ</th>
                                    <th>Gt nữ từ 15 đến 25 tuổi</th>
                                    <th>Gt nữ từ 15 đến 35 tuổi</th>
                                    <th>Gt nữ từ 15 đến 60 tuổi</th>
                                    <th>Dân tộc</th>
                                    <th>Ds từ 15 đến 25 tuổi</th>
                                    <th>Ds từ 15 đến 35 tuổi</th>
                                    <th>Ds từ 15 đến 60 tuổi</th>
                                    <th>Nữ dân tộc</th>
                                    <th>Dt nữ từ 15 đến 25 tuổi</th>
                                    <th>Dt nữ từ 15 đến 35 tuổi</th>
                                    <th>Dt nữ từ 15 đến 60 tuổi</th>
                                    <th>Ds mù chữ md 1 ở độ tuổi từ 15 đến 25 cht lớp 3</th>
                                    <th>Ds mù chữ md 1 ở độ tuổi từ 15 đến 35 cht lớp 3</th>
                                    <th>Ds mù chữ md 1 ở độ tuổi từ 15 đến 60 cht lớp 3</th>

                                    <th>Ds nữ mù chữ md 1 ở độ tuổi từ 15 đến 25 cht lớp 3</th>
                                    <th>Ds nữ mù chữ md 1 ở độ tuổi từ 15 đến 35 cht lớp 3</th>
                                    <th>Ds nữ mù chữ md 1 ở độ tuổi từ 15 đến 60 cht lớp 3</th>

                                    <th>Dt mù chữ md 1 ở độ tuổi từ 15 đến 25 cht lớp 3</th>
                                    <th>Dt mù chữ md 1 ở độ tuổi từ 15 đến 35 cht lớp 3</th>
                                    <th>Dt mù chữ md 1 ở độ tuổi từ 15 đến 60 cht lớp 3</th>

                                    <th>Dt nữ mù chữ md 1 ở độ tuổi từ 15 đến 25 cht lớp 3</th>
                                    <th>Dt nữ mù chữ md 1 ở độ tuổi từ 15 đến 35 cht lớp 3</th>
                                    <th>Dt nữ mù chữ md 1 ở độ tuổi từ 15 đến 60 cht lớp 3</th>



                                    <th>Ds mù chữ md 2 ở độ tuổi từ 15 đến 25 cht lớp 5</th>
                                    <th>Ds mù chữ md 2 ở độ tuổi từ 15 đến 35 cht lớp 5</th>
                                    <th>Ds mù chữ md 2 ở độ tuổi từ 15 đến 60 cht lớp 5</th>

                                    <th>Ds nữ mù chữ md 2 ở độ tuổi từ 15 đến 25 cht lớp 5</th>
                                    <th>Ds nữ mù chữ md 2 ở độ tuổi từ 15 đến 35 cht lớp 5</th>
                                    <th>Ds nữ mù chữ md 2 ở độ tuổi từ 15 đến 60 cht lớp 5</th>

                                    <th>Dt mù chữ md 2 ở độ tuổi từ 15 đến 25 cht lớp 5</th>
                                    <th>Dt mù chữ md 2 ở độ tuổi từ 15 đến 35 cht lớp 5</th>
                                    <th>Dt mù chữ md 2 ở độ tuổi từ 15 đến 60 cht lớp 5</th>

                                    <th>Dt nữ mù chữ md 2 ở độ tuổi từ 15 đến 25 cht lớp 5</th>
                                    <th>Dt nữ mù chữ md 2 ở độ tuổi từ 15 đến 35 cht lớp 5</th>
                                    <th>Dt nữ mù chữ md 2 ở độ tuổi từ 15 đến 60 cht lớp 5</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ward_reports as $index => $ward_report)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$ward_report->ten_phuong}}</td>
                                    <td>{{$ward_report->nam_dieu_tra}}</td>
                                    <td>{{$ward_report->tong_dan_so}}</td>
                                    <td>{{$ward_report->dan_so_tu_15_den_25_tuoi}}</td>
                                    <td>{{$ward_report->dan_so_tu_15_den_35_tuoi}}</td>
                                    <td>{{$ward_report->dan_so_tu_15_den_60_tuoi}}</td>
                                    <td>{{$ward_report->gioi_tinh_nam}}</td>
                                    <td>{{$ward_report->gioi_tinh_nu}}</td>
                                    <td>{{$ward_report->gioi_tinh_nu_tu_15_den_25_tuoi}}</td>
                                    <td>{{$ward_report->gioi_tinh_nu_tu_15_den_35_tuoi}}</td>
                                    <td>{{$ward_report->gioi_tinh_nu_tu_15_den_60_tuoi}}</td>
                                    <td>{{$ward_report->dan_toc}}</td>
                                    <td>{{$ward_report->dan_toc_tu_15_den_25_tuoi}}</td>
                                    <td>{{$ward_report->dan_toc_tu_15_den_35_tuoi}}</td>
                                    <td>{{$ward_report->dan_toc_tu_15_den_60_tuoi}}</td>
                                    <td>{{$ward_report->nu_dan_toc}}</td>
                                    <td>{{$ward_report->nu_dan_toc_tu_15_den_25_tuoi}}</td>
                                    <td>{{$ward_report->nu_dan_toc_tu_15_den_35_tuoi}}</td>
                                    <td>{{$ward_report->nu_dan_toc_tu_15_den_60_tuoi}}</td>

                                    <th>{{$ward_report->Ds_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3}}</th>
                                    <th>{{$ward_report->Ds_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3}}</th>
                                    <th>{{$ward_report->Ds_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3}}</th>

                                    <th>{{$ward_report->Ds_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3}}</th>
                                    <th>{{$ward_report->Ds_nu_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3}}</th>
                                    <th>{{$ward_report->Ds_nu_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3}}</th>

                                    <th>{{$ward_report->Dt_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3}}</th>
                                    <th>{{$ward_report->Dt_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3}}</th>
                                    <th>{{$ward_report->Dt_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3}}</th>

                                    <th>{{$ward_report->Dt_nu_mu_chu_md_1_do_tuoi_15_den_25_cht_lop_3}}</th>
                                    <th>{{$ward_report->Dt_nu_mu_chu_md_1_do_tuoi_15_den_35_cht_lop_3}}</th>
                                    <th>{{$ward_report->Dt_nu_mu_chu_md_1_do_tuoi_15_den_60_cht_lop_3}}</th>

                                    

                                    <th>{{$ward_report->Ds_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5}}</th>
                                    <th>{{$ward_report->Ds_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5}}</th>
                                    <th>{{$ward_report->Ds_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5}}</th>

                                    <th>{{$ward_report->Ds_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5}}</th>
                                    <th>{{$ward_report->Ds_nu_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5}}</th>
                                    <th>{{$ward_report->Ds_nu_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5}}</th>

                                    <th>{{$ward_report->Dt_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5}}</th>
                                    <th>{{$ward_report->Dt_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5}}</th>
                                    <th>{{$ward_report->Dt_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5}}</th>

                                    <th>{{$ward_report->Dt_nu_mu_chu_md_2_do_tuoi_15_den_25_cht_lop_5}}</th>
                                    <th>{{$ward_report->Dt_nu_mu_chu_md_2_do_tuoi_15_den_35_cht_lop_5}}</th>
                                    <th>{{$ward_report->Dt_nu_mu_chu_md_2_do_tuoi_15_den_60_cht_lop_5}}</th>
                                    
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- <a href="" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a> -->
                                            <form action="{{ route('delete.ward-report', $ward_report->ward_report_id) }}"
                                                method="POST" class="m-0 ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Tên phường</th>
                                    <th>Năm điều tra</th>
                                    <th>Tổng dân số</th>
                                    <th>Ds từ 15 đến 25 tuổi</th>
                                    <th>Ds từ 15 đến 35 tuổi</th>
                                    <th>Ds từ 15 đến 60 tuổi</th>
                                    <th>Giới tính nam</th>
                                    <th>Giới tính nữ</th>
                                    <th>Gt nữ từ 15 đến 25 tuổi</th>
                                    <th>Gt nữ từ 15 đến 35 tuổi</th>
                                    <th>Gt nữ từ 15 đến 60 tuổi</th>
                                    <th>Dân tộc</th>
                                    <th>Ds từ 15 đến 25 tuổi</th>
                                    <th>Ds từ 15 đến 35 tuổi</th>
                                    <th>Ds từ 15 đến 60 tuổi</th>
                                    <th>Nữ dân tộc</th>
                                    <th>Dt nữ từ 15 đến 25 tuổi</th>
                                    <th>Dt nữ từ 15 đến 35 tuổi</th>
                                    <th>Dt nữ từ 15 đến 60 tuổi</th>

                                    <th>Ds mù chữ md 1 ở độ tuổi từ 15 đến 25 cht lớp 3</th>
                                    <th>Ds mù chữ md 1 ở độ tuổi từ 15 đến 35 cht lớp 3</th>
                                    <th>Ds mù chữ md 1 ở độ tuổi từ 15 đến 60 cht lớp 3</th>

                                    <th>Ds nữ mù chữ md 1 ở độ tuổi từ 15 đến 25 cht lớp 3</th>
                                    <th>Ds nữ mù chữ md 1 ở độ tuổi từ 15 đến 35 cht lớp 3</th>
                                    <th>Ds nữ mù chữ md 1 ở độ tuổi từ 15 đến 60 cht lớp 3</th>

                                    <th>Dt mù chữ md 1 ở độ tuổi từ 15 đến 25 cht lớp 3</th>
                                    <th>Dt mù chữ md 1 ở độ tuổi từ 15 đến 35 cht lớp 3</th>
                                    <th>Dt mù chữ md 1 ở độ tuổi từ 15 đến 60 cht lớp 3</th>

                                    <th>Dt nữ mù chữ md 1 ở độ tuổi từ 15 đến 25 cht lớp 3</th>
                                    <th>Dt nữ mù chữ md 1 ở độ tuổi từ 15 đến 35 cht lớp 3</th>
                                    <th>Dt nữ mù chữ md 1 ở độ tuổi từ 15 đến 60 cht lớp 3</th>


                                    <th>Ds mù chữ md 2 ở độ tuổi từ 15 đến 25 cht lớp 5</th>
                                    <th>Ds mù chữ md 2 ở độ tuổi từ 15 đến 35 cht lớp 5</th>
                                    <th>Ds mù chữ md 2 ở độ tuổi từ 15 đến 60 cht lớp 5</th>

                                    <th>Ds nữ mù chữ md 2 ở độ tuổi từ 15 đến 25 cht lớp 5</th>
                                    <th>Ds nữ mù chữ md 2 ở độ tuổi từ 15 đến 35 cht lớp 5</th>
                                    <th>Ds nữ mù chữ md 2 ở độ tuổi từ 15 đến 60 cht lớp 5</th>

                                    <th>Dt mù chữ md 2 ở độ tuổi từ 15 đến 25 cht lớp 5</th>
                                    <th>Dt mù chữ md 2 ở độ tuổi từ 15 đến 35 cht lớp 5</th>
                                    <th>Dt mù chữ md 2 ở độ tuổi từ 15 đến 60 cht lớp 5</th>

                                    <th>Dt nữ mù chữ md 2 ở độ tuổi từ 15 đến 25 cht lớp 5</th>
                                    <th>Dt nữ mù chữ md 2 ở độ tuổi từ 15 đến 35 cht lớp 5</th>
                                    <th>Dt nữ mù chữ md 2 ở độ tuổi từ 15 đến 60 cht lớp 5</th>

                                    <th class="col-actions">Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Pagination dưới bảng -->
                    <!-- <div class="d-flex justify-content-end mt-2">
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
    {{-- jquery.autocomplete.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.10/jquery.autocomplete.min.js"></script>
    {{-- quick defined --}}
    <script>
        function hideSuccessAlert() {
            // your custom javascript
            const alert = document.getElementById('success-alert');
            if (alert){
                alert.style.display = 'none';
            }
        }
        function initPageScripts() {
        // Đợi 3 giây rồi ẩn alert nếu có
        setTimeout(hideSuccessAlert, 3000);
        }
        // Khi DOM đã sẵn sàng
        document.addEventListener('DOMContentLoaded', initPageScripts);


        
        function hideErrorAlert() {
            // your custom javascript
            const alert = document.getElementById('error-alert');
            if (alert){
                alert.style.display = 'none';
            }
        }
        function initPageScripts() {
        // Đợi 3 giây rồi ẩn alert nếu có
        setTimeout(hideErrorAlert, 3000);
        }
        // Khi DOM đã sẵn sàng
        document.addEventListener('DOMContentLoaded', initPageScripts);


        // Ẩn thông báo lỗi của một input cụ thể
        function hideValidationError(event) {
            const formGroup = event.target.closest('.form-group');
            if (formGroup) {
                const errorSpan = formGroup.querySelector('span.text-danger');
                if (errorSpan) {
                    errorSpan.style.display = 'none';
                }
            }
        }

        function setupValidationClearEvents() {
            const fields = document.querySelectorAll('input, select');

            fields.forEach(function (field) {
                // Ẩn lỗi khi input thay đổi hoặc focus
                if (field.tagName.toLowerCase() === 'select') {
                    field.addEventListener('change', hideValidationError);
                    field.addEventListener('focus', hideValidationError);  // thêm focus
                } else {
                    field.addEventListener('input', hideValidationError);
                    field.addEventListener('focus', hideValidationError);  // thêm focus
                }
            });
        }
        document.addEventListener('DOMContentLoaded', setupValidationClearEvents);


        function setupColorHexSync(colorInputId, hexInputId) {
            const colorInput = document.getElementById(colorInputId);
            const colorHexInput = document.getElementById(hexInputId);
            if (!colorInput || !colorHexInput) return; // nếu không tìm thấy input thì thoát

            colorInput.addEventListener('input', function() {
                colorHexInput.value = this.value.toUpperCase();
            });
        }

        // Khi DOM load xong, gọi hàm với id của 2 input bạn muốn đồng bộ
        document.addEventListener('DOMContentLoaded', function() {
            setupColorHexSync('color', 'colorHex');
        });;

        // document.addEventListener('DOMContentLoaded', function () {
        //     setupValidationClearEvents();
        //     initCurrencyInputValidation();
        // });

    </script>
@stop