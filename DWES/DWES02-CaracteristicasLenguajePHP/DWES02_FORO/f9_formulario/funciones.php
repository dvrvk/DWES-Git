<?php 
    function dec2x($num, $base) : array {
        
        if(empty($num) || empty($base) || $base < 2 || $base > 9 || !is_numeric($num) || !is_numeric($base)) {
            return ["Error datos incorrectos", true];
            
        } else {
            $transformacion = "";
            $resultado = $num;
    
            while(intdiv($resultado,$base) >= $base) {
                $transformacion = ($resultado % $base) . $transformacion;
                $resultado = intdiv($resultado, $base);
            }
            $transformacion = ($resultado % $base) . $transformacion;
            $transformacion = intdiv($resultado,$base) . $transformacion;
            return [$transformacion, false];
        }
    }