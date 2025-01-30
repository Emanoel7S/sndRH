<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    function index(){
        return view('dashboard/index');
    }



}

