<?php
set_time_limit(1320);
ini_set('max_exection_time', '1600');

require_once "conexion.php";

class ModeloGastos{

	/*=============================================
	MOSTRAR GASTOS
	=============================================*/

	static public function mdlMostrarGastos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}


	/*=============================================
	REGISTRO DE GASTOS
	=============================================*/
	static public function mdlIngresarGasto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(vendedor, valor, descripcion) VALUES (:vendedor, :valor, :descripcion)");

		$stmt->bindParam(":vendedor", $datos["vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":valor", $datos["valor"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR GASTO
	=============================================*/
	static public function mdlEditarGasto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET valor = :valor, descripcion = :descripcion WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":valor", $datos["valor"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR PRODUCTO
	=============================================*/

	static public function mdlEliminarGasto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	MOSTRAR SUMA TOTAL DE LOS GASTOS
	=============================================*/	

	static public function mdlMostrarSumaGastos($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(valor) as total FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}

		/*=============================================
	SUMAR EL TOTAL DE GASTOS POR DIA
	=============================================*/

	static public function mdlSumaTotalgastosdia($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(valor) as total FROM $tabla where DATE(fecha) >= DATE( NOW())" );

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlRangogastosf($tabla, $fechaInicial, $fechaFinal){	

		try {
			// Si las fechas son nulas, usar el día actual
			if (empty($fechaInicial) && empty($fechaFinal)) {
				$fechaInicial = date('Y-m-d') . ' 00:00:01';
				$fechaFinal = date('Y-m-d') . ' 23:59:59';
			} else {
				// Agregar las horas para abarcar el día completo
				$fechaInicial .= ' 00:00:01';
				$fechaFinal .= ' 23:59:59';
			}
	
			// Preparar la consulta con parámetros de fechas
			$stmt = Conexion::conectar()->prepare("SELECT SUM(valor) as total FROM $tabla WHERE fecha BETWEEN :fechaInicial AND :fechaFinal");
	
			// Vincular parámetros
			$stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFinal", $fechaFinal, PDO::PARAM_STR);
	
			// Ejecutar la consulta
			$stmt->execute();
	
			// Devolver el resultado
			return $stmt->fetch();
		} catch (Exception $e) {
			// Manejar excepciones
			echo "Error: " . $e->getMessage();
		} finally {
			// Cerrar la conexión
			if ($stmt) {
				$stmt->closeCursor();
				$stmt = null;
			}
		}

	}

}