<?php

require_once "../controladores/gastos.controlador.php";
require_once "../modelos/gastos.modelo.php";


class Ajaxgastos{

  /*=============================================
  EDITAR GASTO
  =============================================*/ 

  public $idGasto;

  public function ajaxEditarGasto(){

      $item = "id";
      $valor = $this->idGasto;

      $respuesta = ControladorGastos::ctrMostrarGastos($item, $valor,);

      echo json_encode($respuesta);


  }

}

/*=============================================
EDITAR GASTO
=============================================*/ 

if(isset($_POST["idGasto"])){

  $Gasto = new AjaxGastos();
  $Gasto -> idGasto = $_POST["idGasto"];
  $Gasto -> ajaxEditarGasto();

}







