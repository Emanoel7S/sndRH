<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Classes\Perfil;


class HomeController extends Controller
{


    public static function meuperfil()
    {
        return view('meuperfil');
    }



}

