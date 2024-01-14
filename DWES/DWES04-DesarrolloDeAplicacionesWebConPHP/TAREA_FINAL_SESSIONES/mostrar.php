<?php
session_start();

if(filter_has_var(INPUT_POST, "borrar")){
    if(empty($_SESSION)){
        $mensaje = ["Debes fijar primero las preferencias", "error"];
    } else {
        session_unset();
        session_destroy();
        $mensaje = ["Preferencias borradas", "exito"];
    }
}

$idioma = $_SESSION['idioma'] ?? "No establecido";
$perfil = $_SESSION['perfil']?? "No establecido";
$zonaHoraria = $_SESSION['zonaHoraria'] ?? "No establecido";


?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Preferencias</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    </head>
    <body class="bg-secondary container">
        <main class="d-flex justify-content-center">
            <div class="card mt-5 bg-success-subtle">
                <div class="card-header h3 text-success">
                    <span>
                        <i class="bi bi-person-gear fs-1"></i>
                    </span>
                    Preferencias Usuario
                </div>
                <div class="card-body px-4">
                    
                    <?php if ($mensaje ?? false) : ?>
                    <div class="alert alert-<?= $mensaje[1] == "error" ? "danger":"warning"?>" role="alert"><?= $mensaje[0] ?></div>
                    <?php endif; ?>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success d-flex align-items-center">
                            <div><i class="bi bi-translate"></i></div>
                            <div class="px-2">Idioma: </div>
                            <div class="px-2"><?= $idioma ?></div>
                        </li>
                        <li class="list-group-item list-group-item-success d-flex align-items-center">
                            <div><i class="bi bi-person-lock"></i></div>
                            <div class="px-2">Perfil público: </div>
                            <div class="px-2"><?= $perfil ?></div>
                        </li>
                        <li class="list-group-item list-group-item-success d-flex align-items-center">
                            <div><i class="bi bi-clock"></i></i></div>
                            <div class="px-2">Zona horaria: </div>
                            <div class="px-2"><?= $zonaHoraria ?></div>
                        </li>
                    </ul>

                    <div class="botones mt-4">
                        <form action="<?= $_SERVER['PHP_SELF']?>" method="POST">
                            <a href="./preferencias.php"><button type="button" class="btn btn-success" name="establecer">Establecer Preferencias</button></a>
                            <button type="submit" class="btn btn-outline-danger" name="borrar">Borrar Preferencias</button>
                        </form>
                    </div>



                </div>
            </div>
        </main>
    </body>
</html>

