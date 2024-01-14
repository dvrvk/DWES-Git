<?php
    // Conectar
    $db = mysqli_connect('localhost', 'root', 'admin', 'agenciaviajes');
    // Comprobar que se realiza correctamente la conexión
    if(!$db) {
        echo "Hubo un error";
        // Evitar que se ejecute más código
        exit;
    }
