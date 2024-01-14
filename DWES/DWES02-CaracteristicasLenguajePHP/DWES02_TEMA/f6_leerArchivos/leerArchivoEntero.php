<?php

$arrContenido = file("archivo.txt");
print_r($arrContenido);
$contenido = file_get_contents("archivo.txt");

echo $contenido;

?>