<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile(){

        $ids = Auth::user()->getAttributes();
        $id = $ids["id"];

        $user = DB::selectOne("SELECT * FROM users WHERE id = ?", [$id]);

        return view('profiles.profile', compact('user'));
    }
}
