<?php
require_once './funciones_cambio_base.php';

// Si se ha invocado con datos
if (!empty($_POST)) {
    $numero = $_POST['numero'];
    $baseOrigen = $_POST['baseorigen'];
    $baseDestino = $_POST['basedestino'];
    // Transformo el número
    $numeroNuevaBase = x2y($numero, $baseOrigen, $baseDestino);
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="stylesheet.css"/>
        <title>Conversión base x a base y</title>
    </head>
    <body>
        <div class="page">
            <h1>Aplicacion de cambio de base</h1>
            <form class="form" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" name="form_cambio_base">
                <div class="input-section">
                    <label for="numero">Número: </label>
                    <input type="text" id="numero" required pattern="[0-9A-F]*" name="numero" value="<?=  ($numero) ?? ''; ?>">
                </div>
                <div class="input-section">
                    <label for="baseorigen">Base origen: </label>
                    <input type="number" id="baseorigen" min="2" max="16" required  name="baseorigen"  value="<?=  ($baseOrigen) ?? ''; ?>" required>
                </div>
                <div class="input-section">
                    <label for="basedestino">Base destino: </label>
                    <input type="number" id="basedestino" min="2" max="16" required  name="basedestino" value="<?=  ($baseDestino) ?? ''; ?>" required>
                </div>
                <?php if(isset($numeroNuevaBase)): ?>
                <div class="input-seccion">
                    <label for="numeronuevabase">Número nueva base: </label>
                    <input type="text" id="numeronuevabase" value="<?= $numeroNuevaBase ?>" readonly>
                </div>
                <?php endif; ?>
                <div class="submit-seccion">
                    <input class="submit" type="submit" value="Cambio de base" name="cambiobase">
                </div>
            </form>
        </div>
    </body>
</html>


