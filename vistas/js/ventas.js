/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/

// $.ajax({

// 	url: "ajax/datatable-ventas.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })// 

$('.tablaVentas').DataTable( {
    "ajax": "ajax/datatable-ventas.ajax.php",
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	}

} );

/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/

$(".tablaVentas tbody").on("click", "button.agregarProducto", function(){

	var idProducto = $(this).attr("idProducto");

	$(this).removeClass("btn-primary agregarProducto");

	$(this).addClass("btn-default");

	var datos = new FormData();
    datos.append("idProducto", idProducto);

     $.ajax({

     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){

      	    var descripcion = respuesta["descripcion"];
          	var stock = respuesta["stock"];
          	var precio = respuesta["precio_venta"];

          	/*=============================================
          	EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
          	=============================================*/

          	if(stock == 0){

      			swal({
			      title: "No hay stock disponible",
			      type: "error",
			      confirmButtonText: "¡Cerrar!"
			    });

			    $("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");

			    return;

          	}

          	$(".nuevoProducto").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del producto -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+

	              '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del producto -->'+

	          '<div class="col-xs-3">'+
	            
	             '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock="'+stock+'" nuevoStock="'+Number(stock-1)+'" required>'+

	          '</div>' +

	          '<!-- Precio del producto -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioProducto" onchange="cambios()" precioReal="'+precio+'" name="nuevoPrecioProducto" value="'+precio+'" required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>') 

	        // SUMAR TOTAL DE PRECIOS

	        sumarTotalPrecios()

	        // AGREGAR IMPUESTO

	        agregarImpuesto()

	        // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 2);


			localStorage.removeItem("quitarProducto");

      	}

     })

});

function cambios(){
	sumarTotalPrecios();

	        // AGREGAR IMPUESTO

	        agregarImpuesto();

	        // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos();
}

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaVentas").on("draw.dt", function(){

	if(localStorage.getItem("quitarProducto") != null){

		var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));

		for(var i = 0; i < listaIdProductos.length; i++){

			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');
			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');

		}


	}


})


/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProducto = [];

localStorage.removeItem("quitarProducto");

$(".formularioVenta").on("click", "button.quitarProducto", function(){

	$(this).parent().parent().parent().parent().remove();

	var idProducto = $(this).attr("idProducto");

	/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/

	if(localStorage.getItem("quitarProducto") == null){

		idQuitarProducto = [];
	
	}else{

		idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

	}

	idQuitarProducto.push({"idProducto":idProducto});

	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

	$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');

	$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');

	if($(".nuevoProducto").children().length == 0){

		$("#nuevoImpuestoVenta").val(0);
		$("#nuevoTotalVenta").val(0);
		$("#totalVenta").val(0);
		$("#nuevoTotalVenta").attr("total",0);

	}else{

		// SUMAR TOTAL DE PRECIOS

    	sumarTotalPrecios()

    	// AGREGAR IMPUESTO
	        
        agregarImpuesto()

        // AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductos()

	}

})

/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/

var numProducto = 0;

$(".btnAgregarProducto").click(function(){

	numProducto ++;

	var datos = new FormData();
	datos.append("traerProductos", "ok");

	$.ajax({

		url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	    	$(".nuevoProducto").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del producto -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>'+

	              '<select class="form-control nuevaDescripcionProducto" id="producto'+numProducto+'" idProducto name="nuevaDescripcionProducto" required>'+

	              '<option>Seleccione el producto</option>'+

	              '</select>'+  

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del producto -->'+

	          '<div class="col-xs-3 ingresoCantidad">'+
	            
	             '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="0" stock nuevoStock required>'+

	          '</div>' +

	          '<!-- Precio del producto -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioProducto" precioReal="" name="nuevoPrecioProducto" required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>');


	        // AGREGAR LOS PRODUCTOS AL SELECT 

	         respuesta.forEach(funcionForEach);

	         function funcionForEach(item, index){

	         	if(item.stock != 0){

		         	$("#producto"+numProducto).append(

						'<option idProducto="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'
		         	)

		         
		         }	         

	         }

        	 // SUMAR TOTAL DE PRECIOS

    		sumarTotalPrecios()

    		// AGREGAR IMPUESTO
	        
	        agregarImpuesto()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 2);


      	}

	})

})

/*=============================================
SELECCIONAR PRODUCTO
=============================================*/

