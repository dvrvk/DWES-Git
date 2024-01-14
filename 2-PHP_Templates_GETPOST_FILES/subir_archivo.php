<?php
    require './includes/funciones.php';
    incluirTemplate('header');
?>

<h1>Subir archivo</h1>

<form action="/admin/subir.php" method="POST" enctype="multipart/form-data">
    <div class="campo">
        <input type="file" name="fichero" accept=".jpg, .png, .jpeg">
    </div>
    <input type="submit" value="Subir">
</form>

</body>

</html>