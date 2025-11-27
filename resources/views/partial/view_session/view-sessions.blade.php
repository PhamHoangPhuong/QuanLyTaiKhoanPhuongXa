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
                                    <th>Session code</th>
                                    <th>Ward name</th>
                                    <th>Status</th>
                                    <th>Result</th>
                                    <th>Total success</th>
                                    <th>Total fail</th>
                                    <th>Queued at</th>
                                    <th>Executed at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $index => $session)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$session->session_code}}</td>
                                    <td>{{$session->ten_phuong}}</td>
                                    <td>{{$session->nam_dieu_tra}}</td>
                                    <td>{{$session->status}}</td>
                                    <td>{{$session->result}}</td>
                                    <td>{{$session->total_success}}</td>
                                    <td>{{$session->total_fail}}</td>
                                    <td>{{$session->queued_at}}</td>
                                    <td>{{$session->executed_at}}</td>
                                    <!-- <td>
                                        <div class="d-flex gap-2">
                                            <a href="" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="" method="POST" class="m-0 ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td> -->
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Session code</th>
                                    <th>Ward name</th>
                                    <th>Status</th>
                                    <th>Result</th>
                                    <th>Total success</th>
                                    <th>Total fail</th>
                                    <th>Queued at</th>
                                    <th>Executed at</th>
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