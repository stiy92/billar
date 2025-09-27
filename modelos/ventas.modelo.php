<?php

require_once "conexion.php";

class ModeloVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlMostrarVentas($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll(); 

		}
		
		$stmt -> close();

		$stmt = null;

	}

		/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlMostrarVentascodigo($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll(); 

		}
		
		$stmt -> close();

		$stmt = null;

	}

		/*=============================================
	MOSTRAR ULTIMO CODIGO DE VENTA
	=============================================*/

	static public function mdlMostrarCodigo($tabla){

			$stmt = Conexion::conectar()->prepare("SELECT MAX(codigo) as max_codigo FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetch();

			$stmt -> close();

		$stmt = null;

		}
		
		
	/*=============================================
	REGISTRO DE VENTA
	=============================================*/

	static public function mdlIngresarVenta($tabla, $datos){

		try {
			// Obtener el último código
			$stmtCodigo = Conexion::conectar()->prepare("SELECT MAX(codigo) as max_codigo FROM $tabla");
			$stmtCodigo->execute();
			$resultadoCodigo = $stmtCodigo->fetch(PDO::FETCH_ASSOC);
			$ultimoCodigo = $resultadoCodigo['max_codigo'] + 1;
        
		//agregar los valores
		if($datos["metodo_pago"]=="Crédito"){
     //preparar la insercion
            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos, impuesto, neto, total, metodo_pago, saldo_pendiente, descuento, idmesa, observaciones) VALUES (:codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago, :total, :descuento, :idmesa, :observaciones)");

			$stmt->bindParam(":codigo", $ultimoCodigo, PDO::PARAM_INT);
			//$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
			$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
			$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
			$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
			$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
			$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
			$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
			$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
			$stmt->bindParam(":saldo_pendiente", $datos["total"], PDO::PARAM_STR);
			$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
			$stmt->bindParam(":idmesa", $datos["idmesa"], PDO::PARAM_INT);
			$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		}else{
			
        //preparar la insercion
		    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos, impuesto, neto, total, metodo_pago, descuento, idmesa, observaciones) VALUES (:codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago, :descuento, :idmesa, :observaciones)");
			$stmt->bindParam(":codigo", $ultimoCodigo, PDO::PARAM_INT);
			//$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
			$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
			$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
			$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
			$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
			$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
			$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
			$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
			$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
			$stmt->bindParam(":idmesa", $datos["idmesa"], PDO::PARAM_INT);
			$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		}

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

	} catch (PDOException $e) {
        return false;
    }

		$stmt->close();
		$stmt = null;


	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function mdlEditarVenta($tabla, $datos){

		//agregar los valores
		if($datos["metodo_pago"]=="Crédito"){
			//preparar la insercion

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago, saldo_pendiente = :saldo_pendiente, descuento = :descuento, idmesa = :idmesa, observaciones = :observaciones  WHERE codigo = :codigo");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":saldo_pendiente", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
		$stmt->bindParam(":idmesa", $datos["idmesa"], PDO::PARAM_INT);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);

		}else {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago, saldo_pendiente = :saldo_pendiente, descuento = :descuento, idmesa = :idmesa, observaciones = :observaciones WHERE codigo = :codigo");
        
	    $debe= 0;
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":saldo_pendiente", $debe, PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
		$stmt->bindParam(":idmesa", $datos["idmesa"], PDO::PARAM_INT);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		}

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}

		/*=============================================
	ABONAR CREDITO
	=============================================*/

	static public function mdlAbonarVenta($tabla, $datos){

		// Obtener el último abono
		$stmtAbonado1 = Conexion::conectar()->prepare("SELECT monto_abonado as abonado FROM $tabla WHERE id = :id");
		$stmtAbonado1->bindParam(":id", $datos['id'], PDO::PARAM_INT);
        $stmtAbonado1->execute();
		$resultadoAbonado = $stmtAbonado1->fetch(PDO::FETCH_ASSOC);
		$ultimoAbono = $resultadoAbonado['abonado'] + $datos["valor"];

		// obtener el total
		$stmtTotal = Conexion::conectar()->prepare("SELECT total as total FROM $tabla WHERE id = :id");
		$stmtTotal->bindParam(":id", $datos['id'], PDO::PARAM_INT);
        $stmtTotal->execute();
		$resultadoTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
		$totall = $resultadoTotal['total'];
        
		// verificar si el abono no supera la deuda
		if($ultimoAbono <= $totall )
		{
			// actualiza el estado del crédito a efectivo si el abono alcanza el valor total

			if($ultimoAbono == $totall) {
				$metodo_pago = "Efectivo";
				$debe = 0;
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET monto_abonado = :monto_abonado, metodo_pago = :metodo_pago, saldo_pendiente = :saldo_pendiente WHERE id = :id");
				$stmt->bindParam(":metodo_pago", $metodo_pago, PDO::PARAM_STR);
				$stmt->bindParam(":saldo_pendiente", $debe, PDO::PARAM_STR);
				$stmt->bindParam(":monto_abonado", $debe, PDO::PARAM_STR);
				
			} else {
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET monto_abonado = :monto_abonado WHERE id = :id");
				$stmt->bindParam(":monto_abonado", $ultimoAbono, PDO::PARAM_STR);
			}
	
			
			$stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
				
	
			if($stmt->execute()) {
				$stmt->closeCursor(); // Cerrar el cursor después de la ejecución
				return "ok";
			} else {
				$stmt->closeCursor(); // Cerrar el cursor en caso de error también
				return "error";
			}
		}else{
			return "super";
		}

		$stmt = null;

	}

	/*=============================================
	PAGAR CREDITO
	=============================================*/

	static public function mdlPagarVenta($tabla, $valor){

		// obtener el total
		$stmtTotal = Conexion::conectar()->prepare("SELECT total as total FROM $tabla WHERE id = :id");
		$stmtTotal->bindParam(":id", $valor, PDO::PARAM_INT);
        $stmtTotal->execute();
		$resultadoTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
		$debe = 0;
        
		
			$metodo_pago = "Efectivo";
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET monto_abonado = :monto_abonado, metodo_pago = :metodo_pago, saldo_pendiente = :saldo_pendiente WHERE id = :id");
			$stmt->bindParam(":metodo_pago", $metodo_pago, PDO::PARAM_STR);
			$stmt->bindParam(":monto_abonado", $debe, PDO::PARAM_STR);
			$stmt->bindParam(":saldo_pendiente", $debe, PDO::PARAM_STR);
			$stmt->bindParam(":id", $valor, PDO::PARAM_INT);
				
	
			if($stmt->execute()) {
				$stmt->closeCursor(); // Cerrar el cursor después de la ejecución
				return "ok";
			} else {
				$stmt->closeCursor(); // Cerrar el cursor en caso de error también
				return "error";
			}

		$stmt = null;

	}
	/*=============================================
	ELIMINAR VENTA 
	=============================================*/

	static public function mdlEliminarVenta($tabla, $datos){

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
	RANGO FECHAS PARA MOSTRAR VENTAS
	=============================================*/	

	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){
        
		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE DATE(fecha) = CURRENT_DATE() ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	 


		}else if($fechaInicial == $fechaFinal){
			$fechaInicial .= ' 00:00:01';
            $fechaFinal .= ' 23:59:59';
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN :fechaInicial AND :fechaFinal");

			$stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
            
			$stmt->bindParam(":fechaFinal", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{
            $fechaFinal .= ' 23:59:59';

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$fechaInicial .= ' 00:00:01';
                $fechaFinalMasUno .= ' 23:59:59';
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");

			}else{
				$fechaInicial .= ' 00:00:01';
                $fechaFinal .= ' 23:59:59';

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");

			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	/*=============================================
	RANGO FECHAS PARA MOSTRAR VENTAS CREDITOS
	=============================================*/	

	static public function mdlVentasCreditos($tabla){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE metodo_pago= 'Crédito' ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	 

	}

	/*=============================================
	RANGO FECHAS REPORTE DE VENTAS
	=============================================*/	

	static public function mdlRangoFechasVentas2($tabla, $fechaInicial, $fechaFinal){
        
		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE DATE(fecha) = CURRENT_DATE() AND metodo_pago IN ('Efectivo','Nequi') ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	 


		}else if($fechaInicial == $fechaFinal){
			$fechaInicial .= ' 00:00:01';
            $fechaFinal .= ' 23:59:59';
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN :fechaInicial AND :fechaFinal AND metodo_pago IN ('Efectivo','Nequi')");

			$stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
            
			$stmt->bindParam(":fechaFinal", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{
            $fechaFinal .= ' 23:59:59';

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$fechaInicial .= ' 00:00:01';
                $fechaFinalMasUno .= ' 23:59:59';
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' AND metodo_pago IN ('Efectivo','Nequi')");

			}else{
				$fechaInicial .= ' 00:00:01';
                $fechaFinal .= ' 23:59:59';

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal' AND metodo_pago IN ('Efectivo','Nequi')");

			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}
	

	/*===============================================================================
	SUMAR EL TOTAL DE VENTAS EFECTIVO CAJA SUPERIOR REPORTE FINAL POR RANGO DE FECHAS
	=================================================================================*/

	static public function mdlRangoventasf($tabla, $fechaInicial, $fechaFinal){	
		try {
			 // Si las fechas son nulas, usar el día actual
			 if (is_null($fechaInicial) && is_null($fechaFinal)) {
				$fechaInicial = date('Y-m-d') . ' 00:00:01';
				$fechaFinal = date('Y-m-d') . ' 23:59:59';
			} else {
				// Agregar las horas para abarcar el día completo
				$fechaInicial .= ' 00:00:01';
				$fechaFinal .= ' 23:59:59';
			}
			// Preparar la consulta con parámetros de fechas
			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla WHERE metodo_pago = 'Efectivo' AND fecha BETWEEN :fechaInicial AND :fechaFinal");
	
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

		/*===============================================================================
	VERIFICAR VALOR DE MESA PENDIENTE
	=================================================================================*/

	static public function mdlmesas($tablaVentas, $tablaMesas, $idmesa){	
		try {
			 // Preparar la consulta con el JOIN entre las tablas ventas y mesas
			 $stmt = Conexion::conectar()->prepare("
			 SELECT SUM(total) as total, m.estado, cventa
			 FROM $tablaVentas v
			 INNER JOIN $tablaMesas m ON v.codigo = m.cventa
			 WHERE v.metodo_pago = 'Pendiente' AND v.idmesa = :idmesa AND m.estado = 1
		 ");
	
			// Vincular parámetros
			$stmt->bindParam(":idmesa", $idmesa, PDO::PARAM_INT);
	
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

	/*===============================================================================
	SUMAR EL TOTAL DE VENTAS CREDITO CAJA SUPERIOR REPORTE FINAL POR RANGO DE FECHAS
	=================================================================================*/

	static public function mdlRangocreditof($tabla, $fechaInicial, $fechaFinal){	
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
			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla WHERE metodo_pago = 'Crédito' AND fecha BETWEEN :fechaInicial AND :fechaFinal");
	
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

		/*===============================================================================
	SUMAR EL TOTAL DE VENTAS CREDITO ABONADO CAJA SUPERIOR REPORTE FINAL POR RANGO DE FECHAS
	=================================================================================*/

	static public function mdlRangocreditofabonado($tabla, $fechaInicial, $fechaFinal){	
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
			$stmt = Conexion::conectar()->prepare("SELECT SUM(monto_abonado) as total FROM $tabla WHERE metodo_pago = 'Crédito' AND fecha BETWEEN :fechaInicial AND :fechaFinal");
	
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
	

	/*===============================================================================
	SUMAR EL TOTAL DE VENTAS NEQUI CAJA SUPERIOR REPORTE FINAL POR RANGO DE FECHAS
	=================================================================================*/

	static public function mdlRangonequif($tabla, $fechaInicial, $fechaFinal){	
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
			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla WHERE metodo_pago = 'Nequi' AND fecha BETWEEN :fechaInicial AND :fechaFinal");
	
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


	/*=============================================
	REPORTE PRINCIPAL PARA EL GRAFICO SUMA EFECTIVO, NEQUI
	=============================================*/	

	static public function mdlRangoF($tabla){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE DATE(fecha) >= DATE( NOW()) AND metodo_pago IN ('Efectivo','Nequi') ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	 


	}

	/*=============================================
	REPORTE FINAL PARA EL GRAFICO SUMA EFECTIVO, NEQUI
	=============================================*/	

	static public function mdlRangoFF($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE metodo_pago IN ('Efectivo','Nequi') ORDER BY id DESC");

		$stmt -> execute();

		return $stmt -> fetchAll();	 


}
	/*=============================================
	SUMAR EL TOTAL DE VENTAS EFECTIVO REPORTE FINAL
	=============================================*/

	static public function mdlSumaTotalVentas($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla where metodo_pago= 'Efectivo'");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	SUMAR EL TOTAL DE VENTAS CREDITOS REPORTE FINAL
	=============================================*/

	static public function mdlSumaTotalCreditos($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla where metodo_pago= 'Crédito'");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	SUMAR EL TOTAL DE VENTAS CREDITOS ABONADOS REPORTE FINAL
	=============================================*/

	static public function mdlSumaTotalCreditosab($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(monto_abonado) as total FROM $tabla where metodo_pago= 'Crédito'");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	
	
		/*=============================================
	SUMAR EL TOTAL DE VENTAS NEQUI REPORTE FINAL
	=============================================*/

	static public function mdlSumaTotalNequi($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla where metodo_pago= 'Nequi'");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	
	
}