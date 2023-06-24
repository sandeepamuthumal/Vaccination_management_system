<?php

namespace App\Http\Controllers;

use App\Models\CenterVaccine;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $schedules = CenterVaccine::orderBy('id', 'DESC')
                    ->leftJoin('center','center.id','=','center_has_vaccines.center_id')
                    ->leftjoin('vaccines','vaccines.id','=','center_has_vaccines.vaccines_id')
                    ->select('center_has_vaccines.*','vaccines.name as vaccine_name','center.name as center_name')
                    ->get();

        return view('center_schedule',compact('schedules'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function locate()
    {
        return view('locate');
    }
}
