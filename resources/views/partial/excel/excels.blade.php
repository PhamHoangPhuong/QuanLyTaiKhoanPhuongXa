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

                    <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
    
                        <div class="d-flex align-items-center">
                            @if(auth()->user()->role_id == 1)
                                <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center m-0 p-0">
                                    @csrf
                                    <input type="file" id="myFile" name="myFile" accept=".xlsx, .xls" style="display: none;">
                                    <label for="myFile" class="btn btn-success btn-sm me-2 mb-0">
                                        <i class="fas fa-plus"></i> Import Excel
                                    </label>
                                    <button type="submit" class="btn btn-success btn-sm mb-0">Save</button>
                                </form>
                            @endif

                            <form method="GET" class="d-flex align-items-center ms-3 mb-0">
                                <select name="nam_dieu_tra" class="form-control form-control-sm" style="width:150px;">
                                    <option value="">-- Chọn năm --</option>
                                    @foreach($years as $y)
                                        <option value="{{ $y->nam_dieu_tra }}" {{ request('nam_dieu_tra') == $y->nam_dieu_tra ? 'selected' : '' }}>
                                            {{ $y->nam_dieu_tra }}
                                        </option>
                                    @endforeach
                                </select>

                                @if(auth()->user()->role_id == 2)
                                    <select name="ten_phuong" class="form-control form-control-sm" style="width:150px;">
                                        <option value="">-- Chọn phường --</option>
                                        @foreach($wards as $w)
                                            <option value="{{ $w->ten_phuong }}" {{ request('ten_phuong') == $w->ten_phuong ? 'selected' : '' }}>
                                                {{ $w->ten_phuong }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                <button class="btn btn-info btn-sm ms-2 mb-0">Lọc</button>
                            </form>
                        </div>
                    
                        <!-- Pagination đặt trên đầu -->
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous --}}
                                @if ($paginatedExcel->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $paginatedExcel->previousPageUrl() }}">Previous</a></li>
                                @endif

                                {{-- Always show first 3 pages --}}
                                @for ($i = 1; $i <= 3; $i++)
                                    <li class="page-item {{ $paginatedExcel->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $paginatedExcel->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Ellipsis if currentPage > 4 --}}
                                @if ($paginatedExcel->currentPage() > 4)
                                    <a class="page-link goto-page" href="javascript:void(0)" data-position="left">...</a>
                                @endif

                                {{-- Show currentPage -1, currentPage, currentPage +1 --}}
                                @for ($i = max(3, $paginatedExcel->currentPage() - 1); $i <= min($paginatedExcel->lastPage() - 2, $paginatedExcel->currentPage() + 1); $i++)
                                    <li class="page-item {{ $paginatedExcel->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $paginatedExcel->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Ellipsis if currentPage < lastPage - 3 --}}
                                @if ($paginatedExcel->currentPage() < $paginatedExcel->lastPage() - 3)
                                    <a class="page-link goto-page" href="javascript:void(0)" data-position="right">...</a>
                                @endif


                                {{-- Always show last 2 pages --}}
                                @for ($i = $paginatedExcel->lastPage() - 1; $i <= $paginatedExcel->lastPage(); $i++)
                                    <li class="page-item {{ $paginatedExcel->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $paginatedExcel->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Next --}}
                                @if ($paginatedExcel->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $paginatedExcel->nextPageUrl() }}">Next</a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                                @endif

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
                        </nav>
                    </div>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-sm table-striped table-bordered align-middle text-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th>Thứ tự</th>
                                    <th>Tên phường</th>
                                    <th>Năm điều tra</th>
                                    <th>Họ đệm</th>
                                    <th>Tên</th>
                                    <th>Ngày</th>
                                    <th>Tháng</th>
                                    <th>Năm sinh</th>
                                    <th>Giới tính</th>
                                    <th>Dân tộc</th>
                                    <th>Tôn giáo</th>
                                    <th>Diện ưu tiên</th>
                                    <th>Họ đệm của chủ hộ</th>
                                    <th>Tên của chủ hộ</th>
                                    <th>Địa chỉ</th>
                                    <th>Số phiếu</th>
                                    <th>Diện cư trú</th>
                                    <th>Tình trạng cư trú</th>
                                    <th>Khối học</th>
                                    <th>Lớp học</th>
                                    <th>Mã trường</th>
                                    <th>Bậc tốt nghiệp</th>
                                    <th>Bổ túc</th>
                                    <th>Năm tốt nghiệp</th>
                                    <th>Bậc tốt nghiệp nghề</th>
                                    <th>Năm tốt nghiệp nghề</th>
                                    <th>Học xong lớp</th>
                                    <th>Hoc xong năm</th>
                                    <th>Bỏ học lớp</th>
                                    <th>Bỏ học năm</th>
                                    <th>Đang học lớp</th>
                                    <th>Hoàn thành lớp </th>
                                    <th>Tái mù chữ mức </th>
                                    <th>Khuyết tật vận động</th>
                                    <th>Khuyết tật nghe nói</th>
                                    <th>Khuyết tật nhìn</th>
                                    <th>Khuyết tật thần kinh</th>
                                    <th>Khuyết tật trí tuệ</th>
                                    <th>Khuyết tật học tập</th>
                                    <th>Tự kỷ</th>
                                    <th>Khuyết tật khác</th>
                                    <th>Có chứng nhận khuyết tật</th>
                                    <th>Khả năng học tập</th>
                                    <th>Hoàn cảnh đặc biệt</th>
                                    <th>Chi tiết hoàn cảnh</th>
                                    <th>Quan hệ với chủ họ</th>
                                    <th>Họ tên cha mẹ</th>
                                    <th>Điện thoại</th>
                                    <th>Ghi chú</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paginatedExcel->items() as $excels)
                                <tr>
                                    <td>{{$excels->tt}}</td>
                                    <td>{{$excels->ten_phuong}}</td>
                                    <th>{{$excels->nam_dieu_tra}}</th>
                                    <td>{{$excels->ho_dem}}</td>
                                    <td>{{$excels->ten}}</td>
                                    <td>{{$excels->ngay}}</td>
                                    <td>{{$excels->thang}}</td>
                                    <td>{{$excels->nam_sinh}}</td>
                                    <td>{{$excels->gioi_tinh}}</td>
                                    <td>{{$excels->dan_toc}}</td>
                                    <td>{{$excels->ton_giao}}</td>
                                    <td>{{$excels->dien_uu_tien}}</td>
                                    <td>{{$excels->ho_dem_cua_chu_ho}}</td>
                                    <td>{{$excels->ten_cua_chu_ho}}</td>
                                    <td>{{$excels->dia_chi}}</td>
                                    <td>{{$excels->so_phieu}}</td>
                                    <td>{{$excels->dien_cu_tru}}</td>
                                    <td>{{$excels->tinh_trang_cu_tru}}</td>
                                    <td>{{$excels->khoi_hoc}}</td>
                                    <td>{{$excels->lop_hoc}}</td>
                                    <td>{{$excels->ma_truong}}</td>
                                    <td>{{$excels->bac_tot_nghiep}}</td>
                                    <td>{{$excels->bo_tuc}}</td>
                                    <td>{{$excels->nam_tot_nghiep}}</td>
                                    <td>{{$excels->bac_tn_nghe}}</td>
                                    <td>{{$excels->nam_tn_nghe}}</td>
                                    <td>{{$excels->hoc_xong_lop}}</td>
                                    <td>{{$excels->hoc_xong_nam}}</td>
                                    <td>{{$excels->bo_hoc_lop}}</td>
                                    <td>{{$excels->bo_hoc_nam}}</td>
                                    <td>{{$excels->dang_hoc_lop}}</td>
                                    <td>{{$excels->hoan_thanh_lop}}</td>
                                    <td>{{$excels->tai_mu_chu_muc}}</td>
                                    <td>{{$excels->khuyet_tat_van_dong}}</td>
                                    <td>{{$excels->khuyet_tat_nghe_noi}}</td>
                                    <td>{{$excels->khuyet_tat_nhin}}</td>
                                    <td>{{$excels->khuyet_tat_than_kinh}}</td>
                                    <td>{{$excels->khuyet_tat_tri_tue}}</td>
                                    <td>{{$excels->khuyet_tat_hoc_tap}}</td>
                                    <td>{{$excels->tu_ky}}</td>
                                    <td>{{$excels->khuyet_tat_khac}}</td>
                                    <td>{{$excels->co_chung_nhan_khuyet_tat}}</td>
                                    <td>{{$excels->kha_nang_hoc_tap}}</td>
                                    <td>{{$excels->hoan_canh_dac_biet}}</td>
                                    <td>{{$excels->chi_tiet_hoan_canh}}</td>
                                    <td>{{$excels->quan_he_voi_chu_ho}}</td>
                                    <td>{{$excels->ho_ten_cha_me}}</td>
                                    <td>{{$excels->dien_thoai}}</td>
                                    <td>{{$excels->ghi_chu}}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="" method="" class="m-0 ml-2">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
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
                                    <th>Thứ tự</th>
                                    <th>Tên phường</th>
                                    <th>Năm điều tra</th>
                                    <th>Họ đệm</th>
                                    <th>Tên</th>
                                    <th>Ngày</th>
                                    <th>Tháng</th>
                                    <th>Năm sinh</th>
                                    <th>Giới tính</th>
                                    <th>Dân tộc</th>
                                    <th>Tôn giáo</th>
                                    <th>Diện ưu tiên</th>
                                    <th>Họ đệm của chủ hộ</th>
                                    <th>Tên của chủ hộ</th>
                                    <th>Địa chỉ</th>
                                    <th>Số phiếu</th>
                                    <th>Diện cư trú</th>
                                    <th>Tình trạng cư trú</th>
                                    <th>Khối học</th>
                                    <th>Lớp học</th>
                                    <th>Mã trường</th>
                                    <th>Bậc tốt nghiệp</th>
                                    <th>Bổ túc</th>
                                    <th>Năm tốt nghiệp</th>
                                    <th>Bậc tốt nghiệp nghề</th>
                                    <th>Năm tốt nghiệp nghề</th>
                                    <th>Học xong lớp</th>
                                    <th>Học xong năm</th>
                                    <th>Bỏ học lớp</th>
                                    <th>Bỏ học năm</th>
                                    <th>Đang học lớp</th>
                                    <th>Hoàn thành lớp </th>
                                    <th>Tái mù chữ mức </th>
                                    <th>Khuyết tật vận động</th>
                                    <th>Khuyết tật nghe nói</th>
                                    <th>Khuyết tật nhìn</th>
                                    <th>Khuyết tật thần kinh</th>
                                    <th>Khuyết tật trí tuệ</th>
                                    <th>Khuyết tật học tập</th>
                                    <th>Tự kỷ</th>
                                    <th>Khuyết tật khác</th>
                                    <th>Có chứng nhận khuyết tật</th>
                                    <th>Khả năng học tập</th>
                                    <th>Hoàn cảnh đặc biệt</th>
                                    <th>Chi tiết hoàn cảnh</th>
                                    <th>Quan hệ với chủ họ</th>
                                    <th>Họ tên cha mẹ</th>
                                    <th>Điện thoại</th>
                                    <th>Ghi chú</th>
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