$(".formularioVenta").on("change", "select.nuevaDescripcionProducto", function(){

	var nombreProducto = $(this).val();

	var nuevaDescripcionProducto = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionProducto");

	var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");

	var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);


	  $.ajax({

     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	     $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
      	    $(nuevaCantidadProducto).attr("stock", respuesta["stock"]);
      	    $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stock"])-1);
      	    $(nuevoPrecioProducto).val(respuesta["precio_venta"]);
      	    $(nuevoPrecioProducto).attr("precioReal", respuesta["precio_venta"]);

  	      // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos()

      	}

      })
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioVenta").on("change", "input.nuevaCantidadProducto", function(){

	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var precioFinal = $(this).val() * precio.attr("precioReal");
	
	precio.val(precioFinal);

	var nuevoStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("nuevoStock", nuevoStock);

	if(Number($(this).val()) > Number($(this).attr("stock"))){

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/

		$(this).val(0);

		$(this).attr("nuevoStock", $(this).attr("stock"));

		var precioFinal = $(this).val() * precio.attr("precioReal");

		precio.val(precioFinal);

		sumarTotalPrecios();

		swal({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock")+" unidades!",
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });

	    return;

	}

	// SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()

	// AGREGAR IMPUESTO
	        
    agregarImpuesto()

    // AGRUPAR PRODUCTOS EN FORMATO JSON

    listarProductos()

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPrecios(){

	var precioItem = $(".nuevoPrecioProducto");
	
	var arraySumaPrecio = [];  

	for(var i = 0; i < precioItem.length; i++){

		 arraySumaPrecio.push(Number($(precioItem[i]).val()));
		
		 
	}

	function sumaArrayPrecios(total, numero){

		return total + numero;

	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	
	$("#nuevoTotalVenta").val(sumaTotalPrecio);
	$("#totalVenta").val(sumaTotalPrecio);
	$("#nuevoTotalVenta").attr("total",sumaTotalPrecio);


}

/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/

function agregarImpuesto(){

	var impuesto = $("#nuevoImpuestoVenta").val();
	var precioTotal = $("#nuevoTotalVenta").attr("total");
	var descuento = Number($("#nuevodescuento").val());

	var precioImpuesto = Number(precioTotal * impuesto/100);

	var totalConImpuesto = (Number(precioImpuesto) + Number(precioTotal))- descuento;
	
	$("#nuevoTotalVenta").val(totalConImpuesto);

	$("#totalVenta").val(totalConImpuesto);

	$("#nuevoPrecioImpuesto").val(precioImpuesto);

	$("#nuevoPrecioNeto").val(precioTotal);

}

/*=============================================
FUNCIÓN AGREGAR DESCUENTO
=============================================*/

function agregarDescuento(){

	 // Obtener el valor del descuento mas impuesto y el total actual
	 var impuesto = $("#nuevoImpuestoVenta").val();
	 var precioTotal = Number($("#nuevoTotalVenta").attr("total"));
	 var precioImpuesto = Number(precioTotal * impuesto/100);
	 var descuento = Number($("#nuevodescuento").val());


	 // Calcular el nuevo total con el descuento aplicado
	var totalConDescuento  = (Number(precioTotal) + Number(precioImpuesto)) - descuento;

	// Asegurarse de que el total no sea negativo
    if(totalConDescuento < 0) {
        totalConDescuento = 0;
    } 
	
	 // Actualizar los valores en los campos correspondientes
	 $("#nuevoTotalVenta").val(totalConDescuento.toFixed(2));
	 $("#totalVenta").val(totalConDescuento.toFixed(2));
	 $("#nuevoPrecioNeto").val(precioTotal.toFixed(2));

}

/*=============================================
FUNCIÓN VALIDAR MESA PENDIENTE
=============================================*/
// Función para validar la selección de mesa según el método de pago
function validarSeleccionMesa() {
    const seleccionarMesa = document.getElementById("seleccionarMesa");
    const nuevoMetodoPago = document.getElementById("nuevoMetodoPago");
	const listaMetodoPago = document.getElementById("listaMetodoPago");

	// Copia el valor seleccionado en listaMetodoPago cuando se cargue la página
    listaMetodoPago.value = nuevoMetodoPago.value;

	// Escuchamos el evento de cambio en el campo de método de pago
    nuevoMetodoPago.addEventListener("change", function() {
		listaMetodoPago.value = this.value;
        // Verificamos si el método de pago es "Pendiente"
        if (this.value === "Pendiente") {
            seleccionarMesa.required = true; // Hacemos que la mesa sea obligatoria
        } else {
            seleccionarMesa.required = false; // Quitamos la obligatoriedad de la mesa
        }
    });
}

// Llamada a las funciones cuando el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function() {
    validarSeleccionMesa();  // Activar validación de selección de mesa según el método de pago
});


