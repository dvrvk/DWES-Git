<?php
// Escribir un script PHP que convierta un número expresado en cualquier base (2 a 9) a un número decimal utilizando un algoritmo con estructuras de control.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num = $_POST['num'];
    $base = $_POST['base'];
    if(empty($num) || empty($base) || $base < 2 || $base > 9) {
        $respuesta = "Error datos incorrectos";
    } else {
        $decimal = 0;
        $len = strlen($num);
        for ($i = 0, $cifra = $len-1; $i < $len; $i++, $cifra--) {
            $decimal += (int)$num[$cifra] * pow($base, $i);
        }
        $respuesta = "$num en base $base = $decimal en base 10";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script transformar base</title>
</head>

<body>
    <p>Escribir un script PHP que convierta un número expresado en cualquier base (2 a 9) a un número decimal utilizando un algoritmo con estructuras de control</p>
    <form method="POST">
        <label for="num">Número</label>
        <input type="number" name="num" id="num">
        <label for="num">Base</label>
        <input type="number" name="base" id="num" min="2" max="9">
        <input type="submit" value="Transformar">
        <?php
        echo isset($decimal) ? "<p>$respuesta</p>": "";
        ?>
    </form>
</body>

</html>