<?php
    if($_POST['user'] == "Diego" && $_POST['pass'] == "1234") {
        session_name('LOGIN');
        session_start();

        $_SESSION['nombre'] = "Diego";
        $_SESSION['Apellido'] = "Vazquez";
        $_SESSION['pais'] = "España";

        echo "Sesion iniciada";
        header('Refresh: 5, URL="dashboard.php"');
    } else {
        echo "Datos incorrectos";
        header('Refresh: 5, URL="index.php"');
    }