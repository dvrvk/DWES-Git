<?php 
    require './includes/funciones.php';
    incluirTemplate('header');
?>
<main>
    <h1>Múltiples</h1>
    <form action="/multiples.php" method="POST">
        <div class="campo">
            <label for="asignatura">Asignatura</label>
            <select name="asignatura[]" id="asignatura" multiple>
                <option value="DWEC">DWEC</option>
                <option value="DWES">DWES</option>
                <option value="DIW">DIW</option>
            </select>
        </div>
        <div class="campo">
            <input type="checkbox" name="frutas[]" id="manzana" value="manzana">
            <label for="manzana">Manzana</label>

            <input type="checkbox" name="frutas[]" id="pera" value="pera">
            <label for="pera">Pera</label>

            <input type="checkbox" name="frutas[]" id="fresa" value="fresa">
            <label for="fresa">Fresa</label>
        </div>
        <input type="submit" value="Enviar">
    </form>
    <?php 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo "<pre>";
            var_dump($_POST['asignatura']);
            echo "</pre>";
            echo "<pre>";
            var_dump($_POST['frutas']);
            echo "</pre>";
        }
    ?>
</main>
<?php 
    incluirTemplate('footer');
?>
</body>
</html>