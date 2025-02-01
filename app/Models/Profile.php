<?php

namespace App\Models;
use App\Http\Controllers\UserProfileAuthController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
/*
ex:
use Illuminate\Support\Facades\Auth;
Auth::id() //traz somente o id do usuario logado

use App\Models\Profile;
Profile::user() traz as informações do perfil do usuario
*/
class Profile extends Model
{

	//protected $table='view_user_profile';
	//protected $primaryKey = 'idProfile';

	/*------------------------
	----------- EX: ----------
	--------------------------
	//Usuario
	Profile::id();
		--desativado
	Profile::user();
		lista as informações do usuario como:
		nome - email - aparencia


	//Empresa
	Profile::idComp();
	Profile::permComp('2','1');
		- lista id das empresas que o usuario tem permissao de administrar;

	//Modulo
	Profile::permMod()

	//Elemento
	Profile::permElem($mod)


	*/

	/*-------------------------------------
	---------------- USER -----------------
	---------------------------------------*/

	public static function  user($id=null)
	{


		//USUARIO LOGADO
		if($id==null){
			$record=DB::table('view_user_profile')
			->where(['idUser'=>Auth::id()])
			->first();
		//USUARIO SELECIONADO
		}else{

		$record=DB::table('view_user_profile')
			->where(['idUser'=>$id])
			->first();
		}

		return($record);
	}

	/*-------------------------------------
	--------------- COMPANY ---------------
	---------------------------------------*/

	/*  EMPRESA ID */
	//Traz o Id da Empresa Selecionada
	public function  idComp()
	{
		$company=Profile::user(); //Codigo Administrativo

		if(Auth::id()!=null){//Verifica se esta logado
			$record=DB::table('view_user_profile')
			->where(['idUser'=>Auth::id(),'idManager'=> $company->idManager])
			->first();

			return($record->idComp);
		}else{
			echo '<meta http-equiv="refresh" content="0; URL='.asset('/').'"/>';
			exit;
		}
	}
	/*-------------------------------------
	-------- PERMISSÕES C/ COMPANY --------
	---------------------------------------*/
	//Traz somente as permições da(s) Empresa(s) do usuario
	public function  permComp($comp=null,$id_status_perm=null,$idManager=null)
	{
		//infor: tables:view_users_perm_comp= users_profile_perm_comp + comp

		//	PERMISSÕES STATUS USUARIO | INTERROPER
		Profile:: permStatusUser();

		$record=DB::table('view_user_perm_comp');
		//var comp não vasio | var check de permissão vasio
		//Traz informações do ID da empresa seleciona aberta para ckeck com permissão
		if(($comp!=null)&&($id_status_perm==null)&&($idManager==null)){
			$record=$record->where(['idComp'=>$comp, 'idStatusPerm'=>'1', 'IdUser'=>Auth::id(),'idStatusReg'=>'1']);

		//var comp vasio | var não check de permissão vasio
		//Traz informações das empresas, filtrando pelo ckeck
		}elseif(($comp==null)&&($id_status_perm!=null)&&($idManager==null)){
			$record=$record->where(['idStatusPerm'=>$id_status_perm,'IdUser'=>Auth::id(),'idStatusReg'=>'1']);

		//var comp não vasio | var não check de permissão vasio
		//Trazendo informações selecionada do ID empresas, filtrando pelo ckeck
		}elseif(($comp!=null)&&($id_status_perm!=null)&&($idManager==null)){
			$record=$record->where(['idComp'=>$comp,'idStatusPerm'=>$id_status_perm,'IdUser'=>Auth::id(),'idStatusReg'=>'1']);

		//Verifica o cod adminstrador 'idManager', a empresa 'idCom', se esta ativo, do usuario logado idStatusReg a empresa ativa
		}elseif(($comp!=null)&&($id_status_perm!=null)&&($idManager!=null)){
			$record=$record->where(['idManager'=>$idManager,'idComp'=>$comp,'idStatusPerm'=>$id_status_perm,'IdUser'=>Auth::id(),'idStatusReg'=>'1']);

		//var comp vasio | var check de permissão vasio
		//Trazendo as empresas todas as empresas com ou sem permissão
		}else{
			$record=$record->where(['IdUser'=>Auth::id(),'idStatusReg'=>'1']);
			}
		$record=$record->get();

		return($record);
	}

	/*-------------------------------------
	-------- PERMISSÕES C/ MODULOS --------
	- Os modulos tem com objetivos:
	- 1 ACESSO: PERMITIDO ao usuario;
	- 2 ACESSO: PROIBIDO ao usuario;
	- Ex:
	- Profile::permMod(): Lista permissão dos modulos do usurio
	- Profile::permMod('2'): aciona as diretivas de permissão do sistema
	- Profile::permMod('2','select'): Seleciona o local da permissão não apresenta para o usuario
	- modo de usar: Insira no inicio das funções;
	-

	---------------------------------------*/
	//Lista as permissões dos modulos

