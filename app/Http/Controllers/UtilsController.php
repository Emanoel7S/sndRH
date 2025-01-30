<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Classes\Perfil;
use Carbon\Carbon;

class UtilsController extends Controller
{


    public static function getPerm($id)
    {
       return DB::table('view_user_perm_mod')
            ->where(['idUser'=>Auth::user()->id,'idMod'=>$id,'idStatusPerm'=>'1'])->exists();
    }

    public static function profile() {

        $user = Profile::user();
        $idComp = $user->idComp;
        $idUser = $user->idUser;
        $perfil_retorno = new Perfil();
        $perfil_retorno->create();


        $perfil = DB::table('mod_adiantamento_perfil')
            ->orderBy('id','DESC');


        if(DB::table('mod_adiantamento_perfil')->where(['idComp'=>$idComp,'idUser'=>$idUser])->exists()){
            $perfil->where(['idComp'=>$idComp,'idUser'=>$idUser]);
            $perfil = $perfil->first();


        } elseif (DB::table('mod_adiantamento_perfil')->where(['idComp'=>$idComp])->exists()){
            $perfil->where(['idComp'=>$idComp]);
            $perfil = $perfil->first();

        } else {

            return $perfil_retorno;

               // {"id":1,"idComp":77,"idUser":null,"minimo":1,"maximo":40,"ativo":"N","piso":5000,"tipo":"P"}
        }


        if($perfil->tipo=='P') {
            $perfil->minimo = $perfil->piso * ($perfil->minimo / 100);
            $perfil->maximo = $perfil->piso * ($perfil->maximo / 100);
        }
        $perfil_retorno->minimo = $perfil->minimo;
        $perfil_retorno->maximo = $perfil->maximo;
        $perfil_retorno->diabase = $perfil->dia_base;





            $database = Carbon::create(date('Y'), date('m'), $perfil->dia_base);
            $datatual = Carbon::today();


        $diasmes = Carbon::create(date('Y'), date('m'), 01)->daysInMonth;
        $diabase = $perfil->dia_base > $diasmes?$diasmes:$perfil->dia_base;



            if($datatual >= $database){

                $from = Carbon::create(date('Y'), date('m'), $diabase);

                $diasmes = Carbon::create(date('Y'), date('m'), 01)->addMonth()->daysInMonth;
                $diabase = $perfil->dia_base > $diasmes?$diasmes:$perfil->dia_base;


                $to = Carbon::create(date('Y'), date('m'), $diabase)->addMonth();

            } else {
                $to = Carbon::create(date('Y'), date('m'), $perfil->dia_base);
                $diasmes = Carbon::create(date('Y'), date('m'), 01)->addMonth(-1)->daysInMonth;
                $diabase = $perfil->dia_base > $diasmes?$diasmes:$perfil->dia_base;
                $from = Carbon::create(date('Y'), date('m'), $perfil->dia_base)->addMonth(-1);

            }

        $perfil_retorno->from =$from;
        $perfil_retorno->to = $to;



        //$to = date('2022-09-20');

        $acumulado = DB::table('mod_cliente_adiantamentos')
            ->where(['idComp'=>$idComp,'idUser'=>$idUser])
            ->where('status','<>','9')
            ->where('status','<>','R')
            ->whereBetween('data_requerida', [$from->format('Y-m-d'), $to->format('Y-m-d')])->sum('valor');

            $perfil_retorno->periodo = $from->format('d/m/Y') . " á " . $to->format('d/m/Y');
            $perfil_retorno->acumulado = $acumulado;

        return $perfil_retorno;
    }

    public static function getListaConvenios(){
        $user = Profile::user();
        return DB::table('mod_convenios')
                        ->where(['ativo'=>'S','idComp'=>$user->idComp])
                        ->select('id','descricao')
                        ->get();

    }



}

