<!DOCTYPE html>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <title>Uso de arrays</title>
        <style>
            p {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <p>Crea un array indexado con los nombres de los módulos del primer curso del ciclo de DAW</p>
        <?php
            $modulos1 = ["Bases de datos", "Entornos de Desarrollo", "Formación y Orientación Laboral", "Lenguaje de Marcas y Sistemas de gestión de Información","Programación", "Sistemas Informáticos"];
            print_r($modulos1);
        ?>

        <p>Elimina el elemento correspondiente al índice 3</p>
        <?php 
            array_splice($modulos1,3,1);
            print_r($modulos1);
            // Corrección
            // unset($DAW[3])
        ?>

        <p>Añade de nuevo el elemento correspondiente al índice 3</p>
        <?php
            array_splice($modulos1, 3,0,"Lenguaje de Marcas y Sistemas de gestión de Información");
            print_r($modulos1);
            // Corrección
            // $DAW[3] = "Lenguaje de Marcas y Sistemas de gestión de Información"
        ?> 

        <p>Crea un nuevo array con los tres primeros módulos de DAW1</p>
        <?php
            $nuevoArray = array_slice($modulos1,0, 3);
            print_r($modulos1);
            echo "<br>";
            print_r($nuevoArray);
        ?>
       
        <p>Elimina del array DAW1 los dos últimos módulos y al mismo tiempo crea un nuevo array con dichos módulos</p>
        <?php
            $arrayNuevo = array_splice($modulos1, count($modulos1)-2);
            // Corrección
            //$arrayNuevo = array_splice($modulos1, -2);
            print_r($modulos1);
            echo "<br>";
            print_r($arrayNuevo);
        ?>

        <p>Añade estos elementos de nuevo al array original</p>
        <?php
            foreach($arrayNuevo as $valor){
                array_push($modulos1, $valor);
            }
            print_r($modulos1);
            // Corrección
            //array_splice($modulos1, count($modulos1), 0, $arrayNuevo);

        ?>
        
        <p>Crea un array indexado con los nombres de los módulos de segundo curso del ciclo DAW. Muestra el array de segundo de DAW</p>
        <?php
            $modulos2 = ['DWEC', 'DWES', 'EIE', 'IT', 'DAW', 'DIW'];
            print_r($modulos2);
        ?>

        <p>Crea un array que contenga la unión de los módulos de primero y segundo. Muestra el array de DAW. Muestra el array combinado</p>
        <?php
            $DAW = array_merge($modulos1, $modulos2);
            print_r($DAW);
        ?>  

        <p>Crea un array indexado con los módulos del ciclo de DAM. Muestra el array de DAM</p>
        <?php
           $DAM = ["Bases de datos", "Entornos de Desarrollo", "Formación y Orientación Laboral", "Lenguaje de Marcas y Sistemas de gestión de Información","Programación", "Sistemas Informáticos", "Acceso a datos", "Desarrollo de interfaces", "IT", "Programación de servicios y procesos", "Programación multimedia y dispositivos móviles", "Sistemas de gestión empresarial"];
           print_r($DAM);
        ?>        
        <p>Crea un array con la unión de los módulos de DAW y DAM sin duplicados. Muestra el array completo DAWDAM</p>
        <?php
            $DAWDAM = array_unique(array_merge($DAW, $DAM));
            print_r($DAWDAM);
        ?>

        <p>Comprueba que el módulo 'Desarrollo Web en Entorno Servidor' se encuentre en el array DAWDAM</p>
        <?php
            echo in_array("Entorno Servidor", $DAWDAM) ? "Esta dentro del array" : "No esta en el array";
        ?>
        
        <p>Crea un array con los módulos diferencia entre los elementos de DAW1 y DAWDAM. Muestra el array diferencia</p>
        <?php
            ;
            print_r(array_diff($DAW, $DAWDAM));
            echo "<br>";
            print_r(array_diff($DAWDAM, $DAW));
        ?>
       
        <p>Crea un array con los módulos comunes de DAW y DAM</p>      
        <?php
            print_r(array_intersect($DAW, $DAM));
        ?>

        <p>Muestra un módulo obtenido al azar del array DAWDAM</p>
        <?php
            print_r($DAWDAM[array_rand($DAWDAM)]);
        ?>

        <p>Crea una cadena con todos los nombres de los módulos de primero DAW separados por '-'</p>
        <?php
            var_dump(implode("-", $modulos1));
        ?>

        <p>Ordena los módulos de DAW por orden alfabético descendente. Muestra el array ordenado</p>
        <?php
            rsort($DAW);
            print_r($DAW);
        ?>

        <p>Ordena los módulos de DAW por orden alfabético ascendente sin cambiar los índices. Muestra el array ordenado</p>
        <?php
            asort($DAW);
            print_r($DAW);
        ?>
               

        <p>Crea un array asociativo de los nombres de módulos de DAW cuyos índices son las abreviaturas de los mismos. Muestra el array DAWAsoc</p>
        <?php
            $DAWAsoc = [
                "BD" => "Bases de datos",
                "ED" => "Entornos de desarrollo",
                "FOL" => "Formación y orientación laboral",
                "LMSGI" => "Lenguaje de marcas y sistemas de gestión de información",
                "P" => "Programación",
                "SI" => "Sistemas informáticos",
                "DWEC" => "Desarrollo web en entorno cliente",
                "DWES" => "Desarrollo web en entorno servidor",
                "DIW" => "Diseño de interfaces web",
                "EIE" => "Empresa e iniciativa emprendedora",
                "IT" => "Inglés técnico",
            ];
            print_r($DAWAsoc);
        ?>

        <p>Crea un array con las abreviaturas de los módulos de DAW a partir de DAWAsoc. Muestra el array DAWAbrev</p>
        <?php
            $DAWAbrev = array_keys($DAWAsoc);
            print_r($DAWAbrev);
        ?>

        <p>Comprueba que alguna de las abreviaturas sea 'BD' en el array DAWAsoc</p>
        <?php
            echo array_key_exists('BD', $DAWAsoc) ?"BD existe" : "BD no existe";
        ?>

        <p>Ordena el array asociativo DAWAsoc por orden alfabético ascendente de sus claves. Muestra el array DAWAsoc ordenado</p>
        <?php
            ksort($DAWAsoc);
            print_r($DAWAsoc);
        ?>
       
        <p>Crea un array bidimensional indexado para cada curso y asociativo para cada módulo cuya clave sea la abreviatura del módulo y los datos sean el nombre y el número de horas del módulo. Muestra el array DAWBi</p>
        <?php
            $DAWBi = [
                [
                    "BD" => "Bases de datos, 205",
                    "ED" => "Entornos de desarroll, 90",
                    "FOL" => "Formación y orientación labora, 90",
                    "LMSGI" => "Lenguaje de marcas y sistemas de gestión de información, 140",
                    "P" => "Programación, 270",
                    "SI" => "Sistemas informáticos, 205"
                ],
                [
                    "DWEC" => "Desarrollo web en entorno cliente, 115",
                    "DWES" => "Desarrollo web en entorno servidor, 180",
                    "DIW" => "Diseño de interfaces web, 115",
                    "EIE" => "Empresa e iniciativa emprendedora, 65",
                    "IT" => "Inglés técnico, 40"
                ]
                ];
                print_r($DAWBi);
        ?>

        <p>Realiza un programa que muestre las abreviaturas de los módulos junto con su duración</p>
        <?php
            foreach($DAWBi as $curso){
                foreach($curso as $key=>$valor){
                    echo $key . " - " . explode(",", $valor)[1] . " horas<br>";
                }
            }
        ?>
        
        <p>Muestra la duración del módulo de Desarrollo Web en Entorno Servidor</p>
        <?php
            echo $DAWBi[1]['DWES'] . " horas";
        ?>
       
        <p>Ordena el array bidimensional en orden ascendente de duración y en caso de empate descendente alfabéticamente</p>
        <?php
            // Es importante pasarlo por referencia para que se ordene
           foreach ($DAWBi as &$curso) {
            usort($curso, function($x, $y){
                $mod1 = intval(explode(",",$x)[1]);
                $mod2 = intval(explode(",",$y)[1]);
                if($mod1 < $mod2){
                    return -1;
                } else if ($mod1 > $mod2){
                    return 1;
                } else {
                    return -strcmp($x,$y);
                }
            });

            // Solución
            // $DAWnombres = array_column($DAWBi, 0);
            // $DAWduraciones = array_column($DAWBi, 1);
            // array_multisort($DAWduraciones, SORT_ASC, $DAWnombres, SORT_ASC, $DAWBi);
            
           } 
           print_r($DAWBi);
        ?>
        <p>Crea un array tridimensional indexado para cada curso y asociativo para cada módulo cuya clave sea la abreviatura del módulo y los datos sean el nombre y el número de horas del módulo. Muestra el array DAWTri</p>
        <?php
            $DAWTri = [
                [
                    "BD" => ["Bases de datos", 205],
                    "ED" => ["Entornos de desarrollo", 90],
                    "FOL" => ["Formación y orientación laboral", 90],
                    "LMSGI" => ["Lenguaje de marcas y sistemas de gestión de información", 140],
                    "P" => ["Programación", 270],
                    "SI" => ["Sistemas informáticos", 205]
                ],
                [
                    "DWEC" => ["Desarrollo web en entorno cliente", 115],
                    "DWES" => ["Desarrollo web en entorno servidor", 180],
                    "DIW" => ["Diseño de interfaces web", 115],
                    "EIE" => ["Empresa e iniciativa emprendedora", 65],
                    "IT" => ["Inglés técnico", 40]
                ]
                ];
            echo "<pre>";
            print_r($DAWTri);
            echo "</pre>";
        ?>
        
        <p>Realiza un programa que muestre las abreviaturas de los módulos junto con su duración</p>
        <?php
            foreach($DAWTri as $curso){
                foreach($curso as $key=>$valor){
                    echo $key . " - " . $valor[1] . " horas <br>";
                }
            }
        ?>
       
        <p>Muestra la duración del módulo de Desarrollo Web en Entorno Servidor</p>
        <?php
            echo "Desarrollo Web en Entorno Servidor tiene " .  $DAWTri[1]['DWES'][1] . " horas";
            printf("PI vale %+07.3f", 3.1416)
        ?>
        

    </body>

</html>