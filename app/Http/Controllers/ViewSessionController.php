<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ViewSessionController extends Controller
{
    public function view_session(){

        $ids = Auth::user()->getAttributes();
        $id = $ids;

        if($id["ward_id"] && $id["role_id"]){
            $sessions = DB::select("SELECT * FROM import_sessions 
                JOIN users ON import_sessions.ward_id = users.ward_id
                JOIN wards ON import_sessions.ward_id = wards.ward_id
                WHERE import_sessions.ward_id = ? AND role_id = ?
            " , [$id["ward_id"], $id["role_id"]]);
        } else {
            $sessions = DB::select("SELECT * FROM import_sessions 
                JOIN users ON import_sessions.province_id = users.province_id
                JOIN wards ON import_sessions.ward_id = wards.ward_id
                WHERE import_sessions.province_id = ? AND role_id = ?
            " , [$id["province_id"], $id["role_id"]]);
        }

        return view('view_sessions.view-sessions-index', compact('sessions'));
    }
}
