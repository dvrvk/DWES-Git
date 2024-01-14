<?php
    // Eliminar cookie - poner el tiempo de expiración ya pasado
    setcookie("Idioma", "es", time()-60, "/", "localhost", false, false);