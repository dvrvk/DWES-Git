<?php

session_start();
// Opciones
define("IDIOMAS_ARR", ["es"=>"Español", "en"=>"Inglés"]);
define("PERFIL_ARR", ["si", "no"]);
define("ZONAHORARIA_ARR", ["GMT-2", "GMT-1","GMT", "GMT+1", "GMT+2"]);

if(filter_has_var(INPUT_POST, "establecer")){

    $idioma = filter_input(INPUT_POST, "idioma", FILTER_UNSAFE_RAW);
    $perfil = filter_input(INPUT_POST, "perfil", FILTER_UNSAFE_RAW);
    $zonaHoraria = filter_input(INPUT_POST, "zonaHoraria", FILTER_UNSAFE_RAW);
    
    $_SESSION['idioma'] = $idioma;
    $_SESSION['perfil'] = $perfil;
    $_SESSION['zonaHoraria'] = $zonaHoraria;
    $mensaje = ["Preferencias de usuario guardadas", "exito"];
} else {
    $idioma = $_SESSION['idioma'] ?? "";
    $perfil = $_SESSION['perfil'] ?? "";
    $zonaHoraria = $_SESSION['zonaHoraria'] ?? "";
    
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Preferencias</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    </head>
    <body class="bg-secondary container">
        <main class="d-flex justify-content-center">
            <div class="card mt-5">
                <div class="card-header h3">
                    Preferencias Usuario
                </div>
                <div class="card-body px-4">
                    <?php if($mensaje ?? false) : ?>
                    <div class="alert alert-<?= $mensaje[1] == "error" ? "danger":"success"?>" role="alert"><?= $mensaje[0] ?></div>
                    <?php endif; ?>
                    
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <div class="campo mt-2">
                            <label for="idioma" class="form-label">Idioma</label>
                            <div class="input-group">
                                <span class="input-group-text" id="idiomaIcono">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-translate" viewBox="0 0 16 16">
                                    <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286zm1.634-.736L5.5 3.956h-.049l-.679 2.022z"/>
                                    <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zm7.138 9.995q.289.451.63.846c-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6 6 0 0 1-.415-.492 2 2 0 0 1-.94.31"/>
                                    </svg>
                                </span>
                                <select class="form-select" id="idioma" name="idioma" aria-describedby="idiomaIcono" required>
                                    <option <?= $idioma == "" ? "selected" : "" ?> disabled value="0">Selecciona idioma</option>
                                    <?php foreach(IDIOMAS_ARR as $claveIdioma=> $valorIdioma): ?>
                                    <option value="<?= $claveIdioma ?>" <?= $idioma == $claveIdioma ? "selected" : ""?>><?= $valorIdioma ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="campo mt-2">
                            <label for="perfil" class="form-label">Perfil público</label>
                            <div class="input-group">
                                <span class="input-group-text" id="perfilIcono">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lock" viewBox="0 0 16 16">
                                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m0 5.996V14H3s-1 0-1-1 1-4 6-4q.845.002 1.544.107a4.5 4.5 0 0 0-.803.918A11 11 0 0 0 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664zM9 13a1 1 0 0 1 1-1v-1a2 2 0 1 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1"/>
                                    </svg>
                                </span>
                                <select class="form-select" id="perfil" name="perfil" aria-describedby="perfilIcono" required>
                                    <option <?= !$perfil ? "selected" : "" ?> disabled value="0">Selecciona opción</option>
                                    <?php foreach(PERFIL_ARR as $valorP) : ?>
                                    <option value="<?=$valorP?>" <?= $perfil == $valorP ? "selected" : ""?>><?= ucfirst($valorP) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="campo mt-2">
                            <label for="zonaHoraria" class="form-label">Zona Horaria</label>
                            <div class="input-group">
                                <span class="input-group-text" id="zonaHorariaIcono">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                                    </svg>
                                </span>
                                <select class="form-select" id="zonaHoraria" name="zonaHoraria" aria-describedby="zonaHorariaIcono" required>
                                    <option <?= !$zonaHoraria ? "selected" : "" ?> disabled value="0">Selecciona opción</option>
                                    <?php foreach (ZONAHORARIA_ARR as $zonaValor) : ?>
                                    <option value="<?= $zonaValor?>" <?= $zonaValor == $zonaHoraria ? "selected " : "" ?>><?= $zonaValor ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="botones mt-4">
                           <a href="mostrar.php"><button type="button" class="btn btn-primary" name="mostrar">Mostrar Preferencias</button></a>
                           <button type="submit" class="btn btn-success" name="establecer">Establecer Preferencias</button>
                        </div>
                    </form>

                    
                </div>
            </div>
        </main>
    </body>
</html>