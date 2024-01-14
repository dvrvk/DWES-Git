<?php
$archivo = fopen("archivo.txt", "r");

// Leer el archivo línea por línea
while (!feof($archivo)) {
    $linea = fgets($archivo);
    echo $linea . "<br>";
}

fclose($archivo);

?>