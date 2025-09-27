<?php

$item = null;
$valor = null;
$orden = "id";
$fechaInicial = null;
$fechaFinal = null;

// VER TOTAL DE MESA #1
// Consultas individuales para cada mesa
$mesa1 = ControladorVentas::ctrmesas(1);
$mesa2 = ControladorVentas::ctrmesas(2);
$mesa3 = ControladorVentas::ctrmesas(3);
$mesa4 = ControladorVentas::ctrmesas(4);
$mesa5 = ControladorVentas::ctrmesas(5);
$mesa6 = ControladorVentas::ctrmesas(6);
$mesa7 = ControladorVentas::ctrmesas(7);
$mesa8 = ControladorVentas::ctrmesas(8);
$mesa9 = ControladorVentas::ctrmesas(9);
$mesa10 = ControladorVentas::ctrmesas(10);
$mesa11 = ControladorVentas::ctrmesas(11);
$mesa12 = ControladorVentas::ctrmesas(12);
$mesa13 = ControladorVentas::ctrmesas(13);
$mesa14 = ControladorVentas::ctrmesas(14);
$mesa15 = ControladorVentas::ctrmesas(15);
$mesa16 = ControladorVentas::ctrmesas(16);

// Array con los datos de cada mesa para simplificar el código HTML
$mesas = [
    ["data" => $mesa1, "nombre" => "Mesa #1", "icono" => "fa-shrimp"],
    ["data" => $mesa2, "nombre" => "Mesa #2", "icono" => "fa-fish-fins"],
    ["data" => $mesa3, "nombre" => "Mesa #3", "icono" => "fa-plate-wheat"],
    ["data" => $mesa4, "nombre" => "Mesa #4", "icono" => "fa-pizza-slice"],
    ["data" => $mesa5, "nombre" => "Mesa #5", "icono" => "fa-drumstick-bite"],
    ["data" => $mesa6, "nombre" => "Mesa #6", "icono" => "fa-burger"],
    ["data" => $mesa7, "nombre" => "Mesa #7", "icono" => "fa-ice-cream"],
    ["data" => $mesa8, "nombre" => "Mesa #8", "icono" => "fa-hotdog"],
    ["data" => $mesa9, "nombre" => "Mesa #9", "icono" => "fa-martini-glass-citrus"],
    ["data" => $mesa10, "nombre" => "Mesa #10", "icono" => "fa-champagne-glasses"],
    ["data" => $mesa11, "nombre" => "Mesa #11", "icono" => "fa-beer-mug-empty"],
    ["data" => $mesa12, "nombre" => "Mesa #12", "icono" => "fa-mug-hot"],
    ["data" => $mesa13, "nombre" => "Mesa #13", "icono" => "fa-bowl-food"],
    ["data" => $mesa14, "nombre" => "Mesa #14", "icono" => "fa-cookie"],
    ["data" => $mesa15, "nombre" => "Mesa #15", "icono" => "fa-bacon"],
    ["data" => $mesa16, "nombre" => "Mesa #16", "icono" => "fa-stroopwafel"]
];

// Iterar sobre las mesas para mostrar cada una con el color adecuado
// <button class="btn btn-warning btnEditarVenta" idVenta="'.$value["id"].'"><i class="fa fa-pencil"></i></button>
foreach ($mesas as $mesa) {
    if ($mesa["data"]) {
        $total = number_format($mesa["data"]["total"]);
        $nombreMesa = $mesa["nombre"];
        $icono = $mesa["icono"];
        
        // Definir color según el estado
        $color = ($mesa["data"]["estado"] == 1) ? "bg-red" : "bg-aqua";
        ?>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box <?php echo $color; ?>">
                <div class="inner">
                    <h3>$<?php echo $total; ?></h3>
                    <h4 style="font-weight: bold;"><?php echo $nombreMesa; ?></h4>
                </div>
                <div class="icon">
                    <i class="fa-solid <?php echo $icono; ?>"></i>
                </div>
                <?php if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor") : ?>
          
                    <a href="#" class="small-box-footer btnEditarVentaM" codigoVenta="<?php echo $mesa["data"]["cventa"]; ?>">
                    Más info <i class="fa fa-arrow-circle-right"></i>
                </a>

                <?php endif; ?>
               
            </div>
        </div>

        <?php
    }
}
?>

