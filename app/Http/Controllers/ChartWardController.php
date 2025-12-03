<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ChartWardController extends Controller
{
    public function chart_ward(){

        $ward_report = DB::selectOne("SELECT * FROM wards_report");
        return view('charts.charts-ward-index', compact('ward_report'));
    }
}
