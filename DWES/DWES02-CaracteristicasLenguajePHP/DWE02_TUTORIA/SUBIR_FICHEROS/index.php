<?php
    define('RUTA_FICHEROS', '.\ficheros');

    if(empty($_POST)) {
        // Listar los ficheros del directorio sin "." y ".."
        $ficheros = array_filter(scandir(RUTA_FICHEROS), fn($fichero) => $fichero != "." && $fichero !=  ".." );
    } else {
        // Compruebo que se a seleccionado y subido al servidor (temporal)
        if(isset($_FILES['fichero']) && is_uploaded_file($_FILES['fichero']["tmp_name"])) {
            // Moverlo a la carpeta de ficheros (devuelve un boleano)
            if(move_uploaded_file($_FILES['fichero']["tmp_name"], RUTA_FICHEROS . "\\" . $_FILES['fichero']['name'])) {
                $ficheroSubido = [$_FILES['fichero']['name']];
            }
        }
        // Traego los arrays de datos del formulario
        $ficherosSeleccionados = $_POST['ficherosseleccionados'] ?? [];
        $ficherosFormulario = $_POST['ficheros'];
        // Borro los ficheros del servidor
        array_walk($ficherosSeleccionados, function($ficheroBorrar) {
            unlink(RUTA_FICHEROS . "\\" . $ficheroBorrar);
        });
        // Actualizar la variable ficheros - OJO si viene nulo reemplaza por array vacio
            // Mezclar con el fichero subido
            // Quitar los seleccionados
            // Quitar duplicados
        $ficheros = array_unique(array_diff(array_merge($ficherosFormulario, ($ficheroSubido ?? [])), $ficherosSeleccionados));
        
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="stylesheet.css">
        <title>Gestión de ficheros</title>
    </head>
    <body>
        <div class="page">
            <h1>Gestión de ficheros</h1>
            <form class="form" name="gestión_ficheros" 
                  action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="fichero">Nuevo Fichero:</label> 
                    <input id="fichero" type="file" name="fichero" />
                </div>
                <fieldset>         
                    
                    <?php if(empty($ficheros)): ?>
                        <p>El directorio está vacio</p>
                    <?php else : ?>
                        <legend>Selecciona ficheros para borrar</legend>
                        <?php foreach ($ficheros as $fichero) : ?>
                        <label><input type="checkbox" name="ficherosseleccionados[]" value="<?= $fichero ?>">
                            <?= $fichero ?>
                        </label>
                        <input type="hidden" name="ficheros[]" value="<?= $fichero ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </fieldset>
                <div class="submit-seccion">
                    <input class="submit" type="submit" 
                           value="Enviar" name="enviar" /> 
                </div>
            </form> 
        </div>  
    </body>
</html>