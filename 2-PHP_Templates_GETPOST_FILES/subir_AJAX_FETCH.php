<?php
    require './includes/funciones.php';
    incluirTemplate('header');
?>

<h1>Subir archivo</h1>

<form class="formularioAJAX" method="POST" enctype="multipart/form-data">
    <div class="campo">
        <input type="file" name="fichero" accept=".jpg, .png, .jpeg">
    </div>
    <input type="submit" value="Subir">
</form>
<script src="./build/js/ajax.js"></script>
</body>

</html>