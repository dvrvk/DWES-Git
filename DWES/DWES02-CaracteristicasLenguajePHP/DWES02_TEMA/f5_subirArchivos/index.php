<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );
    echo __DIR__;

    $errorDescarga = true;
    $errorTipo = false;
    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
        if ($_FILES['archivo']['type'] === "application/pdf") {
            move_uploaded_file($_FILES['archivo']['tmp_name'], "./documentos/" . $_FILES['archivo']['name']);
            $errorDescarga = false;
        } else {
            $errorTipo = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir archivos</title>
</head>

<body>
    <h2>Subir fichero PDF</h2>
    <p>Máximo 0.5M</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="500000">
        <input type="file" name="archivo" id="archivo" accept=".pdf">
        <input type="submit" value="Subir">
    </form>
    <?php if (!empty($_FILES)): 
        if ($errorTipo) : ?>
            <p>Error: tipo de archivo incorrecto</p>
        <?php elseif ($errorDescarga) : ?>
            <p>Error: <?= $phpFileUploadErrors[$_FILES['archivo']['error']] ?></p>
        <?php else : ?>
            <p>Archivo subido con exito</p>
        <?php endif;
    endif; ?>

</body>

</html>