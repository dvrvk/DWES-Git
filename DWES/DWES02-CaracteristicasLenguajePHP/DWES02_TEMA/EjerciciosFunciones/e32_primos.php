<?php
    function primos($inicio, $cantidad = 10) {
        $primos = [];
        for ($i=$inicio; $i <= $cantidad; $i++) { 
            if(isPrimo($i)) {
                array_push($primos, (int)$i);
            }
        }
        return $primos;
    }

    function isPrimo($numero) {
        if($numero == 1) {
            return true;
        } else {
            for ($i=2; $i < $numero; $i++) { 
                if($numero % $i == 0) {
                    return false;
                }
            }
            return true;
        }
    }

    if(!empty($_POST)){
        $inicio = $_POST['inicio'] ?? 0;
        $cantidad = (filter_input(INPUT_POST, "cantidad", FILTER_VALIDATE_INT)) ?: 10;
        $primos = primos($inicio, $cantidad);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio Argumentos</title>
</head>
<body>
    <h1>Calcula los primos</h1>
    <p>Introduce un número de inicio y una cantidad (opcional) para calcular los números primos entre ellos.</p>
    <form method="POST">
        <label for="inicio">Inicio</label>
        <input type="number" name="inicio" id="inicio" min="1">
        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad">
        <input type="submit" value="Enviar">
    </form>
    <?php 
    if(isset($primos)) {
        echo "<p>Cantidad de primos " . count($primos) ."</p>";
        echo "<p> Primos: " . implode(",", $primos) . "</p>"; 
    }
    ?>
</body>
</html>