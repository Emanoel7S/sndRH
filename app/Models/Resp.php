<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* EX: 
use App\Models\Resp;
Resp::lineAdd() traz as informações do perfil do usuario
*/
class Resp extends Model
{

		
	//-------> Resposta modelo LINE <-------\\
	//resposta por lina Adicionar
	 function lineAdd($url)
	 {
		//Mande a mensagem de resposta
        $msg_response = array(
			"icon" => "success",
            "title" => "Sucesso!",
            "text" => "Dados Criados",
			"url" => $url,
        ); 
		return($msg_response);
	 }
	//resposta por lina Editar	
	function lineEdit($url)
	 {
		//Mande a mensagem de resposta
        $msg_response = array(
			"icon" => "success",
            "title" => "Sucesso!",
            "text" => "Dados Autualizados",
			"url" => $url,
        ); 
		return($msg_response);
	 }
	//resposta por lina Excluir	
	function lineDel($url)
	 {
		//Mande a mensagem de resposta
        $msg_response = array(
			"icon" => "danger",
            "title" => "EXCLUIDO!",
            "text" => "Dados Autualizados",
			"url" => $url,
        ); 
		return($msg_response);
	 }
	
	
	
	
	//-------> Resposta modelo MODAL <-------\\
	
	 function modalAdd($btUrl)
	 {
		//Mande a mensagem de resposta
        $msg_response = array(
            "title" => "Criado com Sucesso!",
            "text" => "Mensagem",
            "bt" => "edit",
            "btUrl" => $btUrl,
            "modalContent" => "",
            "id" => '',
        );
		 
		return($msg_response);
	}
	
	
	
	 function modalEdit($btUrl,$id)
	 {
		//Mande a mensagem de resposta
        $msg_response = array(
            "title" => "Editado com Sucesso!",
            "text" => "Mensagem",
            "bt" => "edit",
            "btUrl" => $btUrl,
            "modalContent" => "",
            "id" => $id,
        );
		 
		return($msg_response);
	}
	
	
	function modalDel($btUrl,$id)
	{
        //Mande a mensagem de resposta
        $msg_response = array(
            "title" => "foi Excluido",
            "text" => "Mensagem ",
            "bt" => "",
            "btUrl" => $btUrl,
            "modalContent" => "",
            "id" => $id,
        );
		 
		return($msg_response);
	}
	

	
	
}