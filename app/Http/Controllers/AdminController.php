<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function admin(){

        $users = DB::select("SELECT * FROM users
            LEFT JOIN wards ON users.ward_id = wards.ward_id
            JOIN provinces ON users.province_id = provinces.province_id
            JOIN users_role ON users.role_id = users_role.role_id
        ");

        return view('admins.admins-index', compact('users'));
    }

    public function form_add_account(Request $request){

        $province_id = $request->province_id ?? null; 
        $ward_id = $request->ward_id ?? null;

        $roles = DB::select("SELECT * FROM users_role
            WHERE ROLE != 'Admin'
        ");

        $wards = DB::select("
            SELECT * FROM wards
                JOIN provinces ON provinces.province_id = wards.province_id
                WHERE wards.province_id = ?
        ", [$province_id]);

        $provinces = DB::select("SELECT * FROM provinces");

        $ward_codes = DB::select("
            SELECT * FROM wards
            WHERE ward_id = ?
        ", [$ward_id]);

        $province_codes = DB::select("
            SELECT * FROM provinces
            WHERE province_id = ?
        ", [$province_id]);


        return view('admins.admins-add', compact('roles', 'wards', 'provinces', 'ward_codes', 'province_codes'));
    }

    public function getWards(Request $request)
    {
        $provinceId = $request->province_id;

        $wards = DB::select("
            SELECT * FROM wards WHERE province_id = ?
        ", [$provinceId]);

        return response()->json($wards);
    }

    public function getProvinceCode(Request $request)
    {
        $provinceId = $request->province_id;

        $provinceCode = DB::select("
            SELECT province_id, ma_tinh 
            FROM provinces 
            WHERE province_id = ?
        ", [$provinceId]);

        return response()->json($provinceCode);
    }

    public function getWardCode(Request $request)
    {
        $wardId = $request->ward_id;

        $wardCode = DB::select("
            SELECT ward_id, ma_phuong 
            FROM wards 
            WHERE ward_id = ?
        ", [$wardId]);

        return response()->json($wardCode);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required'
        ], [
            'password.confirmed'  => 'Mật khẩu xác nhận không khớp',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $role = $request->input('role_id');

        $ward = $request->input('ward_id'); 
        if ($role == 1) {
            $province = $request->input('province_id');
            $province_code = $request->input('province_code');
        } elseif ($role == 2) {
            $province = $request->input('province_id_2');
            $province_code = $request->input('province_code_2');
        } else {
            $province = null;
        }

        $ward_code = $request->input('ward_code');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $hashedPassword = Hash::make($password);

        DB::insert('INSERT INTO users (ward_id, province_id, ward_code, province_code, name, email, password, role_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())', [
            $ward, $province, $ward_code, $province_code, $name, $email, $hashedPassword, $role
        ]);

        return redirect()->route('form.add-account')->with('success', 'Account created successfully!');
    }

    public function form_edit_account($id)
    {

        $user = DB::selectOne("SELECT * FROM users
                    WHERE id = ?", [$id]);

        $province_id = $request->province_id ?? null; 
        $ward_id = $request->ward_id ?? null;

        $roles = DB::select("SELECT * FROM users_role
            WHERE ROLE != 'Admin'
        ");

        $wards = DB::select("
            SELECT * FROM wards
                JOIN provinces ON provinces.province_id = wards.province_id
                WHERE wards.province_id = ?
        ", [$province_id]);

        $provinces = DB::select("SELECT * FROM provinces");

        $ward_codes = DB::select("
            SELECT * FROM wards
            WHERE ward_id = ?
        ", [$ward_id]);

        $province_codes = DB::select("
            SELECT * FROM provinces
            WHERE province_id = ?
        ", [$province_id]);


        return view('admins.admins-edit', compact('user', 'roles', 'wards', 'provinces', 'ward_codes', 'province_codes'));
    }

    public function delete($id){
        DB::delete("DELETE FROM users WHERE id = ?", [$id]);

        return back()->with('success', 'Product deleted successfully!');
    }
}
