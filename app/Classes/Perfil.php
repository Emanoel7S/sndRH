<?php
namespace App\Classes;

class Perfil {
    public $tipo;
    public $minimo;
    public $maximo;
    public $acumulado;
    public $diabase;
    public $periodo;
    public $from;
    public $to;
    public function __construct() {
        return "construct function was initialized.";
    }
    public function create() {
        $this->tipo=0;
        $this->minimo=0;
        $this->maximo=0;
        $this->acumulado=0;
        $this->diabase=0;
        $this->periodo='';
    }
}