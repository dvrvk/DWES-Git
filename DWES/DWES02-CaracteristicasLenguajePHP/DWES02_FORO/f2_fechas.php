<!DOCTYPE html>

<html>

    <head>

        <meta name="viewport" content="width=device-width">

        <meta charset="UTF-8">
        <style>
            p {font-weight: bold;}
        </style>
        <title>Uso DateTime</title>      

    </head>

    <body>

        <p> Crea una instancia de la clase DateTime para la fecha actual </p>
        <?php 
            $hoy = new DateTime();
            var_dump($hoy); 
        ?>

        <p> Cambia el huso horario de la fecha actual a la zona de 'America/Los_Angeles' </p>
        <?php
            // $hoyHuso = new DateTime('now', new DateTimeZone('America/Los_Angeles'));
            // var_dump($hoyHuso);
            $hoy->setTimezone(new DateTimeZone('America/Los_Angeles'));
            var_dump($hoy);
        ?>

        <p> Muestra la fecha actual en un formato específico Año-mes-dia Hora:minuto:segundo </p>
        <?php
            echo($hoy->format('Y-m-d H:i:s'));
        ?>

        <p> Modifica y muestra la fecha según el formato W3C que corresponde a la fecha de hace una semana </p>
        <?php 
            // echo($hoy->modify("-1 week")->format('d/m/Y'));
            echo($hoy->modify("-1 week")->format(DateTime::W3C));
        ?>
        <p> Crea una instancia de la clase DateTime para una fecha específica a partir de la cadena "20/12/2023". Muestra el objeto DateTime </p>
        <?php
            $miFecha = DateTime::createFromFormat('d/m/Y', '20/12/2023');
            var_dump($miFecha);
        ?>

        <p> Muestra la fecha específica en el formato "20 December 2023"</p>
        <?php
            echo $miFecha->format('d F Y');
        ?>

        <p> Muestra el timestamp de dicha fecha </p>
        <?php
            var_dump($miFecha->getTimestamp());
        ?>

        <p> Calcula la diferencia en días entre las fecha actual y la fecha específica </p>
        <?php
            $diferencia = (new DateTime())->diff($miFecha);
            var_dump($diferencia);
            echo "<br>" . $diferencia->format("%a días de diferencia");
            echo "<br>" . $diferencia->days;
        ?>


        <p> Suma un intervalo de tiempo de dos meses a la fecha específica </p>
        <?php
            $miFecha->add(new DateInterval('P2M'));
            var_dump($miFecha);
        ?>

        <p> Resta un intervalo de tiempo de 5 días a la fecha específica </p>
        <?php
            $miFecha->sub(new DateInterval('P5D'));
            var_dump($miFecha);
        ?>


        <p> Compara la fechas actual y la específica para saber cuál es anterior </p> 
        <?php
            $hoy = new DateTime();
            if($hoy < $miFecha) {
                echo "La fecha actual es anterior <br>";
            } else if($hoy == $miFecha) {
                echo "Son iguales";
            } else {
                echo "La fecha concreta es anterior<br>";
            }
            echo "actual<br>";
            var_dump($hoy);
            echo "<br>mi fecha<br>";
            var_dump($miFecha);
        ?>


        <p> Muestra las fechas que hay entre la fecha actual y la específica con un intervalo de una semana </p>
        <?php
            $periodo = new DatePeriod($hoy, new DateInterval('P1W'), $miFecha);
            foreach($periodo as $fecha){
                echo $fecha->format('d/m/Y') . "<br>";
            }

        ?>

    </body>

</html>