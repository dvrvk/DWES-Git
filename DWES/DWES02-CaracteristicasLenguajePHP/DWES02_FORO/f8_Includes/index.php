<?php

include "funciones.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respuesta = dec2x($_POST['num'], $_POST['base']);   
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script transformar base 10</title>
</head>

<body>
    <p>Escribir un script PHP que convierta un número expresado en cualquier base (2 a 9) a un número decimal utilizando un algoritmo con estructuras de control</p>
    <form method="POST">
        <label for="num">Número Decimal</label>
        <input type="number" name="num" id="num">
        <label for="num">Nueva Base</label>
        <input type="number" name="base" id="num" min="2" max="9">
        <input type="submit" value="Transformar">
        <?php
        echo isset($respuesta) ? "<p>$respuesta</p>": "";
        ?>
    </form>
</body>

</html>