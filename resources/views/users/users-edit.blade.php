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
        <h1 class="h3 mb-0 text-gray-800">Edit User Ward</h1>
    </div>
@stop


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('form.update-user', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- form-body --}}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
                                        <!-- @error('category') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}">
                                        <!-- @error('category') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror -->
                                    </div>
                                </div>


                                <div class="col-md-6" hidden>
                                    <div class="form-group mb-4">
                                        <label for="email" class="form-label">Role</label>
                                        <select class="form-control" id="role" name="role_id">
                                            <!-- <option value="">-- Select Role --</option> -->
                                            @isset($roles)
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->role_id }}" {{ old('role_id') == $role->role_id ? 'selected' : '' }}>
                                                        {{ $role->role_id }} - {{ $role->role }}
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="email" class="form-label">Tỉnh</label>
                                        <select class="form-control" id="province" name="province_id">
                                            @isset($provinces)
                                                @foreach($provinces as $province)
                                                    <option value="{{ $province->province_id }}" {{ old('province_id') == $province->province_id ? 'selected' : '' }}>
                                                        {{ $province->province_id }} - {{ $province->ten_tinh }}
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <!-- @error('category') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="email" class="form-label">Phường</label>
                                        <select class="form-control" id="ward" name="ward_id">
                                            <option value=""> Chọn phường </option>
                                            @isset($wards)
                                                @foreach($wards as $ward)
                                                    <option value="{{ $ward->ward_id }}" {{ old('ward_id') == $ward->ward_id ? 'selected' : '' }}>
                                                        {{ $ward->ward_id }} - {{ $ward->ten_tinh }}
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <!-- @error('category') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror -->
                                    </div>
                                </div>


                                <div class="form-group row col-md-6" id="wardProvinceCodeGroup" hidden> 
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="province_code" class="form-label">Mã tỉnh</label>
                                            <select class="form-control" id="province_code" name="province_code">
                                                <option value=""> Mã tỉnh </option>
                                                @isset($province_codes)
                                                    @foreach($province_codes as $province_code)
                                                        <option value="{{ $province_code->ma_tinh }}" {{ old('ma_tinh') == $province_code->ma_tinh ? 'selected' : '' }}>
                                                            {{ $province_code->province_id }} - {{ $province_code->ma_tinh }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="ward_code" class="form-label">Mã phường</label>
                                            <select class="form-control" id="ward_code" name="ward_code">
                                                <option value=""> Mã phường </option>
                                                @isset($ward_codes)
                                                    @foreach($ward_codes as $ward_code)
                                                        <option value="{{ $ward_code->ma_phuong }}" {{ old('ma_phuong') == $ward_code->ma_phuong ? 'selected' : '' }}>
                                                            {{ $ward_code->ward_id }} - {{ $ward_code->ma_phuong }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{ old('password', $user->password) }}"> 
                                        <!-- @error('name') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="{{ old('password', $user->password) }}">
                                    </div>
                                </div>
                            </div>


                            {{-- Buttons --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('view.user') }}" class="btn btn-secondary">Back to list</a>
                                    <button type="submit" class="btn btn-primary">Edit Ward Account</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>    
    </div>
</div>
@stop



@section('content')
    {{-- Nội dung chính: ví dụ table products --}}
@stop

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

    <script>
        $(document).ready(function () {

            $('#Province').closest('.col-md-6').hide();
            $('#wardProvinceCodeGroup').hide();  
            $('#province_code_2').closest('.col-md-6').hide(); 

            function updateVisibility() {
                const role = $('#role').val();

                if (role === '1') {
                    $('#Province').closest('.col-md-6').hide();
                } 
                else if (role === '2') {
                    $('#Province').closest('.col-md-6').show();
                } 
                else {
                    $('#Province').closest('.col-md-6').hide();
                }


                if (role !== '1' && role !== '2') {
                    $('#province_code').empty().append('<option value=""> Mã tỉnh </option>');
                    $('#ward_code').empty().append('<option value=""> Mã phường </option>');
                    $('#wardProvinceCodeGroup').hide();
                    $('#province').val('');
                    $('#ward').val('');
                    $('#province_code_2').closest('.col-md-6').hide();
                }
            }

            updateVisibility();
            $('#role').on('change', updateVisibility);


            const initialProvince = $('#province').val();
            if(initialProvince) {
                $.get("{{ route('ajax.getProvinceCode') }}", { province_id: initialProvince }, function(res) {
                    if (res.length > 0) {
                        let code = res[0].ma_tinh;
                        $('#province_code').empty().append(`<option value="${code}">${code}</option>`).val(code);
                        $('#wardProvinceCodeGroup').show();
                    }
                });

                $.get("{{ route('ajax.getWards') }}", { province_id: initialProvince }, function(res) {
                    let wardSelect = $('#ward').empty().append('<option value="">-- Chọn phường --</option>');
                    res.forEach(function (ward) {
                        wardSelect.append(`<option value="${ward.ward_id}">${ward.ward_id} - ${ward.ten_phuong}</option>`);
                    });


                    const oldWard = '{{ old("ward_id", $user->ward_id ?? "") }}';
                    if(oldWard) {
                        $('#ward').val(oldWard).trigger('change');
                    }
                });
            }

            $('#province').on('change', function () {
                let provinceId = $(this).val();

                if (!provinceId) {
                    $('#province_code').empty().append('<option value=""> Mã tỉnh </option>');
                    $('#ward_code').empty().append('<option value=""> Mã phường </option>');
                    $('#wardProvinceCodeGroup').hide(); 
                    $('#ward').empty().append('<option value="">-- Chọn phường --</option>');
                    return;
                }

                $.get("{{ route('ajax.getProvinceCode') }}", { province_id: provinceId }, function(res) {
                    if (res.length > 0) {
                        let code = res[0].ma_tinh;
                        $('#province_code').empty().append(`<option value="${code}">${code}</option>`).val(code);
                        $('#wardProvinceCodeGroup').show(); 
                    }
                });

                $.get("{{ route('ajax.getWards') }}", { province_id: provinceId }, function(res) {
                    let wardSelect = $('#ward').empty().append('<option value="">-- Chọn phường --</option>');
                    res.forEach(function (ward) {
                        wardSelect.append(`<option value="${ward.ward_id}">${ward.ward_id} - ${ward.ten_phuong}</option>`);
                    });


                    const oldWard = '{{ old("ward_id", $user->ward_id ?? "") }}';
                    if(oldWard) {
                        $('#ward').val(oldWard).trigger('change');
                    }
                });
            });

            $('#ward').on('change', function () {
                let wardId = $(this).val();
                if (!wardId) {
                    $('#ward_code').empty().append('<option value=""> Mã phường </option>');
                    return;
                }

                $.get("{{ route('ajax.getWardCode') }}", { ward_id: wardId }, function(res) {
                    if (res.length > 0) {
                        let code = res[0].ma_phuong;
                        $('#ward_code').empty().append(`<option value="${code}">${code}</option>`).val(code);
                    }
                });
            });

            $('#Province').on('change', function () {
                let provinceId = $(this).val();
                const role = $('#role').val();

                if (!provinceId || role !== '2') {
                    $('#province_code_2').closest('.col-md-6').hide();
                    $('#province_code_2').empty().append('<option value=""> Mã tỉnh </option>');
                    return;
                }

                $.get("{{ route('ajax.getProvinceCode') }}", { province_id: provinceId }, function(res) {
                    if (res.length > 0) {
                        let code = res[0].ma_tinh;
                        $('#province_code_2').empty().append(`<option value="${code}">${code}</option>`).val(code);
                        $('#province_code_2').closest('.col-md-6').show();
                    } else {
                        $('#province_code_2').closest('.col-md-6').hide();
                        $('#province_code_2').empty().append('<option value=""> Mã tỉnh </option>');
                    }
                });
            });
        });
    </script>

@stop

