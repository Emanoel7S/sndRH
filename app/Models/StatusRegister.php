<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/*
EX:
use App\Models\StatusRegister;
StatusRegister::select() traz as informações do perfil do usuario
*/

/*-------------------------------------
- Status Register ---------------------
---------------------------------------*/

class StatusRegister extends Model
{
	/*-------------------------------------
	---------------- SELECT -----------------
	---------------------------------------*/
	
	public function  select()
	{
		$record=DB::table('system_status_register')
		->get();
		return($record);
		
	}
}

