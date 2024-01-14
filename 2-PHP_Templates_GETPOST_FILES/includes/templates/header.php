<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/build/css/normalize.css">
    <link rel="stylesheet" href="/build/css/app.css">
    <title>Mi página</title>
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : '' ?>">
        <h1><a href="/">MisHerramientas</a></h1>
        <nav>
            <a href="/contacto.php">Encriptado</a>
            <a href="/getPost.php">Get&Post</a>
            <a href="/multiples.php">Múltiples</a>
            <a href="/subir_archivo.php">Subir Archivo</a>
            <a href="/subir_AJAX_FETCH.php">Subir AJAX</a>
        </nav>
    </header>