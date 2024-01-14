<?php 
    // DIR me da la ubicación del proyecto
    require __DIR__ . '/includes/funciones.php';
    $consulta = obtener_viajes();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pruebas</title>
</head>
<body>
    <div>
        <?php
            while($viaje = mysqli_fetch_assoc($consulta)) {?>
                <div class="viaje">
                    <p class="titulo"><strong><?php echo $viaje['titulo'] ?></strong></p>
                    <p class="precio"><?php echo $viaje['precio'] ?></p>
                    <p class="descripcion"><?php echo $viaje['descripcion'] ?></p>
                </div>
        <?php } ?>
        
    </div>
</body>
</html>