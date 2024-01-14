<?php
// Escribe un script PHP que dado un número decimal y otra base (2-9) lo convierta a la nueva base utilizando un algoritmo con estructuras de control.
function dec2x($num, $base) : string {
    if(empty($num) || empty($base) || $base < 2 || $base > 9) {
        return "Error datos incorrectos";

    } else {
        
        $transformacion = "";
        $resultado = $num;

        while(intdiv($resultado,$base) >= $base) {
            $transformacion = ($resultado % $base) . $transformacion;
            $resultado = intdiv($resultado, $base);
        }
        $transformacion = ($resultado % $base) . $transformacion;
        $transformacion = intdiv($resultado,$base) . $transformacion;
        return "$num en base 10 = $transformacion en base $base";
    }
}


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