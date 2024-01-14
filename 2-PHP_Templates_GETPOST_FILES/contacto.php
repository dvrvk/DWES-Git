<?php
    require './includes/funciones.php';
    incluirTemplate('header');
?>
<main>
    <p>
    <?php 
        $pass = '123456';
        echo "pass - " . $pass;
        echo "<br>";
        
        // Utiliza números y letras - No son seguros
        echo "md5 -" . md5($pass) . "<br>";
        echo "sha1 - " . sha1($pass) . "<br>";
        // hash(algoritmo, clave) -> soporta múltiples algoritmos
        echo "hash -" . hash("md5", $pass) . "<br>";    
        // Todos los algoritmos
        foreach(hash_algos() as $algoritmo){
            echo $algoritmo . " ";
        }
        echo "<br>";

        // Función más recomendable
        // password_hash($password, algoritmo) 
        //PASSWORD_DEFAULT -> creará uno diferente cada vez
        //PASSWORD_BCRYPT -> Otro algoritmo. 
        $passProcesada = password_hash($pass, PASSWORD_DEFAULT);
        echo $passProcesada . "<br>";
        echo password_hash($pass, PASSWORD_BCRYPT) . "<br>";

        // Verificar el password
        echo "correcta->" . password_verify('123456', $passProcesada) . "<br>";
        echo "incorrecta->" . password_verify('13578', $passProcesada);


        ?>
        

    </p>
</main>
<?php 
    incluirTemplate('footer');
?>
</body>
</html>