<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo $_POST['nombre'] . "<br>";
        isset($_POST['modulos']) ? print_r($_POST['modulos']) : print("No tiene modulos");
        // Hace que vuelva a la página anterior tras 5 seg
        header("Refresh: 5; URL=f1_formulario.php");

    } else { 
        header('Location: f1_formulario.php');
    }