	public function permMod($id=null,$perm_select=null)
	{

		//	PERMISSÕES STATUS USUARIO | INTERROPER
		Profile:: permStatusUser();
		$profile=Profile::user();
		$access='2';//ACESSO: PROIBIDO
		$record=DB::table('view_user_perm_mod');

		if($profile->idGroup>'10'){ //NÂO FOR: SUPORTE DEV/ATEND
			//Executa as tratativas de segurança
			if(Profile::idComp()!=0){ //selecione a empresa

				if($id!=null){
				//Analiza o modulo que o usuario esta acessando
				$record=$record->where(['idMod'=>$id,'idComp'=>Profile::idComp(),'IdUser'=>Auth::id(),'idStatusReg'=>'1']);
				$record=$record->first();

					//echo $record->idStatusPerm;
				if($record==null){
					$access='2'; /*ACESSO: PROIBIDO*/
					//Regitrando hitórico | 41- Permissão de acesso
					UserProfileAuthController::userProfileHistReg("1","1",$id, Auth::id());
					echo $msg='<p> Load...<p>';
					echo "Permissões: M m:".$id." c:".Profile::idComp()." u:".Auth::id();
					echo '<meta http-equiv="refresh" content="1; URL='.asset('/msg-p').'"/>';
					exit;
				}
					//SE o usuario não tirver permissão faz
					if($record->idStatusPerm!='1'){
						//	NÃO TEM PERMISSÃO
						// 1- PAGE = direcione para a pagina de resposta; corta a conexção;
						if($perm_select==null){
							//Regitrando hitórico | 41- Permissão de acesso
							UserProfileAuthController::userProfileHistReg("1","1","41", Auth::id());
							echo $msg='<p> Load...<p>';
							echo "Permissões: M  m:".$id." c:".Profile::idComp()." u:".Auth::id();
							echo '<meta http-equiv="refresh" content="1; URL='.asset('/msg-p').'"/>';
							exit;
						// 2 Seleciona o local da permissão não apresenta para o usuario

						}else if($perm_select=='select'){	 $access='2';/*ACESSO: PROIBIDO*/	}

					}else{	 $access='1'; /*ACESSO: PERMITIDO*/		}

			}else{   $access='2'; /*ACESSO: PROIBIDO*/

				 	//Regitrando hitórico | 41- Permissão de acesso
					UserProfileAuthController::userProfileHistReg("1","1",$id, Auth::id());
					echo $msg='<p> Load...<p>';
					echo "Permissões: M m:".$id." c:".Profile::idComp()." u:".Auth::id();
					echo '<meta http-equiv="refresh" content="1; URL='.asset('/msg-p').'"/>';
					exit;

				 }

			// Vazio = Listas ID | MODULO | PERMISSÃO do usuario
			}else{

			$record=$record->where(['idComp'=>Profile::idComp(),'IdUser'=>Auth::id(),'idStatusReg'=>'1',]);
			$record=$record->get();

				echo '<b>USER PERMISSION FOR MODEL</b><br><pre>';
				foreach($record as $row){
				 echo 	$row->idMod.' |name: '.$row->xName.' |perm: '.$row->idStatusPerm.' <br>';
				}
				echo '</pre>';
			}
		//PERMITIDO: SUPORTE ATEND
		}elseif($profile->idGroup>'4'){

			//ID: 5   | Path: manager-inter\developer
			//Nome: Developer
			if($id==5){ $access='2'; /*ACESSO: PERMITIDO*/
					//Regitrando hitórico | 41- Permissão de acesso
					UserProfileAuthController::userProfileHistReg("1","1",$id, Auth::id());
					echo $msg='<p> Load...<p>';
					echo "Permissões: D m:".$id." c:".Profile::idComp()." u:".Auth::id();
					echo '<meta http-equiv="refresh" content="1; URL='.asset('/msg-p').'"/>';
					exit;
					  }

		//PERMITIDO: SUPORTE DEV
		}else{	$access='1'; /*ACESSO: PERMITIDO*/	}
		return($access);

	}//---> end permMod()

	/*---------------------------------------
	-------- PERMISSÕES C/ ELEMENTOS --------
	- Os elementos tem com objetivos secundario:
	- 1 Trazer as permissões ao usuario;
	- 2 Informa os eventos do usuario;
	- permElem('1',(..))
	-----------------------------------------*/
	//Lista as permissões dos modulos
	public function permElem($mod,$id=null)
	{

		$record=DB::table('view_user_perm_elem');
		$record=$record->where(['idComp'=>$mod,'idComp'=>Profile::idComp(),'IdUser'=>Auth::id(),'idStatusReg'=>'1']);
		$record=$record->get();

		return($record);
	}

	/*---------------------------------------
	-------- PERMISSÕES C/ TEMPLATE  --------
	- Os elementos tem com objetivos secundario:
	- 1 Company
	- 2 User
	- 3 ID Permission Template - PROFILLE
	-----------------------------------------*/

