<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Agenciador;

class AgenciadorController extends Controller{

     public function __construct(){
          $this->modelName = "Agenciador";
          $this->modelClass = NAMESPACE_MODEL . "Agenciador";
         // $this->campos = array('email', 'telefone', 'creci');
     }

     public function create($data){
        $agenciador = new Agenciador;
        $resultado = $agenciador->existe($data);
        if($resultado){
          echo json_encode(["status" => "Creci, Email ou telefone já cadastrado"]);
          return;
        }
        parent::create($data);
     }
  
}