/*=============================================
CUANDO CAMBIA EL DESCUENTO
=============================================*/

$("#nuevodescuento").change(function(){

	agregarDescuento();

});

/*=============================================
CUANDO CAMBIA EL IMPUESTO
=============================================*/

$("#nuevoImpuestoVenta").change(function(){

	agregarImpuesto();

});


/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/

$("#nuevoTotalVenta").number(true, 2);

/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/

$("#nuevoMetodoPago").change(function(){

	var metodo = $(this).val();

	if(metodo == "Efectivo"){

		$(this).parent().parent().removeClass("col-xs-6").addClass("col-xs-4");

		$(this).parent().parent().parent().children(".cajasMetodoPago").html(

			 '<div class="col-xs-4">'+ 

			 	'<div class="input-group">'+ 

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+ 

			 		'<input type="text" class="form-control" id="nuevoValorEfectivo" value="0" required>'+

			 	'</div>'+

			 '</div>'+

			 '<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">'+

			 	'<div class="input-group">'+

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

			 		'<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>'+

			 	'</div>'+

			 '</div>'

		 );

		// Agregar formato al precio

		$('#nuevoValorEfectivo').number( true, 2);
      	$('#nuevoCambioEfectivo').number( true, 2);


	} else {
		 // Restablecer el diseño si no es efectivo
		 $(this).parent().parent().removeClass('col-xs-4').addClass('col-xs-6');
		 $(this).parent().parent().parent().children('.cajasMetodoPago').html('');
	}

	// Listar método en la entrada, independientemente de cuál sea
	listarMetodos();

	// else{

	// 	$(this).parent().parent().removeClass('col-xs-4');

	// 	$(this).parent().parent().addClass('col-xs-6');

	// 	 $(this).parent().parent().parent().children('.cajasMetodoPago').html(

	// 	 	'<div class="col-xs-6" style="padding-left:0px">'+
                        
    //             '<div class="input-group">'+
                     
    //               '<input type="number" min="0" class="form-control" id="nuevoCodigoTransaccion" placeholder="Código transacción" required>'+
                       
    //               '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
                  
    //             '</div>'+

    //           '</div>')

	// }

	

});

/*=============================================
CAMBIO EN EFECTIVO
=============================================*/
$(".formularioVenta").on("change", "input#nuevoValorEfectivo", function(){

	var efectivo = $(this).val();

	var cambio =  Number(efectivo) - Number($('#nuevoTotalVenta').val());

	var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');

	nuevoCambioEfectivo.val(cambio);

})

/*=============================================
CAMBIO TRANSACCIÓN
=============================================*/
// $(".formularioVenta").on("change", "input#nuevoCodigoTransaccion", function(){

// 	// Listar método en la entrada
//      listarMetodos()


// })


/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductos(){

	var listaProductos = [];

	var descripcion = $(".nuevaDescripcionProducto");

	var cantidad = $(".nuevaCantidadProducto");

	var precio = $(".nuevoPrecioProducto");

	for(var i = 0; i < descripcion.length; i++){

		listaProductos.push({ "id" : $(descripcion[i]).attr("idProducto"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "stock" : $(cantidad[i]).attr("nuevoStock"),
							  "precio" : $(precio[i]).attr("precioReal"),
							  "total" : $(precio[i]).val()})

	}

	$("#listaProductos").val(JSON.stringify(listaProductos)); 

}

/*=============================================
LISTAR MÉTODO DE PAGO
=============================================*/

function listarMetodos(){

    // Guardar el valor seleccionado tal como está
	var metodoPago = $("#nuevoMetodoPago").val();
	$("#listaMetodoPago").val(metodoPago);

}

/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEditarVenta", function(){

	var idVenta = $(this).attr("idVenta");

	window.location = "index.php?ruta=editar-venta&idVenta="+idVenta;


})