	//Lista as permissões dos modulos
	public function permTemplate($id_comp=null,$id_user=null,$id_perm_template=null)
	{

		if(($id_user==null)and($id_perm_template==null)){
			$record=DB::table('users_profile_perm_template')
				->where(['idComp'=>$id_comp])
				->get();
			//var_dump($record);

			foreach($record as $row){
				//?? echo 	'|idComp: '.$row->idComp.'|IdUser: '.$row->IdUser.'| idPermTemplate:'.$row->idPermTemplate.'<br>';
				echo 	'|idComp: '.$row->idComp.'| idPermTemplate:'.$row->idPermTemplate.'<br>';
			}

		}else{
			$record=DB::table('users_profile_perm_template')
				->where(['idComp'=>$id_comp,'IdUser'=>$id_user,'idPermTemplate'=>$id_perm_template])
				->first();
			//
			if($record==null){
				$record='0';
			}else{
				$record=$record->idPermTemplate;
			}


		return($record);

		}
		}

	/*-----------------------------------------
	-------- PERMISSÕES STATUS USUARIO --------
	-  ACAO DE INTERROPER o funcionamento do
	- usuario;
	- Informações:
	- 2 /inativo;
	- 3 : cancelado;
	EX:
	//PERMISSÕES STATUS USUARIO | INTERROPER
	Profile:: permStatusUser();
	-----------------------------------------*/
	public function permStatusUser()
	{
	$profile=Profile::user();


	switch($profile->idStatusReg){
		case '2':
			//echo $msg='<p>Load...<p>';
			echo "Permissões:   Usuário: ".$profile->userName." e-mail:".$profile->userEmail;
			//echo '<meta http-equiv="refresh" content="4; URL='.asset('/msg-p-i').'"/>';
			exit;
		break;
		case '3':
		//	echo $msg='<p>Load...<p>';
			echo "Permissões:   Usuário: ".$profile->userName." e-mail:".$profile->userEmail;
			//echo '<meta http-equiv="refresh" content="4; URL='.asset('/msg-p-c').'"/>';
			exit;
		break;
	}
	}


	/*---------------------------------------
	--------   PERMISSÕES C/ GRUPO   --------
	- CLASSIFICA OS USUARIO DOS GRUPOS O SISTEMA
	- Informações do usuario logado
	- I Grupo Interno;
	- E Grupo Externo;
	-----------------------------------------*/
	public function permGroup()
	{
		//TRAZ O PERFIL DO USUARIO LOGADO
		$profile_user=Profile::user(); //Codigo Administrativo
		//Verifica o grupo usuario pertence
		if($profile_user->idGroup<='9'){ //USUARIOS INTERNOS | DEV - SUPORT
			return ($status_group='I'); //permitido Grupo Interno;
		}else{
		 	return($status_group='E'); //permitido Grupo Externo;
		}

	}

	/*---------------------------------------
	--------      AÇÕES A SENHA      --------
	- CLASSIFICA OS USUARIO DOS GRUPOS O SISTEMA
	- Pelo menos uma letra maiúscula em inglês ,(?=.*?[A-Z])
	- Pelo menos uma letra minúscula em inglês, (?=.*?[a-z])
	- Pelo menos um dígito, (?=.*?[0-9])
	- Pelo menos um caractere especial, (?=.*?[#?!@$%^&*-])
	- Comprimento mínimo de oito .{8,}(com as âncoras)
	- resultado: valor:1 verdadeiro | valor: 0 Falso;
	- Mínimo de oito e máximo de 10 caracteres, pelo menos uma letra maiúscula,
	- uma letra minúscula, um número e um caractere especial:

	-----------------------------------------*/

	function passwordValid($pass) {

		return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*?[#?!@$%^&*-])[\w$@]{6,12}$/', $pass);

		}
	/*---------------------------------------
	--------          EMAIL          --------
	-----------------------------------------*/
	//Verifica o email exitente no banco
	function emailExistence($email,$id=null)
	{
		//Verifica somento o email
		if($id==null){

			$record=DB::table('users')->where(['email'=>$email])->get();
			var_dump($record);
			$n=0;

				foreach($record as $row){
					$n++;
				}

		//Verifica o email com id
		}else{
			//descriptografa o id
			$id=Crypt::decrypt($id);
			//verifica o email pertence a este usuario
			$record=DB::table('users')->where(['email'=>$email,'id'=>$id])->first();

			if($record!=null){
				if(($record->email == $email)and($record->id == $id)){
					$n='A';//Id com o mesmo email
				}else{
					$record=DB::table('users')->where(['email'=>$email])->get();
					$n=0;
					foreach($record as $row){
						$n++;
					}
				}
			}else{
					$record=DB::table('users')->where(['email'=>$email])->get();
					$n=0;
					foreach($record as $row){
						$n++;
					}
			}
		}
		return($n);
	}

		//============================> HITORICO DO USUARIO
	function histReg($id_action,$condition,$id_mod_elem,$id_comum){
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



}//END CLASS
