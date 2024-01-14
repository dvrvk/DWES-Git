<?php
$archivo = fopen("archivo.txt", "w");

// Escribir en el archivo
fwrite($archivo, "Hola, mundo!\n");

fclose($archivo);
?>