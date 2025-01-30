<?php	

namespace App\Http\Controllers;
//namespace Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Session;
use App\Models\Profile;
use App\Models\Resp;



class UserProfileAuthController extends Controller
{
  //--------> IDENTIFICA Letras unidas com numeros, ou somente letras ou somente numeros 
/*
	function userProfile(){
	
	$user_perfil=DB::table('view_user_profile')
	 ->where(['profileUserId'=>Auth::id()])
	->first();

	//lista permissao do usuario por empresa
	$record_comp=DB::table('view_users_perm_comp')
	->where(['idUser'=>Auth::id()])
	->get();
	
	Session::put( 'sessionUserPerfil', $user_perfil );
	Session::put( 'sessionUserComp', $record_comp );
	}
	*/
	
	//============================> HITORICO DO USUARIO 
	//***** Exite outra função como a mesma ferramenta ***//
	//será descuntinuada. 
	function	userProfileHistReg($id_action,$condition,$id_mod_elem,$id_comum){
		//1-id_action: 1: select; | 2: Insert; | 3: update; | 4: Delet; | 5: start
		//2-condition: 1: modulo; | 2: elemento;
		//3-id_mod_elem: Numero do Modulo/Elemento;
		//4-id_comum: Numero dos cadastros dos aplicativos
		
		
		$user_profile= Profile::user();
		$now = Carbon::now();
		$pc_ip = $_SERVER['REMOTE_ADDR'];
		$pc_host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		//inserir registro histórico do perfil do usuario	
		$record=DB::table('users_profile_historic')->insertGetId([
			'idAction'=>$id_action,
			'conditionModElem'=>$condition,
			'idModElem'=>$id_mod_elem,
			'idComum'=>$id_comum,
			'xDateTime'=>$now,
			'idUser'=>$user_profile->idUser,
			'idComp'=>$user_profile->idComp,
			'pcIp'=>$pc_ip,
			'pcHostName'=>$pc_host_name,

		]);
	}


	
	
	/*-------------------------------------
	----------- ALTERAR  THEMES -----------
	---------------------------------------*/
	
	function profileThemes(Request $request){
		
		$id_user=Auth::id();
		//registro hitorico
		
		 UserProfileAuthController::userProfileHistReg("3","2","2", Auth::id());
		
		$themes_content_href = Request::input('themesContentHref');
		$themes_sidebar_href = Request::input('themesSidebarHref');
		
		$now = Carbon::now();
		
		$record = DB::table('users_profile')
		->where(['idUser'=>$id_user])
		->update([
			"themesContentHref" => $themes_content_href,
			"themesSidebarHref" => $themes_sidebar_href,
			"updated_at"=>$now,
	
		]);
		
		
		//RESPOSTA
		$msg_response=Resp::lineEdit('system-user-profile/index');
		
		return view('system/msg-response-line')->with(['record' => $record,'msg_response'=>$msg_response]);
	}
	
	
	/*-------------------------------------
	----------- ALTERAR A SENHA -----------
	---------------------------------------*/
	
	//Verifica a senha atual
	function passwordCheck(Request $request){
		
		
		if (!(Hash::check(Request::input('passwordPresent'), Auth::user()->password))) {
            // The passwords matches
           	$record = false;
			UserProfileAuthController::userProfileHistReg("3","2","7", Auth::id());

        }else{           
			$record = true;
			UserProfileAuthController::userProfileHistReg("3","2","6", Auth::id());

		}
	
		return view('system-user-profile/formedit-passwordcheck')->with(['record' => $record]);

	}
	
	
	
	//Verigica e atualiza a senha
	function passwordUp(Request $request){
		//recebe formaularios	
		$passwordPresent = Request::input('passwordPresent');
		$newpass = Request::input('newpass');
		$confirmPass = Request::input('confirmPass');
		$now = Carbon::now();
		
		//Verifica a senha atual
		 if (!(Hash::check(Request::input('passwordPresent'), Auth::user()->password))) {
			$record = false;
			UserProfileAuthController::userProfileHistReg("3","2","9", Auth::id());
			 
		//Verifica se as senhas novas são iguais
		 }elseif(!$newpass==$confirmPass){
			 $record = false;
			UserProfileAuthController::userProfileHistReg("3","2","9", Auth::id());
			 
		 }else{
			 
			$record = DB::table('users')
			->where(['id'=>Auth::id()])
			->update([
				"password" => Hash::make($newpass),
				"updated_at"=>$now,
			]);
			$record = true;
			UserProfileAuthController::userProfileHistReg("3","2","8", Auth::id());
			 
			 #modalResponsive .modal-res
			
		 }
			
		
			
			return view('system-user-profile/formedit-passwordup')->with(['record' => $record]);
		}
	
//===============> SELECIONAR EMPRESA	
	//Usuario opão para selecionar as empresas 
	function companylist()
	{
    	return view('system-user-profile/list-select-company');
    }
	
	function selectComp(Request $request)
	{
		//recebe formaularios	
		//ID COD ADMINISTRATIVO
		$id_manager = Request::input('idManager');
		//ID DA EMPRESA SELECIONADA
		$id_comp = Request::input('idComp');
		
		
		//Verifica as permissções do usuario em relação aos id da empresa selecionada
		$perm_comp=Profile::permComp($id_comp);
		$now = Carbon::now();
	
		
		$record = DB::table('users_profile')->where(['idUser'=>Auth::id()])
			->update([
				"idManager" => $id_manager,
				"idComp" => $id_comp,
				"updated_at"=>$now,
			]);
		
		
   		UserProfileAuthController::userProfileHistReg("3","2","4", $id_comp);
		echo "<script>location.reload();</script>";
		
      //  return view('system-user-profile/list-select-company-refresh')->with(['record' => $record,]);
    }
}