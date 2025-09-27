
/*=============================================
EDITAR GASTO
=============================================*/
$(".tablas").on("click", ".btnEditarGasto", function(){

	var idGasto = $(this).attr("idGasto");

	var datos = new FormData();
    datos.append("idGasto", idGasto);

    $.ajax({

      url:"ajax/gastos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      
      	   $("#idGasto").val(respuesta["id"]);
	       $("#editarValor").val(respuesta["valor"]);
	       $("#editarDescripcion").val(respuesta["descripcion"]);
	  }

  	})

});


// /*=============================================
// ELIMINAR GASTO
// =============================================*/

$(".tablas").on("click", "button.btnEliminarGasto", function(){

	var idGasto = $(this).attr("idGasto");
	
	swal({

		title: '¿Está seguro de borrar el gasto?',
		text: "¡Si no lo está puede cancelar la accíón!",
		type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar gasto!'
        }).then(function(result) {
        if (result.value) {

        	window.location = "index.php?ruta=gastos&idGasto="+idGasto;

        }


	})

});
	