// BOTÓN EDITAR VENTA PARA LAS MESAS
$(document).on("click", ".btnEditarVentaM", function(event) {
    event.preventDefault(); // Previene el comportamiento predeterminado del enlace

    // Obtiene el código de venta
    var codigoVenta = $(this).attr("codigoVenta");
    console.log("Código de Venta:", codigoVenta); // Para verificar si se captura correctamente

    // Redirige a la ruta de edición si el código de venta existe
    if (codigoVenta) {
        window.location = "index.php?ruta=editar-venta&codigoVenta=" + codigoVenta;
    } else {
        window.location = "index.php?ruta=crear-venta"; // Redirige a la página de crear venta Si no hay código de venta
    }
	
});
/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarProducto(){

	//Capturamos todos los id de productos que fueron elegidos en la venta
	var idProductos = $(".quitarProducto");

	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaVentas tbody button.agregarProducto");

	//Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
	for(var i = 0; i < idProductos.length; i++){

		//Capturamos los Id de los productos agregados a la venta
		var boton = $(idProductos[i]).attr("idProducto");
		
		//Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
		for(var j = 0; j < botonesTabla.length; j ++){

			if($(botonesTabla[j]).attr("idProducto") == boton){

				$(botonesTabla[j]).removeClass("btn-primary agregarProducto");
				$(botonesTabla[j]).addClass("btn-default");

			}
		}

	}
	
}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaVentas').on( 'draw.dt', function(){

	quitarAgregarProducto();

})


/*=============================================
BORRAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEliminarVenta", function(){

  var idVenta = $(this).attr("idVenta");

  swal({
        title: '¿Está seguro de borrar la venta?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar venta!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=ventas&idEliminarVenta="+idVenta;
        }

  })

})

/*=============================================
IMPRIMIR VENTA
=============================================*/

$(document).ready(function () {
    let params = new URLSearchParams(window.location.search);

    if (params.has("idImprimirVenta2")) {
		console.log("Bloque idImprimirVenta2 ejecutado");
        var cventa = params.get("idImprimirVenta2");

        swal({
            title: "Imprimiendo Ticket para el Chef",
            text: "Espere un momento mientras se imprime...",
            icon: "info",
            buttons: false,
            timer: 3000
        }).then(function () {
            swal({
                title: "Impresión Lista y Mesa Ocupada",
                icon: "success",
                button: "Cerrar"
            }).then(function () {
                window.location = "mesas";
            });
        });
    } else if (params.has("idImprimirVenta")) {
		console.log("Bloque idImprimirVenta ejecutado");
        var cventa = params.get("idImprimirVenta");

        swal({
            title: "Imprimiendo Venta",
            text: "Espere un momento mientras se imprime...",
            icon: "info",
            buttons: false,
            timer: 3000
        }).then(function () {
            swal({
                title: "La impresión se ha realizado correctamente",
                icon: "success",
                button: "Cerrar"
            }).then(function () {
                window.location = "mesas";
            });
        });
    } else if (params.has("idImprimirVenta3")) {
        console.log("Bloque idImprimirVenta3 ejecutado");
        var cventa = params.get("idImprimirVenta3");

        swal({
            title: "Imprimiendo Ticket de Venta Finalizada",
            text: "Espere un momento mientras se imprime...",
            icon: "info",
            buttons: false,
            timer: 3000
        }).then(function () {
            swal({
                title: "El ticket se ha imprimido correctamente",
                icon: "success",
                button: "Cerrar"
            }).then(function () {
                window.location = "mesas";
            });
        });
    }
	 // Realizar cualquier otra acción relacionada con la impresión
     console.log("Proceso de impresión para la venta: " + cventa);
});

// $(document).ready(function () {
//     if (window.location.search.includes("idImprimirVenta")) {
//         var cventa = new URLSearchParams(window.location.search).get("idImprimirVenta");

//         swal({
// 			title: "Imprimiendo Venta",
// 			text: "Espere un momento mientras se imprime...",
// 			icon: "info", // Utiliza "icon" en lugar de "type"
// 			buttons: false, // No mostrar botones en este momento
// 			timer: 3000 // Tiempo en milisegundos (3 segundos)
//         }).then(function () {// Después de 3 segundos, mostrar el segundo mensaje y redirigir
// 			swal({
// 				title: "La impresión se ha realizado correctamente",
// 				icon: "success", // Icono de éxito
// 				button: "Cerrar" // Botón con texto "Cerrar"
// 			}).then(function () {
// 				// Redirigir a la página de mesas después de cerrar el mensaje
// 				window.location = "mesas";
// 			});
//         });

//         // Realizar cualquier otra acción relacionada con la impresión
//         // console.log("Proceso de impresión para la venta: " + cventa);
//     }
// })

// /*=============================================
// IMPRIMIR VENTA TICKET CHEF
// =============================================*/

// $(document).ready(function () {
//     if (window.location.search.includes("idImprimirVenta2")) {
//         var cventa = new URLSearchParams(window.location.search).get("idImprimirVenta2");

