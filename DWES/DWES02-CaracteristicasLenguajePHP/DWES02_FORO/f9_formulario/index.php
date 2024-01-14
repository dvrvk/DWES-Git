<?php

include "funciones.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['num'];
    $base = $_POST['base'];
    $respuesta = dec2x($numero, $base);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Script transformar base 10</title>
</head>

<body>
    <main>
        <h1>Conversión de Números</h1>
        <form method="POST">
            <div class="campo">
                <label for="num">Número</label>
                <input type="number" name="num" id="num"
                value="<?= isset($numero) ? $numero : ''; ?>">
            </div>
            <div class="campo">
                <label for="base">Base</label>
                <input type="number" name="base" id="base" min="2" max="9"
                value="<?= isset($base) ? $base : ''; ?>">
            </div>
            <input type="submit" value="Convierte" class="btn">
            <div class="campo">
                <label for="result">Resultado</label>
                <input type="text" name="result" id="result"
                value="<?php echo (isset($respuesta) && !$respuesta[1]) ? $respuesta[0] : ''; ?>">
            </div>
            <?php
                echo (isset($respuesta) && $respuesta[1])
                ? "<div class='error'>" . $respuesta[0] . "<div>"
                 : ''; ?>
        </form>
               
    </main>
</body>

</html>