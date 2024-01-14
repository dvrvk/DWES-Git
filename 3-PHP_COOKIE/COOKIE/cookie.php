<?php
    // Crear una cookie setcookie("nombre", valor, expiracion, directorio, dominio, secure, httponly)
    setcookie("Idioma", "es", time()+60*60*24*30, "/", "localhost", false, false);
    // Expiración -> Puedo ponerle cuando expira ---  60 seg * 60 min * 24 horas * 30 dias = 30 dias
    // directorio -> '/' esta disponible en cualquier parte o una carpeta "/POO/"
    // dominio -> en que dominio va a estar disponible
    // secure -> true/false -- solo se crea cuando sea una conexión segura
    // httponly -> true/false -- solo podemos acceder por http (no por lenguaje de scripting como javascript)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookies</title>
</head>
<body>
    <h1><?php echo $_COOKIE['Idioma'] ?></h1>
</body>
</html>