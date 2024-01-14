<?php

$host = "localhost";
$db = "proyecto";
$user = "gestor";
$pass = "secreto";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

// Conexión a la base de datos
$conexionbd = new PDO($dsn, $user, $pass);
// Establecer el control de excepciones
$conexionbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   

