<?php
    session_name('LOGIN');
    session_start();
    // Eliminar o destruir toda la información
    session_destroy();
    // Eliminar las variables de sesion
    //session_unset($_SESSION['nombre]);
    echo "Sesion cerrada";
    header('Refresh: 4, URL="index.php"');