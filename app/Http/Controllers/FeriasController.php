<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FeriasRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class FeriasController extends Controller
{
    const  idmodulo = 19;


    function index()
    {


        $t = DB::table('mod_cliente_ferias')
            ->leftJoin('mod_cliente_status', 'mod_cliente_status.id', '=', 'mod_cliente_ferias.status')
            ->select('mod_cliente_ferias.*', 'mod_cliente_status.descricao as status', 'mod_cliente_status.id as idstatus', 'mod_cliente_status.classcss')
            ->orderBy('id', 'DESC')
            ->where(['idUser' => Auth::user()->id]);


        //$t->limit(30);
        $t = $t->get();

        return view('ferias/index')->with(['t' => $t]);

    }


    function novo()
    {


        return view('ferias/novo');

    }

    function insert(FeriasRequest $r)
    {


        Profile::permMod(self::idmodulo);

        $perfil_adi = UtilsController::profile();
        $data = Carbon::create(Request::input('data_requerida'));

        $profile = Profile::user();
        $id = DB::table('mod_cliente_ferias')->insertGetId([

            'iduser' => Auth::user()->id,
            'user_email' => Auth::user()->email,
            'idComp' => $profile->idComp,
            'user_name' => Auth::user()->name,
            'data_inicio' => Request::input('data_inicio'),
            'data_fim' => Request::input('data_fim'),
            'status' => 'A',

        ]);

        self::AutoCheck($id,$profile->idComp,$profile->idUser);
        return redirect()->action('FeriasController@index')->with(['id' => $id, 'desc' => Request::input('descricao')]);

    }

    function remove($id)
    {


        DB::table('mod_cliente_ferias')
            ->where(['id' => $id, 'iduser' => Auth::user()->id, 'status' => 'A'])
            ->update([

                'status' => '9',
                'aviso' => 'Cancelado pelo usuário'


            ]);

        return redirect()->action('FeriasController@index')->with(['id' => $id, 'acao' => 'r']);
    }


    function editar($id)
    {
        $r = Db::table('ferias')->where(['id' => $id])->get();
        return view('ferias/editar')->with(['r' => $r[0]]);

    }


    /**
     * @param string $id id da tabela mod_cliente_ferias
     * @param string $idComp idComp da tabela mod_cliente_ferias
     * @param string $idUser idUser da tabela mod_cliente_ferias
     * @return void
     */
    function AutoCheck($id = 3, $idComp = 77, $idUser = 99)
    {
        $ferias = DB::table('mod_cliente_ferias')->where(['id' => $id])->first();


        $check = DB::table('mod_cliente_ferias')
            ->where('status', '<>', '9')
            ->where('status', '<>', 'R')
            ->where('id', '<>', $id)
            ->WhereBetween('data_inicio', [$ferias->data_inicio, $ferias->data_fim])->exists();


        if($check){
            DB::table('mod_cliente_ferias')->where(['id' => $id])
                ->update([
                'status'=>'R',
                'aviso'=>'Recusa automática pelo sistema, o periodo do pedido conflita com outro pedido'
            ]);
            return true;
        }


        $check = DB::table('mod_cliente_ferias')
            ->where('status', '<>', '9')
            ->where('status', '<>', 'R')
            ->where('id', '<>', $id)
            ->WhereBetween('data_fim', [$ferias->data_inicio, $ferias->data_fim])->exists();


        if($check){
            DB::table('mod_cliente_ferias')->where(['id' => $id])
                ->update([
                    'status'=>'R',
                    'aviso'=>'Recusa automática pelo sistema, o periodo do pedido conflita com outro pedido'
                ]);
            return true;
        }




        return true;
    }


}
