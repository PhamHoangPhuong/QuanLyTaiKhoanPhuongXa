<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;  

class UserController extends Controller
{
    public function view_user(){

        $user = Auth::user()->getAttributes();
        
        $users = DB::select("SELECT * FROM users
            JOIN provinces ON provinces.province_id = users.province_id
            JOIN wards ON wards.ward_id = users.ward_id
            WHERE users.province_id = ?", [$user["province_id"]]);

        return view('users.users-index', compact('users'));
    }

    public function form_add_user(Request $request){

        $login_province_id = Auth::user()->province_id;

        // $province_id = $request->province_id ?? null; 
        // $ward_id = $request->ward_id ?? null;

        $roles = DB::select("SELECT * FROM users_role
            WHERE ROLE = 'Ward'");

        // $wards = DB::select("
        //     SELECT * FROM wards
        //         JOIN provinces ON provinces.province_id = wards.province_id
        //         WHERE wards.province_id = ?
        // ", [$province_id]);

        $provinces = DB::select("
            SELECT * FROM provinces
            WHERE province_id = ?
        ", [$login_province_id]);

        // $ward_codes = DB::select("
        //     SELECT * FROM wards
        //     WHERE ward_id = ?
        // ", [$ward_id]);

        // $province_codes = DB::select("
        //     SELECT * FROM provinces
        //     WHERE province_id = ?
        // ", [$province_id]);
        // dd($roles);

        return view('users.users-add', compact('roles', 'provinces'));
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
            'username' => 'required|string|unique:users|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email'     => 'required|unique:users,email|email|max:191',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required',
            'ward_id' => 'required',
        ], [
            'password.confirmed'  => 'Mật khẩu xác nhận không khớp',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $role = $request->input('role_id');

        $ward = $request->input('ward_id'); 

        $province = $request->input('province_id');

        $province_code = $request->input('province_code');

        $ward_code = $request->input('ward_code');

        $username = $request->input('username');
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');

        $email = $request->input('email');

        $password = $request->input('password');
        $role = $request->input('role_id');

        $hashedPassword = Hash::make($password);

        $invalidRolesRaw = DB::select("SELECT role_id FROM users_role WHERE role_id != ?", [1]);
        $invalidRoles = [];
        foreach ($invalidRolesRaw as $r) {
            $invalidRoles[] = $r->role_id;
        }


        if (in_array($role, $invalidRoles)) {
            return redirect()->back()->with('error', 'Bạn không được tạo user với role này!');
        }

        $role = 1;

        DB::insert('INSERT INTO users (ward_id, province_id, ward_code, province_code, username, first_name, last_name, email, password, role_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())', [
            $ward, $province, $ward_code, $province_code, $username, $firstname, $lastname, $email, $hashedPassword, $role
        ]);

        return redirect()->route('form.add-user')->with('success', 'Account created successfully!');
    }

    public function form_edit_user($id)
    {
        $login_province_id = Auth::user()->province_id;

        $user = DB::selectOne("SELECT * FROM users
                    WHERE id = ?", [$id]);

        $province_id = $request->province_id ?? null; 
        $ward_id = $request->ward_id ?? null;

        $roles = DB::select("SELECT * FROM users_role
            WHERE ROLE = 'Ward'");

        $wards = DB::select("
            SELECT * FROM wards
                JOIN provinces ON provinces.province_id = wards.province_id
                WHERE wards.province_id = ?
        ", [$province_id]);

        $provinces = DB::select("
            SELECT * FROM provinces
            WHERE province_id = ?
        ", [$login_province_id]);



        $ward_codes = DB::select("
            SELECT * FROM wards
            WHERE ward_id = ?
        ", [$ward_id]);

        $province_codes = DB::select("
            SELECT * FROM provinces
            WHERE province_id = ?
        ", [$province_id]);

        

        return view('users.users-edit', compact('user', 'roles', 'wards', 'provinces', 'ward_codes', 'province_codes'));
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email'     => 'required|email|max:191',
            'ward_id' => 'required',
        ], [
            'password.confirmed'  => 'Mật khẩu xác nhận không khớp',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }


        $ward = $request->input('ward_id'); 

        $province = $request->input('province_id');

        $province_code = $request->input('province_code');

        $ward_code = $request->input('ward_code');

        $username = $request->input('username');
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');

        $email = $request->input('email');

        

        DB::update('UPDATE users 
                SET ward_id = ?, province_id = ?, ward_code = ?, province_code = ? , username = ?, first_name = ?, last_name = ?, email = ?
                WHERE id = ?', [$ward, $province, $ward_code, $province_code, $username, $firstname, $lastname, $email, $id]);

        return redirect()->route('form.edit-user', ['id' => $id])->with('success', 'Account updated successfully!');
    }

    public function delete($id){
        DB::delete("DELETE FROM users WHERE id = ?", [$id]);

        return back()->with('success', 'Product deleted successfully!');
    }

}
