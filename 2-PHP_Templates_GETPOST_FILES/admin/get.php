<?php
    // Extraigo el valor del formulario por el método POST
    $nombre =  $_GET['nombre'];
    $asignatura =  $_GET['asig'];
    $frutas =  $_GET['frutas'] ?? "";
    
    echo $nombre . "-" . $asignatura . "-" . $frutas;
  

 
