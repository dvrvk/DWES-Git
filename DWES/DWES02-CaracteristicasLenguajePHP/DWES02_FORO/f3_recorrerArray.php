<?php
    // Recorrer un array
    $modulos = [
        "DWEC" => 115,
        "DWES" => 180,
        "IT" => 40,
        "EIE" => 65
    ];

    $totalHoras = 0;
    foreach($modulos as $modulo=>$horas) {
        $totalHoras += $horas;
        echo "Módulo: ${modulo}, horas: ${horas} <br>";
    }

    echo "Total horas ${totalHoras}";