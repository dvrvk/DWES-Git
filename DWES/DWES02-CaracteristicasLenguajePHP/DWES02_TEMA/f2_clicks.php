<?php
$numClicks = 0;
if (!empty($_POST)) {
    $numClicks = $_POST['num_clicks'];
    $numClicks++;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
            <h1>El número de clicks hasta ahora es: <?php echo $numClicks; ?></h1>
            <input type="hidden" id="id" name="num_clicks" value=<?php echo $numClicks; ?>> <!-- Valor oculto incrustado en el formulario -->
            <input type="submit" value="Click" name="click">  
        </form>
        <?php
        ?>
    </body>
</html>