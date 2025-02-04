<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'comp';


    protected $primaryKey = 'idComp';


    protected $fillable = [
        'xName',        // Nome da empresa
        'corporateName', // Razão social
        'cnpj',         // CNPJ
        'ie',           // Inscrição estadual
        'idStatusReg',  // Status (1=ativo, 2=inativo)
    ];
}

