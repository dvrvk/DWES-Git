<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $base = $_POST['base'];
    $numeroInicial = $_POST['num'];
    $numero = $_POST['num'];
    $conversion = "";
    
    while($numero >= $base) {
        // Saco el resto
        $resto = ($numero % $base);
        // Si es mayor que 9 lo tengo que convertir a letra
        if($resto > 9) {
            $conversion = chr($resto + ord('A') - 10) . $conversion;
        } else {
            $conversion = (string) $resto . $conversion;
        }
        $numero = intdiv($numero, $base);
    }

    // Importante volver a comprobar si es mayor de 9
    $conversion = ((($numero > 9) ? chr($numero + ord('A') - 10) : (string) $numero) . $conversion);

}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script transformar cualquier base</title>
</head>

<body>
    <p>Escribir un script PHP que convierta un número decimal en cualquier base utilizando un algoritmo con estructuras de control</p>
    <form method="POST">
        <label for="num">Número</label>
        <input type="text" name="num" id="num" value="<?= isset($numeroInicial) ? $numeroInicial : '' ?>">
        <label for="num">Base</label>
        <input type="number" name="base" id="base" value="<?= isset($base) ? $base : '' ?>">
        <input type="submit" value="Transformar">
        <?php
        echo isset($conversion) ? "<p>$conversion</p>": "";
        ?>
    </form>
</body>

</html>