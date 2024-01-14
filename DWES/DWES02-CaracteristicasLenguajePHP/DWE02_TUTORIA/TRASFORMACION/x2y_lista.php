<?php
// Incluyo las funciones
require_once 'funciones_cambio_base.php';
// Mi array de números
$numeros = ['45', 'A5', '687', 'TTR7', '0'];
// Se tiene que acomodar a los números que he definido en el array
$baseOrigen = 12;
// La que quiera
$baseDestino = 2;

// Méter una función en una variable OJO INTERESANTE - use para usar otros parametros
$x2y = function (string $numero) use ($baseOrigen, $baseDestino): string {
    return dec2x(x2dec($numero, $baseOrigen), $baseDestino);
};


//Filtrar erroneos -> preg_match si cumple una expresión regular
$numerosFiltrados = array_filter($numeros, fn ($numero) => preg_match('/^[0-9A-F]*$/', $numero));
// Transformar números de una base a otra
$numerosNuevaBase = array_map($x2y, $numerosFiltrados);
// Calcular el total - lo transforma a decimal y lo suma - valor de partida
// Transformar a la base destino la suma
$total = dec2x(array_reduce($numerosFiltrados, function ($num1, $num2) use ($baseOrigen) {
    return x2dec($num1, $baseOrigen) + x2dec($num2, $baseOrigen);
}, 0), $baseDestino);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversion de base x a base y</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td><?= "Base Origen: $baseOrigen"; ?></td>
                <td><?= "Base Destino: $baseDestino"; ?></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($numerosFiltrados as $key => $numero): ?>
                <tr>
                    <td><?= $numeros[$key]; ?></td>
                    <td><?= $numerosNuevaBase[$key]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2><?= "La suma de todos los números es $total" ?></h2>
</body>
</html>