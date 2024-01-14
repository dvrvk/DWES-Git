<?php
if (!empty($_POST)) {
    define("ERROR_EMPTY", "*El campo es obligatorio");
    define("ERROR_EXTEND", "*Error: extensión máxima de ");
    // Extraigo datos del formulario
    $codFamilia = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_STRING);
    $nomFamilia = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);

    if (empty($codFamilia)) {
        $errorCod = ERROR_EMPTY;
    } else if (strlen($codFamilia) > 6) {
        $errorCod = ERROR_EXTEND . 6 . " caracteres.";
    }

    if (empty($nomFamilia)) {
        $errorName = ERROR_EMPTY;
    } else if (strlen($nomFamilia) > 200) {
        $errorName = ERROR_EXTEND . 200 . " caracteres.";
    }

    if (!isset($errorCod) && !isset($errorName)) {
        // Datos de la conexión
        $host = "localhost";
        $db = "proyecto";
        $user = "gestor";
        $pass = "secreto";
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        
        // Formateo la información
        $codFamilia = strtoupper($codFamilia);
        $nomFamilia = ucfirst($nomFamilia);

        try {
            // Creo la conexión y establezco los errores como excepciones
            $conexionBD = new PDO($dsn, $user, $pass);
            $conexionBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Realizo la insercion
            $insertion = "INSERT INTO familias(cod, nombre) VALUES (:codFamilia,:nomFamilia)";
            $stmtInsertion = $conexionBD->prepare($insertion);
            // Introduzco los parametros
            $stmtInsertion->bindParam(':codFamilia', $codFamilia, PDO::PARAM_STR, 6);
            $stmtInsertion->bindParam(':nomFamilia', $nomFamilia, PDO::PARAM_STR, 200);
            // Ejecuto
            $resultado = $stmtInsertion->execute();
            
        } catch (PDOException $ex) {
            $error = "Problema al insertar familia: " . $ex->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Consulta Productos</title>
        <style>
            h1 {
                text-align: center;
            }

            .container {
                border: 4px solid orange;
                padding: 10px;
                margin: auto;
                width: 30%;
            }

            form {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .campo {
                display: flex;
                justify-content: space-between;
            }

            .btn {
                max-width: 100px;
                margin: 0 auto;
            }

            .error {
                background-color: orangered;
                color: white;
                padding: 10px;
                border-radius: 10px;
            }

            .errorInput {
                color: orangered;
            }

            .exito {
                background-color: limegreen;
                color: white;
                padding: 10px;
                border-radius: 10px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <main>
            <h1>Insertar una familia de productos</h1>
            <div class="container">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="campo">
                        <label for="codigo">Código: </label>
                        <input type="text" id="codigo" name="codigo" class="input" value="<?= ($codFamilia ?? false) ?>">
                    </div>
                    <?= ($errorCod ?? false) ? "<div class='errorInput'>$errorCod</div>" : "" ?>
                    <div class="campo">
                        <label for="nombre">Nombre: </label>
                        <input type="text" id="nombre" name="nombre" class="input" value="<?= ($nomFamilia ?? false) ?>">
                    </div>
                    <?= ($errorName ?? false) ? "<div class='errorInput'>$errorName</div>" : "" ?>
                    <input type="submit" value="Crear" name="crear" class="btn">
                </form>
                <?php if ($resultado ?? false): ?>
                <p class='exito'><?= $stmtInsertion->rowCount() ?> familia insertada con exito.</p>
                <?php elseif ($error ?? false): ?>
                    <p class='error'><?= $error ?></p>
                <?php endif; ?>
            </div>

        </main>

    </body>
</html>
<?php
if (isset($conexionBD)) {
    $stmtInsertion = null;
    $conexionBD = null;
    
}
?>

