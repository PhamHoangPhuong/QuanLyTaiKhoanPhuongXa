<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Change Ward Password!</h1>
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form class="user" action="{{ route('change.ward-password.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')


                        <div class="form-group">
                            <input type="password" 
                                class="form-control form-control-user"
                                name="old_password"
                                placeholder="Password">
                            @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" 
                                    class="form-control form-control-user"
                                    name="password" 
                                    placeholder="New password">
                                @error('password') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror  
                            </div>


                            <div class="col-sm-6">
                                <input type="password" 
                                    class="form-control form-control-user"
                                    name="password_confirmation" 
                                    placeholder="Retype new password">
                                @error('password_confirmation') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror  
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Đổi mật khẩu
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-edit"></i> Quay lại
                        </a>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="login.html">Already have an account? Login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>