<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";


class Ajaxventas{

	/*=============================================
  ABONAR VENTA
  =============================================*/ 

  public $idVenta;

  public function ajaxAbonarventa(){

      $item = "id";
      $valor = $this->idVenta;

      $respuesta = ControladorVentas::ctrMostrarVentas($item, $valor,);

      echo json_encode($respuesta);


  }

}

/*=============================================
ABONAR VENTA
=============================================*/ 

if(isset($_POST["idVenta"])){

  $Venta = new Ajaxventas();
  $Venta -> idVenta = $_POST["idVenta"];
  $Venta -> ajaxAbonarventa();

}







