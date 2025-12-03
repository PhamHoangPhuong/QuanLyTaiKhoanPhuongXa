<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller

{
    public function Sign(){
        
        return view('pages.login-page.login');

    }

    public function login(Request $request)
    {
        $validation = $request->validate([
            'login'     => ['required', 'string', 'min:6', 'max:50'],
            'password'  => ['required', 'string', 'min:6', 'max:20'],
        ], [
            'login.required' => 'Vui lòng nhập username hoặc email',
            'login.min' => 'Tối thiểu 6 ký tự',
            'login.max' => 'Tối đa 50 ký tự',
            'password.required' => 'Yêu cầu bạn nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu chỉ có tối đa 20 ký tự'
        ]);

        $login = trim($validation['login']);
        $password = $validation['password'];

        $user = DB::selectOne(
            'SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$login, $login]
        );

        if (!$user) {
            return back()->withErrors(['login' => 'Tên người dùng hoặc email không tồn tại'])->withInput();
        }

    
        if (!Hash::check($password, $user->password)) {
            return back()->withErrors(['password' => 'Mật khẩu sai'])->withInput();
        }


        $credentials = [
            filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username' => $login,
            'password' => $password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        }

        return redirect()->intended('home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('sign');
    }

}
