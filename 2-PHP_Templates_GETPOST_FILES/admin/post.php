<?php
    // Extraigo el valor del formulario por el método POST
    $nombre =  $_POST['nombre'];
    $asignatura =  $_POST['asig'];
    $frutas =  $_POST['frutas'];
    
    echo $nombre . "-" . $asignatura . "-" . $frutas;
