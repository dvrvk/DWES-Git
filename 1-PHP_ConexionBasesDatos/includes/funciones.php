<?php

function obtener_viajes() {
    try {
        // Importar las credenciales
        require 'database.php';

        // Consulta SQL
        $sql = "SELECT * FROM viajes";

        // Realizar la consulta
        $consulta = mysqli_query($db, $sql);

        return $consulta;

    } catch (\Throwable $th) {
        var_dump($th);
    }
}