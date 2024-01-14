<?php 
    require './includes/funciones.php';
    incluirTemplate('header');
?>
<form action="/admin/get.php" method="GET">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre">
    </div>
    <div class="campo">
        <label for="asig">Asignatura:</label>
        <select name="asig" id="asig">
            <option value="DWEC">DWEC</option>
            <option value="DWES">DWEC</option>
            <option value="Empresa">Empresa</option>
            <option value="Inglés">Inglés</option>
        </select>
    </div>
    <div class="campo">
        <input type="checkbox" id="frutas" name="frutas" value="manzana"><label for="frutas">Manzana</label>
    </div>
    <input type="submit" value="Enviar">
</form>
</body>
</html>