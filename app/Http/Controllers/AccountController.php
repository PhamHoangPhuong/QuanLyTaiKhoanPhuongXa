<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function change_ward_password_form($id){

        $user = DB::selectOne("SELECT * FROM users
                    WHERE id = ?", [$id]);

        return view('accounts.accounts-ward-index', compact('user'));
    }

    public function change_ward_password_update(Request $request, $id){

        $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed'],
        ], [
            'old_password.required' => 'Bạn phải nhập mật khẩu cũ',
            'password.required' => 'Bạn phải nhập mật khẩu mới',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp',
        ]);


        $user = DB::selectOne("SELECT * FROM users WHERE id = ?", [$id]);


        // Request lấy từ trong view ra (VD name = "old_password")
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors([
                'old_password' => 'Mật khẩu cũ không chính xác'
            ]);
        }


        DB::update("UPDATE users SET password = ? WHERE id = ?", [
            Hash::make($request->password),
            $id
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }


    public function change_province_password_form($id){

        $user = DB::selectOne("SELECT * FROM users
                    WHERE id = ?", [$id]);

        return view('accounts.accounts-province-index', compact('user'));
    }


    public function change_province_password_update(Request $request, $id){

        $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed'],
        ], [
            'old_password.required' => 'Bạn phải nhập mật khẩu cũ',
            'password.required' => 'Bạn phải nhập mật khẩu mới',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp',
        ]);


        $user = DB::selectOne("SELECT * FROM users WHERE id = ?", [$id]);


        // Request lấy từ trong view ra (VD name = "old_password")
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors([
                'old_password' => 'Mật khẩu cũ không chính xác'
            ]);
        }


        DB::update("UPDATE users SET password = ? WHERE id = ?", [
            Hash::make($request->password),
            $id
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

}
