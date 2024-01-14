<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla pares hasta 10</title>
    <style>
        body {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
        }
        div {
            border: 1px solid black;
            padding: 0 10px;
        }
    </style>
</head>
<body>
    <?php
        // Realiza un script PHP que genere una página que muestre las tablas de los números pares hasta la tabla del 10.
        for ($i=0; $i <= 10 ; $i++) { 
            if($i % 2 == 0){
                $respuesta = "<div><h2>Tabla del $i</h2><ul>";
                for ($j=0; $j <= 10; $j++) {
                    $resultado = $i * $j;
                    $respuesta = $respuesta . "<li>$i x $j = $resultado </li>";
                }
                echo $respuesta . "</ul></div>";    
            }
        }
    ?> 
</body>
</html>
