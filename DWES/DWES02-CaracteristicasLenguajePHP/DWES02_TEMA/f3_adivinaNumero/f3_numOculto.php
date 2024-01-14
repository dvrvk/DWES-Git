<?php

$acierto = false;
define('MAX_INTENTOS', '5');

if(!empty($_POST) && isset($_POST['apuesta'])) {
    $intentos = ++$_POST['intentos'];
    $numero = $_POST['numero'];
    $numero_oculto = $_POST['numero_oculto'];
    $numeros = (!empty($_POST['numeros']) ? explode(',', $_POST['numeros']) : []);
    array_push($numeros, $numero);
    
    if($numero == $numero_oculto) {
        $acierto = true;
    }
    
} else {
    $intentos = 0;
    $numeros = [];
    $numero_oculto = mt_rand(1,20);
    //echo $numero_oculto;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adivina el número</title>
    <style>
        h1 {
            text-align: center;
        }

        form {
            border: 5px solid orange;
            padding: 20px;
            margin: 0 20%;
        }

        div {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }
        
        .info {
            flex-direction: column;
        }
        
        p {
            margin: 1px;
        }
    </style>
</head>

<body>
    <h1>Adivina el numero oculto</h1>
    <form method="post">
        <div>
            <label for="numero">Enter a número (1-20)</label>
            <input type="number" name="numero" id="numero" min="1" max="20">
        </div>
        
        <?php if(!$acierto && $intentos < MAX_INTENTOS): ?>
        <div>
            <input type="submit" name="apuesta" value="Apuesta">
        </div>
        
        <?php if($intentos > 0): ?>
        <div class="info">
           <p>Intentos respantes: <?= MAX_INTENTOS - $intentos ?></p>
            <p>Intentalo con un número más <?= ($numero_oculto > $numero) ? "alto" : "bajo" ?></p>
            <p>Ya has jugado con los números <?= implode(',', $numeros) ?></p> 
        </div>
        <?php endif;
        endif; ?>
        
        <div>
            <input type="hidden" id="intentos" name="intentos" value=<?php echo $intentos; ?>>
            <input type="hidden" id="numeros" name="numeros" value=<?php echo (!empty($numeros)) ? implode(",", $numeros) : '' ; ?>>
            <input type="hidden" id="numero_oculto" name="numero_oculto" value=<?php echo $numero_oculto; ?>>
        </div>
        
        <?php if($acierto): ?>
        <div class="info">
           <button type="submit" name="nuevo" id="nuevo">Nuevo Juego</button> 
           <p>¡Enhorabuena! Lo has acertado en <?= $intentos ?> intento<?= ($intentos > 1) ? "s" : "" ?> </p>
        </div>
        <?php endif; ?>
        
        <?php if(!$acierto && $intentos >= MAX_INTENTOS) : ?>
        <div class="info">
            <button type="submit" name="nuevo" id="nuevo">Nuevo Juego</button>
            <p>Lo sentimos, has gastado todos tus intentos.</p>
        </div>
        <?php endif; ?>
    </form>
</body>

</html>

