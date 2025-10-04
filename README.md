# nombre de la aplicacion
sistema pos para un restaurante, permite el manejo de ventas, clientes, inventario de productos reportes, tickets, pdf, excel y muchas funciones mas.

## Funcionalidades
- # 1 inicio secion por tres tipos de usuarios administrador, especial y vendedor cada uno con diferentes rol
   si no existe el usuario debe de mostrar un mensaje de Error al ingresar, vuelva a intentarlo
- # 2 al ingresar se encuentra el panel inicial de control donde puedes visualizar
  - el total de las ventas del dia, los gastos, ventas creditos, pagos por nequi, abonos a las ventas credito
  - y el total valor entre lo efectivo, nequi, abono - gastos
  - tambien una grafica del mismo valor
  - una lista con grafico de los productos mas vendidos
  - una lista de productos recien agregados
  - si le das click a cualquier caja en más info te dirige a admistrar ventas
- # 3 tablero de mesas: es un total de 16 mesas de color azul disponibles en cero al darle click en una de
   - ellas te dirige al registro de una venta, si la venta se seleciona pendiente la mesa se pone en rojo
   - se imprime un ticket para el chef y se visualiza el total del valor de la venta
   - si volvemos a ingresar en esa mesa podemos ver los datos de la venta y podemos agregar datos o cambiar
   - la informacion cuando la venta cambia de metodo de pago la mesa ya cambia de estado y imprime los dos 
   - tickets
- # 4 administrar usuarios 
   - podemos registrar usuarios con diferentes roles, visualizarlos, editarlos, activarlos,
   - desactivarlos y eliminarlos
- # 5 admistrar gastos se puede realizar el crud
- # 6 Administrar categorias se puede realizar el crud
- # 7 administrar producto se puede realizar el crud 
   - el producto lleva categoria, codigo, descripsion, stock maximo, cantidad en bodega, precio de compra
   - precio de venta, agregar imagen, y cambia de calor su cantidad a medida que se vaya agotando como
   - advertencia
   # 8 lo mismo para ver los productos rojos
   # 9 administrar clientes permite crud de clientes
   # 10 administrar ventas permite el crud, abonar a credito, pagar credito total, ver pdf o ticket
   - podemos ver solo las ventas credito si se quiere
   # 11 crear venta se ingresa cliente, mesa si gusta , agregar productos, iva, dsecuento, selecion metodo de
   - pago si el producto esta agotado no permite ingresar, si no seleciona producto tampoco, si el metodo esta
   - pendiente inicia el proceso de las mesas
   # 12 reportes de ventas puedes visualizar el total de las ventas, graficos, prodcutos mas endidos compradores y vendedores por rango de fecha.

# intalaciones xamp, impresora pos de 80mm configurar controladores, poner ip fija, configuerar servidor
- en ocaciones por regla de xamp por temas de firewall

nota de posibles errores con su soluction
si al crear un usuario nuevo o producto y no permite la imagen, se debe de activar en el php.ini 
Habilita la extensión GD en PHP:
Abre el archivo php.ini (lo encontrarás en la carpeta de configuración de tu servidor XAMPP, normalmente en C:\xampp\php\php.ini).
Busca la línea que dice ;extension=gd o ;extension=gd2.
Quita el punto y coma (;) al inicio de la línea para descomentarla, dejándola así:
ini
Copiar código
extension=gd
Reinicia XAMPP:
Después de guardar los cambios en el archivo php.ini, reinicia Apache desde el panel de control de XAMPP para aplicar la configuración.
Después de hacer esto, la función imagecreatefrompng() debería funcionar correctamente.

para que dectecte la impresora se debe conectar y agregar de forma manual con el nombre de POS-80C

para que tome las impresiones se dbe de instalar las impresoras y configurar de forma virtual tambien

la direcion ip debe ser fija en caso tal se conectaran otros dispositivos al servidor 
recordar que la direcion de internet es con los digitos 8
si en caso tal no permite el servidor toca agregar la regla en el firewall

para los datos reales de las ventas en y en los cabezotes principales toca veririfcar la zona horaria del servidor que sea igual al equipo
por que si verificamos la zona horaria en un archivo 'la zona horaria: ' . date_default_timezone_get(); nos muestra por defecto echo la zona horaria: Europe/Berlin
toca cambiarla en el archivo php.ini search this: date.timezone = America/Bogota

problema de impimir tickect y pdf tocaba actualizar la carpeta tcpdf exactamente el archivo tcpdf, tcpdf_barcodes_1d, tcpdf_static, tcpdf_images listo

el error despues de realizar venta si estaba en la linea 126 como mostraba el mensaje y se modifico la linea poniendo el - al final

la impresora par que sea modo bidirecional tiene que ser version -4 y no -3  en regedy se pude ver w+r y regedy

actualize fontawesome descargando el archivo y remplazando el actual ubicado en link rel="stylesheet" href="vistas/bower_components/font-awesome/ lo puedes ver en la plantilla su uso

////////////por que no cargan las imagenes al crear un producto o editarlo/////////////////////////
1: la extensión GD no está habilitada.

2 habilitar:
Abre el archivo: C:\xampp\php\php.ini
Busca esta línea (usa Ctrl + F):
;extension=gd
Quita el punto y coma ; al inicio, debe quedar así:
extension=gd
En algunas versiones aparece como:
;extension=gd2
extension=gd2
Guarda los cambios en el archivo php.ini.
Reinicia Apache
Verifica que GD esté activa
Crea un archivo llamado info.php dentro de tu carpeta htdocs con este contenido:
<?php
phpinfo();
?>
Abre en tu navegador:
http://localhost/info.php
Busca “GD Support”.
Si aparece enabled, ¡todo está bien configurado!