//         swal({
// 			title: "Imprimiendo Ticket para el Chef",
// 			text: "Espere un momento mientras se imprime...",
// 			icon: "info", // Utiliza "icon" en lugar de "type"
// 			buttons: false, // No mostrar botones en este momento
// 			timer: 3000 // Tiempo en milisegundos (3 segundos)
//         }).then(function () {// Después de 3 segundos, mostrar el segundo mensaje y redirigir
// 			swal({
// 				title: "Impresión lista y La mesa fue ocupada",
// 				icon: "success", // Icono de éxito
// 				button: "Cerrar" // Botón con texto "Cerrar"
// 			}).then(function () {
// 				// Redirigir a la página de mesas después de cerrar el mensaje
// 				window.location = "mesas";
// 			});
//         });

//         // Realizar cualquier otra acción relacionada con la impresión
//         // console.log("Proceso de impresión para la venta: " + cventa);
//     }
// })

/*=============================================
PAGAR VENTA
=============================================*/
$(".tablas").on("click", ".btnpagarcredito", function(){

	var idVenta = $(this).attr("idVenta");
  
	swal({
		  title: '¡Se procederá a pagar la totalidad de la venta.!',
		  text: "¡Si no está deacuerdo, puede cancelar la accíón!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#008000',
		  cancelButtonColor: '#d33',
		  cancelButtonText: 'Cancelar',
		  confirmButtonText: 'Si, pagar venta!'
		}).then(function(result){
		  if (result.value) {
			
			  window.location = "index.php?ruta=ventas&idPagarVenta="+idVenta;
		  }
  
	})
  
  })

/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click", ".btnImprimirFactura", function(){

	var codigoVenta = $(this).attr("codigoVenta");

	window.open("extensiones/tcpdf/pdf/factura.php?codigo="+codigoVenta, "_blank"); 

})

/*=============================================
IMPRIMIR Ticket
=============================================*/

$(".tablas").on("click", ".btnImprimirTicket", function(){

	var codigoVenta = $(this).attr("codigoVenta");

	window.open("extensiones/tcpdf/pdf/ticket.php?codigo="+codigoVenta, "_blank"); 

})

/*=============================================
RANGO DE FECHAS
=============================================*/

$('#daterange-btn').daterangepicker(
  {
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');

    var fechaFinal = end.format('YYYY-MM-DD');

    var capturarRango = $("#daterange-btn span").html();
   
   	localStorage.setItem("capturarRango", capturarRango);

   	window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

  }

)

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("capturarRango");
	localStorage.clear();
	window.location = "ventas";
})

/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click", function(){

	var textoHoy = $(this).attr("data-range-key");

	if(textoHoy == "Hoy"){

		var d = new Date();
		
		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();

		// if(mes < 10){

		// 	var fechaInicial = año+"-0"+mes+"-"+dia;
		// 	var fechaFinal = año+"-0"+mes+"-"+dia;

		// }else if(dia < 10){

		// 	var fechaInicial = año+"-"+mes+"-0"+dia;
		// 	var fechaFinal = año+"-"+mes+"-0"+dia;

		// }else if(mes < 10 && dia < 10){

		// 	var fechaInicial = año+"-0"+mes+"-0"+dia;
		// 	var fechaFinal = año+"-0"+mes+"-0"+dia;

		// }else{

		// 	var fechaInicial = año+"-"+mes+"-"+dia;
	 //    	var fechaFinal = año+"-"+mes+"-"+dia;

		// }

		dia = ("0"+dia).slice(-2);
		mes = ("0"+mes).slice(-2);

		var fechaInicial = año+"-"+mes+"-"+dia;
		var fechaFinal = año+"-"+mes+"-"+dia;	

    	localStorage.setItem("capturarRango", "Hoy");

    	window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

	}

})

/*=============================================
ABRIR ARCHIVO XML EN NUEVA PESTAÑA
=============================================*/

$(".abrirXML").click(function(){

	var archivo = $(this).attr("archivo");
	window.open(archivo, "_blank");


})

/*=============================================
ABONAR VENTA
=============================================*/
$(".tablas").on("click", ".btnabonarcredito", function(){
	
	var idVenta = $(this).attr("idVenta");

	var datos = new FormData();
    datos.append("idVenta", idVenta);
	
    $.ajax({

      url:"ajax/ventas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
		   $("#idVenta").val(respuesta["id"]);
	       $("#saldop").val(respuesta["saldo_pendiente"]-respuesta["monto_abonado"]);
		//    console.log("respuesta", respuesta);
	  }

  	})

});

