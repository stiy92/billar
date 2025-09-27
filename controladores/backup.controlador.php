<?php

if (isset($_POST['backup_db'])) {

    $host = "localhost";
    $usuario = "root"; // Cambia por tu usuario de MySQL
    $contrasena = "";  // Cambia por tu contraseña de MySQL
    $nombreBD = "sis_ferreteria"; // Cambia por el nombre real de tu BD

    $fecha = date("Y-m-d_H-i-s");
    $nombreArchivo = "backup_{$nombreBD}_{$fecha}.sql";
    $archivoRespaldo = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $nombreArchivo;

    // Ruta absoluta al mysqldump en XAMPP
    $mysqldumpPath = "C:\\xampp2\\mysql\\bin\\mysqldump.exe";

     // Comando SIN contraseña (porque no tienes)
    $comando = "\"$mysqldumpPath\" --user=$usuario --host=$host $nombreBD > \"$archivoRespaldo\"";

    // comando con contraseña (en caso que tengas)
    // $comando = "\"$mysqldumpPath\" --user=$usuario --password=\"$contrasena\" --host=$host $nombreBD > \"$archivoRespaldo\"";


    system($comando, $resultado);

    if ($resultado === 0 && file_exists($archivoRespaldo)) {

        // Forzar la descarga del archivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($nombreArchivo) . '"');
        header('Content-Length: ' . filesize($archivoRespaldo));
        readfile($archivoRespaldo);

        // Elimina el archivo temporal después de enviarlo
        unlink($archivoRespaldo);

        // Importante: detener la ejecución
        exit;

    } else {
        // Redirigir con error si falla
        header("Location: ../reportes.php?backup=error");
        exit;
    }
}