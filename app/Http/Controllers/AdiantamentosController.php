<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AdiantamentosRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
class AdiantamentosController extends Controller
{
    function index(){



           
       $t =  DB::table('mod_cliente_adiantamentos')
           ->leftJoin('mod_cliente_status', 'mod_cliente_status.id', '=', 'mod_cliente_adiantamentos.status')
           ->select('mod_cliente_adiantamentos.*','mod_cliente_status.descricao as status','mod_cliente_status.id as idstatus','mod_cliente_status.classcss')
           ->orderBy('id', 'DESC')
           ->where(['idUser'=>Auth::user()->id]);


       //$t->limit(30);
       $t =$t->get();

        return view('adiantamentos/index')->with(['t' =>$t]);

    }
    
    
    function novo(){
       
      
        return view('adiantamentos/novo');
        
    }
    
    function insert(AdiantamentosRequest $r){

        Profile::permMod('19');

        $perfil_adi = UtilsController::profile();
        $data = Carbon::create(Request::input('data_requerida')) ;

        if($data <= $perfil_adi->from | $data >= $perfil_adi->to){

            return back()->withErrors(['Data fora do intervalo']);
        }



        $profile = Profile::user();
        $id = DB::table('mod_cliente_adiantamentos')->insertGetId([

            'iduser'=>Auth::user()->id,
            'user_email'=>Auth::user()->email,
            'idComp'=>$profile->idComp,
            'user_name'=>Auth::user()->name,
            'valor'=>Request::input('valor'),
            'data_requerida'=>Request::input('data_requerida'),
            'status'=>'A',

        ]);

        self::AutoCheck($id,$profile->idComp,$profile->idUser);

        return redirect()->action('AdiantamentosController@index')->with(['id' => $id, 'desc'=> Request::input('descricao')]);
           
    }
    
    function remove($id){


        DB::table('mod_cliente_adiantamentos')
            ->where(['id'=>$id, 'iduser'=>Auth::user()->id,'status'=>'A'])
            ->update([

                'status'=>'9',
                'aviso'=>'Cancelado pelo usuário'


            ]);

        return redirect()->action('AdiantamentosController@index')->with(['id' => $id,'acao' => 'r']);
    }
    

    
    function editar($id){
        $r = Db::table('adiantamentos')->where(['id'=>$id])->get();
        return view('adiantamentos/editar')->with(['r'=>$r[0]]);
        
    }
    


    /**
     * @param string $id id da tabela mod_cliente_adiantamentos
     * @param string $idComp idComp da tabela mod_cliente_adiantamentos
     * @param string $idUser idUser da tabela mod_cliente_adiantamentos
     * @return void
     */
    function  AutoCheck($id=15, $idComp=77,$idUser=99){

        $adiant = DB::table('mod_cliente_adiantamentos')->where(['id'=>$id])->first();
        $adiantupd = DB::table('mod_cliente_adiantamentos')->where(['id'=>$id]);
        $perfil = UtilsController::profile();





        if($perfil->minimo>0 & $perfil->maximo>0){

            if($adiant->valor < $perfil->minimo){
                $adiantupd = $adiantupd->update([
                    'status'=>'R',
                    'aviso'=>'Recusa automática pelo sistema valor minimo menor que  R$' . number_format($perfil->minimo, 2, ",", ".")
                ]);
                return true;
            }

            if($perfil->acumulado > $perfil->maximo){

                $adiantupd = $adiantupd->update([
                    'status'=>'R',
                    'aviso'=>'Recusa automática pelo sistema valor máximo ou acumulado ultrapassado ' . number_format($perfil->maximo, 2, ",", ".")
                ]);
                return true;
            }
        }  else {
            return false;
        }
    }

 
}
