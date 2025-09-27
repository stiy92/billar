<?php

class Conexion {

    static public function conectar() {
        try {
            $link = new PDO(
                "mysql:host=localhost;dbname=sis_billar",
                "root",
                "",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );

            $link->exec("set names utf8");
            return $link;

        } catch (PDOException $e) {

            // Puedes guardar el error en un archivo de log
            file_put_contents("errores.log", date("Y-m-d H:i:s") . " - DB Error: " . $e->getMessage() . "\n", FILE_APPEND);

            // Mostrar alerta visual al usuario
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error de conexión",
                    text: "No se pudo conectar con la base de datos. Contacta al administrador.",
                    confirmButtonText: "Cerrar"
                });
            </script>';

            exit(); // Detiene la ejecución del programa
        }
    }
}