<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $base = $_POST['base'];
    $numero = $_POST['num'];
    $conversion = 0;
    
    for ($i=0; $i < strlen($numero); $i++) {
        // Sacar el digito
        $digito = substr(strrev((string) $numero), $i, 1);
        // Si no es un número -> lo convierto en numero
        if(!is_numeric($digito)){
            $digito = (ord($digito) - ord('A') + 10);
        }
        $conversion += $digito * pow($base, $i);
    }

}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script transformar decimal</title>
</head>

<body>
    <p>Escribir un script PHP que convierta un número expresado en cualquier base a un número decimal utilizando un algoritmo con estructuras de control</p>
    <form method="POST">
        <label for="num">Número</label>
        <input type="text" name="num" id="num" value="<?= isset($numero) ? $numero : '' ?>">
        <label for="num">Base</label>
        <input type="number" name="base" id="base" value="<?= isset($base) ? $base : '' ?>">
        <input type="submit" value="Transformar">
        <?php
        echo isset($conversion) ? "<p>$conversion</p>": "";
        ?>
    </form>
</body>

</html>