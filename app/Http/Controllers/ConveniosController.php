<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ConveniosRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class ConveniosController extends Controller
{
    const  idmodulo = 19;


    function index()
    {


        $t = DB::table('mod_cliente_convenios')
            ->leftJoin('mod_cliente_status', 'mod_cliente_status.id', '=', 'mod_cliente_convenios.status')
            ->select('mod_cliente_convenios.*', 'mod_cliente_status.descricao as status', 'mod_cliente_status.id as idstatus', 'mod_cliente_status.classcss')
            ->orderBy('id', 'DESC')
            ->where(['idUser' => Auth::user()->id]);


        //$t->limit(30);
        $t = $t->get();

        return view('convenios/index')->with(['t' => $t]);

    }


    function novo()
    {


        return view('convenios/novo');

    }

    function insert(ConveniosRequest $r)
    {


        Profile::permMod(self::idmodulo);



        $perfil_adi = UtilsController::profile();


        $convenio = DB::table('mod_convenios')
            ->where(['id'=>Request::input('idconvenio')])
            ->first();

        $profile = Profile::user();
        $id = DB::table('mod_cliente_convenios')->insertGetId([

            'iduser' => Auth::user()->id,
            'user_email' => Auth::user()->email ?? '',
            'idComp' => $profile->idComp ?? '',
            'user_name' => Auth::user()->name ?? '',
            "idconvenio" => Request::input('idconvenio') ?? '',
            "descricao" => $convenio->descricao ?? '',
            "data_requerida" => Request::input('data_requerida'),
            "qtd" => Request::input('qtd'),

        ]);

        //self::AutoCheck($id,$profile->idComp,$profile->idUser);
        return redirect()->action('ConveniosController@index')->with(['id' => $id, 'desc' => Request::input('descricao')]);

    }

    function remove($id)
    {


        DB::table('mod_cliente_convenios')
            ->where(['id' => $id, 'iduser' => Auth::user()->id, 'status' => 'A'])
            ->update([

                'status' => '9',
                'aviso' => 'Cancelado pelo usuário'


            ]);

        return redirect()->action('ConveniosController@index')->with(['id' => $id, 'acao' => 'r']);
    }


    function editar($id)
    {
        $r = Db::table('convenios')->where(['id' => $id])->get();
        return view('convenios/editar')->with(['r' => $r[0]]);

    }


    /**
     * @param string $id id da tabela mod_cliente_convenios
     * @param string $idComp idComp da tabela mod_cliente_convenios
     * @param string $idUser idUser da tabela mod_cliente_convenios
     * @return void
     */
    function AutoCheck($id = 3, $idComp = 77, $idUser = 99)
    {
        $convenios = DB::table('mod_cliente_convenios')->where(['id' => $id])->first();


        $check = DB::table('mod_cliente_convenios')
            ->where('status', '<>', '9')
            ->where('status', '<>', 'R')
            ->where('id', '<>', $id)
            ->WhereBetween('data_inicio', [$convenios->data_inicio, $convenios->data_fim])->exists();


        if($check){
            DB::table('mod_cliente_convenios')->where(['id' => $id])
                ->update([
                'status'=>'R',
                'aviso'=>'Recusa automática pelo sistema, o periodo do pedido conflita com outro pedido'
            ]);
            return true;
        }


        $check = DB::table('mod_cliente_convenios')
            ->where('status', '<>', '9')
            ->where('status', '<>', 'R')
            ->where('id', '<>', $id)
            ->WhereBetween('data_fim', [$convenios->data_inicio, $convenios->data_fim])->exists();


        if($check){
            DB::table('mod_cliente_convenios')->where(['id' => $id])
                ->update([
                    'status'=>'R',
                    'aviso'=>'Recusa automática pelo sistema, o periodo do pedido conflita com outro pedido'
                ]);
            return true;
        }




        return true;
    }


}
