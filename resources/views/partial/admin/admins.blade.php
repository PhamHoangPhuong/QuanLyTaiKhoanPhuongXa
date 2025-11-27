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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('form.add-account')}}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add New Account
                        </a>
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
                                    <th>Tên tỉnh</th>
                                    <th>Mã phường</th>
                                    <th>Mã tỉnh</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$user->ten_phuong}}</td>
                                    <td>{{$user->ten_tinh}}</td>
                                    <td>{{$user->ward_code}}</td>
                                    <td>{{$user->province_code}}</td>
                                    <td>{{$user->name}}</td>
                                    <th>{{$user->email}}</th>
                                    <th>{{$user->role}}</th>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('form.edit-account', $user->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('delete.account', $user->id) }}" method="POST" class="m-0 ml-2">
                                                @csrf
                                                @method('DELETE')
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
                                    <th>No.</th>
                                    <th>Tên phường</th>
                                    <th>Tên tỉnh</th>
                                    <th>Mã phường</th>
                                    <th>Mã tỉnh</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
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