<?php
// Realiza la validación de los datos del formulario de la aplicación dec2x. Elimina las validaciones realizadas en HTML y realiza las mismas validaciones en el servidor. La aplicación debe indicar en el formulario que dato no es correcto.

include "funciones.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = filter_input(INPUT_POST, 'num', FILTER_SANITIZE_NUMBER_INT);
    $base = filter_input(INPUT_POST, 'base', FILTER_SANITIZE_NUMBER_INT);
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
                <input type="text" name="num" id="num" value="<?= isset($numero) ? $numero : ''; ?>">
            </div>
            <div class="campo">
                <label for="base">Base</label>
                <input type="text" name="base" id="base" value="<?= isset($base) ? $base : ''; ?>">
            </div>
            <input type="submit" value="Convierte" class="btn">
            <div class="campo">
                <label for="result">Resultado</label>
                <input type="text" name="result" id="result" value="<?php echo (isset($respuesta) && !$respuesta[1]) ? $respuesta[0] : ''; ?>">
            </div>
            <?php
            echo (isset($respuesta) && $respuesta[1])
                ? "<div class='error'>" . $respuesta[0] . "<div>"
                : ''; ?>
        </form>

    </main>
</body>

</html>