<?php 
    function dec2x($num, $base) : string {
        if(empty($num) || empty($base) || $base < 2 || $base > 9) {
            return "Error datos incorrectos";
    
        } else {
            
            $transformacion = "";
            $resultado = $num;
    
            while(intdiv($resultado,$base) >= $base) {
                $transformacion = ($resultado % $base) . $transformacion;
                $resultado = intdiv($resultado, $base);
            }
            $transformacion = ($resultado % $base) . $transformacion;
            $transformacion = intdiv($resultado,$base) . $transformacion;
            return "$num en base 10 = $transformacion en base $base";
        }
    }