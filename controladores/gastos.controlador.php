<?php

class ControladorGastos{

	/*=============================================
	MOSTRAR GASTOS
	=============================================*/

	static public function ctrMostrarGastos($item, $valor){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlMostrarGastos($tabla, $item, $valor);

		return $respuesta;

	}


	/*=============================================
	CREAR GASTO
	=============================================*/

	static public function ctrCrearGasto(){

		if(isset($_POST["nuevaDescripcion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["nuevoGasto"])){
				

				$tabla = "gastos";

				$datos = array(
							   "vendedor" => $_POST["idVendedor"],
							   "valor" => $_POST["nuevoGasto"],
							   "descripcion" => $_POST["nuevaDescripcion"],
							   );

				$respuesta = ModeloGastos::mdlIngresarGasto($tabla, $datos);

				if($respuesta == "ok"){
                    
					echo'<script>

						swal({
							  type: "success",
							  title: "El gasto ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "gastos";

										}
									})

						</script>';

				} else{
                    
					echo'<script>

						swal({
							  type: "error",
							  title: "No se registro el gasto, usted esta utilizando un codigo ya existente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "gastos";

										}
									})

						</script>';
				}
			}
				else{

					echo'<script>
	
						swal({
							  type: "error",
							  title: "¡El gasto no puede ir con los campos vacíos o llevar caracteres especiales!",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
	
								window.location = "gastos";
	
								}
							})
	
					  </script>';
				}


			} 
		}

	/*=============================================
	EDITAR GASTO
	=============================================*/

	/*=============================================
	EDITAR GASTO
	=============================================*/

	static public function ctrEditarGasto(){

		if(isset($_POST["editarValor"])){

			if(preg_match('/^[()\-0-9 ]+$/', $_POST["editarValor"]) && 
			   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["editarDescripcion"])){

			   	$tabla = "gastos";

			   	$datos = array("id"=>$_POST["idGasto"],
			   				   "valor"=>$_POST["editarValor"],
					           "descripcion"=>$_POST["editarDescripcion"]);

			   	$respuesta = ModeloGastos::mdlEditarGasto($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El gasto ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "gastos";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El gasto no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "gastos";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	BORRAR GASTO
	=============================================*/
	static public function ctrEliminarGasto(){

		if(isset($_GET["idGasto"])){

			$tabla ="gastos";
			$datos = $_GET["idGasto"];

			$respuesta = ModeloGastos::mdlEliminarGasto($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El gasto ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "gastos";

								}
							})

				</script>';

			}		
		}


	}

	/*=============================================
	MOSTRAR SUMA GASTOS
	=============================================*/

	static public function ctrMostrarSumaGastos(){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlMostrarSumaGastos($tabla);

		return $respuesta;

	}

		/*=============================================
	SUMA TOTAL GASTOS POR FECHA
	=============================================*/

	static public function ctrRangogastosf($fechaInicial, $fechaFinal){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlRangogastosf($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;

	}

}