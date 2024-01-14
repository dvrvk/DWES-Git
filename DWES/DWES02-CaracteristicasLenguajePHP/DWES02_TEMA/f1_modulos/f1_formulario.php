<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document 1</title>
</head>
<body>
    <form action="./f1_procesa.php" method="post">
        <fieldset>
            <legend>Información del alumno</legend>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre">
        </fieldset>
        <fieldset>
            <legend>Elige los módulos</legend>
            <input type="checkbox" name="modulos[]" id="dwes" value="dwes"><label for="dwes">Desarrollo Web en Entorno Servidor</label>
            <input type="checkbox" name="modulos[]" id="dwec" value="dwec"><label for="dwec">Desarrollo Web en Entorno Cliente</label>
        </fieldset>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>