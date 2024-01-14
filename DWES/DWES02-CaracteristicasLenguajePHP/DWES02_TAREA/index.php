<!DOCTYPE html>
<?php
define("ERROR_NAME", "Debes introducir un nombre válido");
define("ERROR_TAREA", "Debes introducir un número de tarea válido");
define("MSN_EXITO", "Agenda vaciada correctamente");
$errorName = false;
$errorTarea = false;
$tareas = [];
$completadas = [];

function agregar($nombre, &$tareas, &$completadas, &$errorN){
    if (!empty($nombre)) {
        array_push($tareas, "$nombre");
        array_push($completadas, 'No');
    } else {
        $errorN = true;
    }
}

function cambiarBorrar($num, &$tareas,&$completadas, &$errorNum, &$btn) {
   
    if($num) {
        if($btn == 'completa') {
            // Acción boton completar
            $completadas[$num-1] = ($completadas[$num-1] == 'No') ? 'Si' : 'No';
        } else {
            // Acción botón borrar
            array_splice($completadas, $num-1, 1);
            array_splice($tareas, $num-1, 1);
        }
    } else {
        // Error al introducir el número
        $errorNum = true;
    }   
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $tareas = $_POST['arr_tareas'] ?? [];
    $completadas = $_POST['arr_completadas'] ?? [];

    // ¿Boton pulsado?
    $btn = filter_input(INPUT_POST, 'btn', FILTER_SANITIZE_STRING);

    switch ($btn) {
        case 'nueva': 
            $nombre = filter_input(INPUT_POST, 'tarea', FILTER_SANITIZE_STRING);
            agregar($nombre, $tareas, $completadas, $errorName);
            break;
        case 'completa':
        case 'borrar':
            $num = filter_input(INPUT_POST, 'num_tarea', FILTER_SANITIZE_NUMBER_INT);
            $num = filter_var($num, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => count($tareas)]]);
            cambiarBorrar($num, $tareas, $completadas, $errorTarea, $btn);
            break;           
        default:
            echo "error";
    }
    
    
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(!empty($_GET) && $_GET['btn'] == 'vaciar'){
        $tareas = [];
        $completadas = [];
        $vaciado = true;
        // Para limpiar la URL
        header("Refresh: 2; URL=". $_SERVER['PHP_SELF']);

    }
}

?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Agenda de Tareas</title>
    </head>
    <body>
        <main>
            <div class="div_img"><?php include 'img.php'; ?></div>
            <div class="div_form">
                <h1>Agenda de Tareas</h1>
                <?php if(isset($vaciado) && $vaciado): ?>
                    <div class='exito'> <?= MSN_EXITO ?></div>
                <?php endif; ?>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="hidden">
                        <?php foreach ($tareas as $tarea): ?>
                            <input type="hidden" name="arr_tareas[]" value="<?= $tarea; ?>">
                        <?php endforeach; ?>
                        <?php foreach ($completadas as $completa): ?>
                            <input type="hidden" name="arr_completadas[]" value="<?= $completa; ?>">
                        <?php endforeach; ?>
                    </div>

                    <fieldset>

                        <legend>Nueva Tarea</legend>
                        <div class="campo">
                            <label>Tarea</label>
                            <input type="text" name="tarea">
                        </div>
                        <?php if($errorName ?? false): ?>
                            <div class='error'><?= ERROR_NAME ?></div>
                        <?php endif; ?>
                        <div class="botones">
                            <button type="submit" value="nueva" name="btn" class="btn btn-ok">Añadir Tarea</button>
                            <input type="reset" value="Limpiar Campos" class="btn btn-red">
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Lista de Tareas</legend>
                        <?php
                        if (empty($tareas)):
                            echo "<p class='no_tareas'>No hay tareas</p>";
                        else :
                            ?>

                            <table>
                                <tr><th>Número</th><th>Tarea</th><th>Completado</th></tr>

                            <?php
                            for($i = 0; $i < count($tareas); $i++):
                                echo "<tr><td>" . ($i+1) . "</td><td>" . $tareas[$i] . "</td><td>" . $completadas[$i] . "</td></tr>";
                            endfor;
                            ?>

                            </table>

                        <?php endif; ?>
                    </fieldset>

                    <?php if (!empty($tareas)): ?>

                        <fieldset>
                            <legend>Modificar Tareas</legend>
                            <div class="campo">
                                <label>Num Tarea</label>
                                <input type="number" name="num_tarea" max="<?= count($tareas) ?>" min="1">
                                <div class="botones">
                                   <button type="submit" name="btn" value="completa" class="btn btn-ok">Tarea Completada</button>
                                   <button type="submit" name="btn" value="borrar" class="btn btn-red">Borrar Tarea</button>
                                   <button type="submit" name="btn" formaction="<?php $_SERVER['PHP_SELF'] ?>" formmethod="get" value="vaciar" class="btn btn-red">Vaciar Agenda</button>
                                </div>
                                
                            </div>
                            <?php if($errorTarea ?? false): ?>
                                <div class='error'><?= ERROR_TAREA ?></div>
                            <?php endif; ?>                            
                        </fieldset>

                    <?php endif; ?>

                </form>
            </div>
        </main>
        
    </body>
</html>
